<?php

class AdminController extends Controller
{
	public $defaultAction='list';
	
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	public function accessRules() {
		return array(
			'*' => array(Group::ADMIN, 'min'), //all actions require use to be at least an admin
		);
	}
	public function actionList() {
		$criteria = new CDbCriteria;
		$criteria->order = '`namedId`';
		$pages = new CPagination(TextEdit::model()->count($criteria));
		$pages->pageSize = 5;
		$pages->applyLimit($criteria);
		
		$records = TextEdit::model()->findAll($criteria);
		$this->render('list', compact('records', 'pages'));
	}

}