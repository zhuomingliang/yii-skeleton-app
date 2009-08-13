<?php
Yii::import('system.cli.commands.shell.CrudCommand');
 
defined('MY_CRUD_TEMPLATE') or 
    define('MY_CRUD_TEMPLATE',dirname(__FILE__).'/templates/crud');
 
class MycrudCommand extends CrudCommand
{
	public $templatePath=MY_CRUD_TEMPLATE;
	//public $actions=array('create','update','list','show','admin','_form');
}