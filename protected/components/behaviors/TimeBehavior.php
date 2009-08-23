<?php
/**
* This behavior implants time handling.  Once this is attached to a model, you may use Html::activeDatetime()
* In beforeValidate() this behavior will calculate the actual date and time based on the
* data that the user inputted.
* In afterFind(), it will decompile the date and time so that it may work with Html::activeDatetime()
* 
* 	public function behaviors(){
*		return array(
*			'TimeBehavior' => array(
*				'class' => 'TimeBehavior',
*				'fields' => array('dateAttributeA', 'dateAttributeB', ...),
*			)
*		);
*	}
*/
class TimeBehavior extends CActiveRecordBehavior {
	/**
	* List of fields that this behavior should handle.
	* 
	* @var array
	*/
	public $fields=array();
	
	public function beforeValidate($event) {
		foreach ($this->fields as $field) {
			if (!isset($this->Owner->{$field.'H'}) || ($this->Owner->{$field.'H'} < 1) || ($this->Owner->{$field.'H'} > 12))
				{$this->Owner->addError($field.'H', 'Hours are invalid.'); continue;}
			if (!isset($this->Owner->{$field.'M'}) || ($this->Owner->{$field.'M'} < 0) || ($this->Owner->{$field.'M'} > 59))
				{$this->Owner->addError($field.'M', 'Minutes are invalid.'); continue;}
			if (!isset($this->Owner->{$field.'PM'}) || !in_array($this->Owner->{$field.'PM'},array(0,1)))
				{$this->Owner->addError($field.'PM', 'PM/AM invalid.'); continue;}
				
			$time = strtotime($this->Owner->{$field.'D'});
			if ($time===false) {
				$this->Owner->addError($field, 'Date is invalid.');
				continue;
			}
			$time -= 7*60*60;
			$time += $this->Owner->{$field.'H'}*60*60 + $this->Owner->{$field.'M'}*60;
			if ($this->Owner->{$field.'PM'})
				$time += 12*60*60;
			$this->Owner->{$field} = gmdate("Y-m-d H:i:s", $time);
		}
			
		return true;	
	}
	public function afterFind($event) {
		foreach ($this->fields as $field) {
			$time = strtotime($this->Owner->{$field});
			$this->Owner->{$field.'D'} = date('m/d/Y', $time);
			$this->Owner->{$field.'H'} = (int) date('g', $time);
			$this->Owner->{$field.'M'} = (int) date('i', $time);
			$this->Owner->{$field.'PM'} = date('a', $time)=='pm';
		}
	}
}