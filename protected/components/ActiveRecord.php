<?php
class ActiveRecord extends CActiveRecord
{
	public function tableName()
	{
		return strtolower(parent::tableName());
	}
	
	/**
	* This would be better put into a behavior
	* 
	* @param mixed $column
	* @param mixed $userCss
	*/
	public function getMarkdown($column, $userCss=true) {
		if ($userCss)
			Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/css/markdown.css');
		Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/css/highlight.css');
		if ($userCss)
			return '<div class="markdown">'.$this->getParsed($column).'</div>';
		else
			return $this->getParsed($column);
	}
}