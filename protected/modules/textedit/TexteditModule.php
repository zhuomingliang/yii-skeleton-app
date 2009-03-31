<?php

class TexteditModule extends CWebModule
{
	//public $defaultController='textedit';
	public function init()
	{
		//parent::init();
		Yii::import($this->id.'.models.*');
	}
}
