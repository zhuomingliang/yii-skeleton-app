<?php

class TexteditController extends Controller
{
	public $defaultAction='process';
	
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
	public function beforeAction($action) {
		if (!Yii::app()->request->isAjaxRequest)
			throw new CHttpException(500,'Only ajax requests');	
		return true;
	}
	public function actionProcess() {
		//Yii::log(print_r($_POST, true), 'watch', 'system.web');
		Yii::log(Yii::app()->user->name.' changed '.$_POST['id'], 'watch', 'system.web');
		Yii::import('textedit.models.*');
		$textedit = new TextEdit;
		$textedit->isNewRecord = !TextEdit::model()->count("`namedId`='{$_POST['id']}'");
		$textedit->namedId = $_POST['id'];
		$textedit->content = $_POST['value'];
		$textedit->save(false);
		echo $textedit->getMarkdown('content', false);
	}
	public function actionLoadraw() {
		//Yii::log($_GET['id'], 'watch', 'system.web');
		Yii::import('textedit.models.*');
		$model = TextEdit::model()->find("`namedId`='{$_GET['id']}'");
		if ($model)
			echo $model->content;
	}
}