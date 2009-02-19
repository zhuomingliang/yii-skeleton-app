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
	* Whether to perform the parsing/caching in beforeValidate(). This is often
	* wanted if for instance you have a "post preview" module.  You can also of course
	* perform the parsing/caching anywhere you want by calling $this->cacheColumns()
	* Defaults to false.
	*/
	public $cacheBeforeValidate = false;
	
	protected $caches = array();
	protected $cached = false;
	protected $_markdownParser = null;
	
	public function beforeValidate($scenario) {
		if (!$this->cached && $this->cacheBeforeValidate)
			$this->cacheColumns();
		return true;
	}
	
	/**
	 * Returns relation needed for model
	 */
	public function parseCacheRelation() {
		return array(CActiveRecord::HAS_MANY, 'ParseCache', 'id', 'on'=>'`table`=\''.$this->Owner->tableName().'\'');	
	}
	
	/**
	* Parses cache with Markdown and HTMLPurifier
	*/
    public function parseMarkdown($column) {
    	$parser = $this->getMarkdownParser();
		return $parser->safeTransform($this->Owner->{$column});
	}
	public function getMarkdownParser() {
		if($this->_markdownParser===null)
			$this->_markdownParser = new CMarkdownParser;
		return $this->_markdownParser;
	}
	
	/**
	* Gets parsed/caches $column.  If it is not loaded from the database already it will
	* load it.  You may use eager loading as usual with "with()", which will be more
	* optimal in some cases
	*/
	public function getCache($column) {
		if (!isset($this->caches[$column])) {
			$this->caches[$column] = ParseCache::model()->find("`table`='".$this->Owner->tableName()."' AND `id`=".$this->Owner->id." AND `column`='".$column."'");
			if (!$this->caches[$column]) {
				//cache not in database
				//could be because data was put into the table manually and not with app
				$parseCache = new ParseCache;
				$parseCache->table = $this->Owner->tableName();
				$parseCache->id = $this->Owner->id;
				$parseCache->column = $column;
				$parseCache->content = $this->Owner->{$this->parserMethod}($column);
				$this->caches[$column] = $parseCache;
				$this->caches[$column]->save(false);
			}
		}
		return $this->caches[$column]->content;
	}
	public function cacheColumns() {
		$this->cached = true;
		
		foreach ($this->columns as $column) {
			$this->caches[$column] = new ParseCache;
			$this->caches[$column]->table = $this->Owner->tableName();
			$this->caches[$column]->id = $this->Owner->id;
			$this->caches[$column]->column = $column;
			$this->caches[$column]->content = $this->Owner->{$this->parserMethod}($column);
		}
	}
	public function afterFind($event) {
		if ($this->Owner->hasRelated('parsecache')) {
			foreach ($this->Owner->parsecache as $cache) {
				$this->caches[$cache->column] = $cache;
			}
		}
	}
	public function afterSave($event) {
		if (!$this->cached)
			$this->cacheColumns();
		
		if (!$this->Owner->isNewRecord)
			ParseCache::model()->deleteAll("`table`='".$this->Owner->tableName()."' AND `id`=".$this->Owner->id);

		foreach ($this->caches as $column => $cache) {
			$cache->save(false);
		}
	}
	
}