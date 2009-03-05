<?php

class Group extends ActiveRecord
{
	//user rankings
	//possibly should be moved to the WebUser class?
	//the value of these constants match a group id in the group table
	const GUEST=1;
	const USER=2;
	const ADMIN=3;
	const SITE_ADMIN=4;
	/**
	 * Returns the static model of the specified AR class.
	 * This method is required by all child classes of CActiveRecord.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('name','length','max'=>50),
			array('name', 'required'),
		);
	}
	
	public function getListed() {
		$a = $this->findAll();
		unset($a[0]); //removes "not logged in" level
		return $a;
	}

}