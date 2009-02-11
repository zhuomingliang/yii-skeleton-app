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
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function accessRules() {
		return array(
			'*' => array(Group::ADMIN, 'min'),
		);
	}

	/**
	 * Lists all groups.
	 */
	public function actionList() {
		$pages=$this->paginate(Group::model()->count());
		$groupList=Group::model()->findAll($this->getListCriteria($pages));

		$this->render('list',array(
			'groupList' => $groupList,
			'pages' => $pages));
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
		if (Yii::app()->request->isPostRequest)
		{
			if (isset($_POST['Group']))
				$group->setAttributes($_POST['Group']);
			if ($group->save())
				$this->redirect(array('show', 'id' => $group->id));
		}
		$this->render('create', array('group' => $group));
	}

	/**
	 * Updates a particular group.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate() {
		$group=$this->loadGroup();
		
		if (Yii::app()->request->isPostRequest) {
			if(isset($_POST['Group']))
				$group->setAttributes($_POST['Group']);
				
			if($group->save())
				$this->redirect(array('show','id'=>$group->id));
		}
		$this->render('update',array('group'=>$group));
	}

	/**
	 * Deletes a particular group.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete() {
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadGroup()->delete();
			$this->redirect(array('list'));
		} else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
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

	/**
	 * @param CPagination the pagination information
	 * @return CDbCriteria the query criteria for Group list.
	 * It includes the ORDER BY and LIMIT/OFFSET information.
	 */
	protected function getListCriteria($pages) {
		$criteria = Yii::createComponent('system.db.schema.CDbCriteria');
		$columns = Group::model()->tableSchema->columns;
		if (isset($_GET['sort']) && isset($columns[$_GET['sort']])) {
			$criteria->order=$columns[$_GET['sort']]->rawName;
			if (isset($_GET['desc']))
				$criteria->order.=' DESC';
		}
		$criteria->limit = $pages->pageSize;
		$criteria->offset = $pages->currentPage*$pages->pageSize;
		return $criteria;
	}

	/**
	 * Generates the header cell for the specified column.
	 * This method will generate a hyperlink for the column.
	 * Clicking on the link will cause the data to be sorted according to the column.
	 * @param string the column name
	 * @return string the generated header cell content
	 */
	protected function generateColumnHeader($column) {
		$params=$_GET;
		if (isset($params['sort']) && $params['sort']===$column)
		{
			if (isset($params['desc']))
				unset($params['desc']);
			else
				$params['desc']=1;
		} else {
			$params['sort']=$column;
			unset($params['desc']);
		}
		$url = $this->createUrl('list', $params);
		return CHtml::link(Group::model()->getAttributeLabel($column), $url);
	}
}
