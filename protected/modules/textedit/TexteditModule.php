<?php

class TexteditModule extends CWebModule
{
	//public $defaultController='textedit';
	public function init()
	{
		$this->setImport(array(
			'textedit.models.*',
			'textedit.components.*',
		));
	}
}
