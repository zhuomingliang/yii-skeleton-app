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
			$this->Owner->{$this->created} = new CDbExpression('NOW()');
		else
			$this->Owner->{$this->modified} = new CDbExpression('NOW()');
			
		return true;	
	}
}