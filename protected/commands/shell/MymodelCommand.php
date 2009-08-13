<?php
Yii::import('system.cli.commands.shell.ModelCommand');

defined('MY_MODEL_TEMPLATE') or
	define('MY_MODEL_TEMPLATE',dirname(__FILE__).'/templates/model');

class MymodelCommand extends ModelCommand
{
	public $templatePath=MY_MODEL_TEMPLATE;
}