<?php

class GroupController extends Controller
{
	
	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * Specifies the action filters.
	 * This method overrides the parent implementation.
	 * @return array action filters
	 */
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

	/**
	 * Lists all groups.
	 */
	public function actionList() {
		$criteria = new CDbCriteria;
		
		$pages = new CPagination(Group::model()->count($criteria));
		$pages->pageSize = 25;
		$pages->applyLimit($criteria);
		
		$sort = new CSort('group');
		$sort->applyOrder($criteria);
		
		$groups=Group::model()->findAll($criteria);

		$this->render('list',compact('groups', 'pages', 'sort'));
	}

	/**
	 * Shows a particular group.
	 */
	public function actionShow() {
		$this->render('show',array('group'=>$this->loadGroup()));
	}

	/**
	 * Creates a new group.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate() {
		$group=new Group;
		if (Yii::app()->request->isPostRequest || isset($_POST['Group'])) {
			$group->setAttributes($_POST['Group']);
			
			if ($group->save())
				$this->redirect(array('list'));
		}
		$this->render('create', array('group' => $group));
	}

	/**
	 * Updates a particular group.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate() {
		$group=$this->loadGroup();
		
		if (Yii::app()->request->isPostRequest || isset($_POST['Group'])) {
			$group->setAttributes($_POST['Group']);
				
			if ($group->save())
				$this->redirect(array('show','id'=>$group->id));
		}
		$this->render('update',array('group'=>$group));
	}

	/**
	 * Deletes a particular group.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete() {
		// we only allow deletion via POST request
		if (!Yii::app()->request->isPostRequest)
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');

		$this->loadGroup()->delete();
		$this->redirect(array('list'));
	}

	/**
	 * Loads the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	protected function loadGroup() {
		if (isset($_GET['id']))
			$group=Group::model()->findbyPk($_GET['id']);
		
		if (isset($group))
			return $group;
		else
			throw new CHttpException(500,'The requested group does not exist.');
	}
}
