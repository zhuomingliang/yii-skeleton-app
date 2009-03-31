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
		$records = TextEdit::model()->findAll();
		$this->render('list', compact('records'));
	}

}