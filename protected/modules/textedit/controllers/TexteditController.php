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
		$_POST['id'] = substr($_POST['id'], 9);
		Yii::log(Yii::app()->user->name.' changed '.$_POST['id'], 'watch', 'system.web');
		
		$textedit = Textedit::model()->find('namedId=:id', array('id'=>$_POST['id']));
		if (!$textedit) {
			$textedit = new Textedit;
			$textedit->namedId = $_POST['id'];
		}
		$textedit->content = $_POST['value'];
		
		if ($textedit->save())
			echo $textedit->getMarkdown('content', false);
		else
			echo "Error saving.";
	}
	public function actionLoadraw() {
		JavaScript::makeAjaxSafe();
		//Yii::log($_GET['id'], 'watch', 'system.web');
		$_GET['id'] = substr($_GET['id'], 9);
		$model = Textedit::model()->find('namedId=:id', array('id'=>$_GET['id']));
		if ($model)
			echo $model->content;
	}
}