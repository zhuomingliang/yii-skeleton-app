<?php
class ActiveRecord extends CActiveRecord
{
	public function tableName()
	{
		return strtolower(parent::tableName());
	}
}