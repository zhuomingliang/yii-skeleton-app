<?php
class AutoTimestampBehavior extends CActiveRecordBehavior {
	/**
	* The field that stores the creation time
	*/
	public $created = 'created';
	/**
	* The field that stores the modification time
	*/
	public $modified = 'modified';
	
	
	public function beforeValidate($on) {
		if ($this->Owner->isNewRecord)
			if ($this->created !== null) {$this->Owner->{$this->created} = new CDbExpression('NOW()');}
		else
			if ($this->modified !== null) {$this->Owner->{$this->modified} = new CDbExpression('NOW()');}
			
		return true;	
	}
}