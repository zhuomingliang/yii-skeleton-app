<?php
class ParseCacheBehavior extends CActiveRecordBehavior {
	/**
	* The name of the method in model used to parse the attributes.  Signature must be
	*
	* public function <methodName>($attribute) {
	* 	return <parsed $attribute>;
	* }
	*	
	* Defaults to 'parseMarkdown', which is a method contained in this behavior
	* Please see parseMarkdown() for an example if you wish to use your own method
	*/
	public $parserMethod = 'parseMarkdown';
	public $safeTransform = true;
	/**
	* Array of attributes to cache
	*/
	public $attributes = array();

	/**
	* Suffix of the attribute that the parsed attribute is stored in.
	*/
	public $suffix = 'Parsed';
	
	/**
	* Whether to perform the parsing/caching in beforeValidate(). This is often
	* wanted.  If set to false, it will instead parse it in beforeSave.  You can also of course
	* perform the parsing/caching anywhere you want by calling parseAttributes()
	* Defaults to true.
	*/
	public $parseBeforeValidate = true;
	
	protected $parsed = false;
	protected $_markdownParser = null;
	
	public function beforeValidate($scenario) {
		if (!$this->parsed && $this->parseBeforeValidate)
			$this->parseAttributes();
		return true;
	}
	
	/**
	* Parses data with Markdown and HTMLPurifier
	*/
    public function parseMarkdown($attribute) {
    	$parser = $this->getMarkdownParser();
    	if ($this->safeTransform)
			return $parser->safeTransform($this->Owner->{$attribute});
		else
			return $parser->transform($this->Owner->{$attribute});
	}
	protected function getMarkdownParser() {
		if($this->_markdownParser===null)
			$this->_markdownParser = new CMarkdownParser;
		return $this->_markdownParser;
	}
	
	/**
	* Gets parsed/cached $attribute.  If it is not parsed yet it will parse the original content and cache it
	* It may not be parsed already if you installed this behavior after some data was already entered
	*/
	public function getParsed($attribute) {
		$attributeParsed = $attribute.$this->suffix;
		if (empty($this->Owner->{$attributeParsed}) && !empty($this->Owner->{$attribute})) {
			//not parsed
			//could be because data was put into the table manually and not with app
			$attributes = $this->attributes;
			array_walk($attributes, 'ParseCacheBehavior::addSuffixes', $this->suffix);
			$this->Owner->save(false, $attributes);
		}
		return $this->Owner->{$attributeParsed};
	}
	protected static function addSuffixes(&$value, $key, $suffix){
	    $value .= $suffix;
	}
	public function parseAttributes() {
		$this->parsed = true;
		
		foreach ($this->attributes as $attribute) {
			$attributeParsed = $attribute.$this->suffix;
			$this->Owner->{$attributeParsed} = $this->Owner->{$this->parserMethod}($attribute);
		}
	}

	public function beforeSave($event) {
		if (!$this->parsed)
			$this->parseAttributes();
	}
	
}