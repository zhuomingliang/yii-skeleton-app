<?php
class ActiveRecord extends CActiveRecord
{
	public function tableName()
	{
		return strtolower(parent::tableName());
	}
	
	/*
	* I extended this method so that yii will "automagically" understand that
	* 'required' attributes (in the given scenario) are also 'safe'.  This way,
	* when defining 'safe' attributes in the safeAttributes() method, you can
	* neglect to define attributes as safe that you have already defined at "required"
	* in your rules() method.  This basically saves typing (and in some cases stupid
	* mistakes), which I am always a fan of.  This method could be moved to another model
	* from which other models like this could inherit from if you wish.
	* 
	* You should NOT call this method directly but it is used by Yii internally
	*/
	public function getSafeAttributeNames($scenario='') {
		$safe = parent::getSafeAttributeNames($scenario);
		
		foreach ($this->validators as $validator) {
			if ((get_class($validator) != 'CRequiredValidator') || !$validator->applyTo($scenario)) continue;
			$safe = array_merge($safe, $validator->attributes);
		}
		return array_unique($safe);
	}
}