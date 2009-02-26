<?php
class ParseCacheBehavior extends CActiveRecordBehavior {
	/**
	* The name of the method in model used to parse column.  Signature must be
	*
	* public function <methodName>($column) {
	* 	return <parsed $column>;
	* }
	*	
	* Defaults to 'parseMarkdown', which is a method contained in this behavior
	* Please see parseMarkdown() for an example if you wish to use your own method
	*/
	public $parserMethod = 'parseMarkdown';
	
	/**
	* Array of columns to cache
	*/
	public $columns = array();

	/**
	* Suffix of the column that the parsed column is stored in.
	*/
	public $suffix = 'Parsed';
	
	/**
	* Whether to perform the parsing/caching in beforeValidate(). This is often
	* wanted.  If set to false, it will instead parse it in beforeSave.  You can also of course
	* perform the parsing/caching anywhere you want by calling cacheColumns()
	* Defaults to true.
	*/
	public $parseBeforeValidate = true;
	
	protected $parsed = false;
	protected $_markdownParser = null;
	
	public function beforeValidate($scenario) {
		if (!$this->parsed && $this->parseBeforeValidate)
			$this->parseColumns();
		return true;
	}
	
	/**
	* Parses data with Markdown and HTMLPurifier
	*/
    public function parseMarkdown($column) {
    	$parser = $this->getMarkdownParser();
		return $parser->safeTransform($this->Owner->{$column});
	}
	protected function getMarkdownParser() {
		if($this->_markdownParser===null)
			$this->_markdownParser = new CMarkdownParser;
		return $this->_markdownParser;
	}
	
	/**
	* Gets parsed/cached $column.  If it is not parsed yet it will parse the original content and cache it
	* It may not be parsed already if you installed this behavior after some data was already entered
	*/
	public function getParsed($column) {
		$attributeParsed = $column.$this->suffix;
		if (empty($this->Owner->{$attributeParsed}) && !empty($this->Owner->{$column})) {
			//not parsed
			//could be because data was put into the table manually and not with app
			$attributes = $this->columns;
			array_walk($attributes, 'ParseCacheBehavior::addSuffixes', $this->suffix);
			$this->Owner->save(false, $attributes);
		}
		return $this->Owner->{$attributeParsed};
	}
	protected static function addSuffixes(&$value, $key, $suffix){
	    $value .= $suffix;
	}
	public function parseColumns() {
		$this->parsed = true;
		
		foreach ($this->columns as $column) {
			$attributeParsed = $column.$this->suffix;
			$this->Owner->{$attributeParsed} = $this->Owner->{$this->parserMethod}($column);
		}
	}

	public function beforeSave($event) {
		if (!$this->parsed)
			$this->parseColumns();
	}
	
}