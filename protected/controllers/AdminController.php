<?php
class AdminController extends Controller
{
	public $defaultAction='index';
	
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
	public function actionIndex() {
		$this->render('index');
	}
	
	//this is a convienience menu for admins.  You define it here, then you can put it in your layout if you wish.
	public static function menu() {
		return array(
			array('Groups', array('/group/list')),
			array('TextEdit module', array('/textedit/admin/list')),
		);
	}
}