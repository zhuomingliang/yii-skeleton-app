<?php

class EUniquenessValidator extends CValidator
{
	/**
	 * @var boolean whether the comparison is case sensitive. Defaults to true.
	 * Note, by setting it to false, you are assuming the attribute type is string.
	 */
	public $caseSensitive=true;
	/**
	 * @var boolean whether the attribute value can be null or empty. Defaults to true,
	 * meaning that if the attribute is empty, it is considered valid.
	 */
	public $allowEmpty=true;
	
	/**
	 * @var string The model
	 */
	public $model=null;
	
	/**
	 * @var string The attribute to look for.  Defaults to 'id'
	 */
	public $attribute='id';
	
	/**
	 * Validates the attribute of the object.
	 * If there is any error, the error message is added to the object.
	 * @param CModel the object being validated
	 * @param string the attribute being validated
	 */
	protected function validateAttribute($object,$attribute)
	{
		$value=$object->$attribute;
		if($this->allowEmpty && ($value===null || $value===''))
			return;

		eval("\$column = {$this->model}::model()->getTableSchema()->getColumn(\$this->attribute);");
		if($column===null)
			throw new CException(Yii::t('yii', '{model} does not have attribute "{this->attribute}".',
				array('{class}'=>$this->model, '{attribute}'=>$this->attribute)));

		$columnName=$column->rawName;
		$criteria=array(
			'condition'=>$this->caseSensitive ? "$columnName=:value" : "LOWER($columnName)=LOWER(:value)",
			'params'=>array(':value'=>$value),
		);

		eval("\$exists={$this->model}::model()->exists(\$criteria);");

		if(!$exists)
		{
			$message=$this->message!==null?$this->message:Yii::t('yii','{attribute} "{value}" is not valid.');
			$this->addError($object,$attribute,$message,array('{value}'=>$value));
		}
	}
}
