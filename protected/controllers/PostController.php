<?php

class PostController extends Controller
{

	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_post;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	 public function accessRules() {
		return array(
			'create, update',
			'admin, delete' => array(Group::ADMIN, 'min'),
		);
	}

	/**
	 * Shows a particular post.
	 */
	public function actionShow()
	{
		$this->render('show',array('post'=>$this->loadPost()));
	}

	/**
	 * Creates a new post.
	 * If creation is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionCreate()
	{
		$post=new Post;
		if(isset($_POST['Post']))
		{
			$post->attributes=$_POST['Post'];
			if($post->save())
				$this->redirect(array('show','id'=>$post->id));
		}
		$this->render('create',compact('post'));
	}

	/**
	 * Updates a particular post.
	 * If update is successful, the browser will be redirected to the 'show' page.
	 */
	public function actionUpdate()
	{
		$post=$this->loadPost();
		
		if (($post->user_id != Yii::app()->user->id) && !Yii::app()->user->hasAuth(Group::ADMIN))
			throw new CHttpException(500,'You are trying to modify a post which is not yours');
			
		if(isset($_POST['Post']))
		{
			$post->attributes=$_POST['Post'];
			if($post->save())
				$this->redirect(array('show','id'=>$post->id));
		}
		$this->render('update',compact('post'));
	}

	/**
	 * Deletes a particular post.
	 * If deletion is successful, the browser will be redirected to the 'list' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$post = $this->loadPost();
			
			if (($post->user_id != Yii::app()->user->id) && !Yii::app()->user->hasAuth(Group::ADMIN))
				throw new CHttpException(500,'You are trying to delete a post which is not yours');
			
			$post->delete();
			$this->redirect(array('list'));
		}
		else
			throw new CHttpException(500,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all posts.
	 */
	public function actionList()
	{
		$criteria=new CDbCriteria;

		$pages=new CPagination(Post::model()->count($criteria));
		$pages->pageSize=4;
		$pages->applyLimit($criteria);

		$posts=Post::model()->with('user')->together()->findAll($criteria);

		$this->render('list', compact('posts','pages'));
	}

	/**
	 * Manages all posts.
	 */
	public function actionAdmin()
	{
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(Post::model()->count($criteria));
		$pages->pageSize=25;
		$pages->applyLimit($criteria);

		$sort=new CSort('Post');
		$sort->applyOrder($criteria);

		$postList=Post::model()->findAll($criteria);

		$this->render('admin', compact('postList',	'pages', 'sort'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadPost($id=null)
	{
		if($this->_post===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_post=Post::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_post===null)
				throw new CHttpException(500,'The requested post does not exist.');
		}
		return $this->_post;
	}

	/**
	 * Executes any command triggered on the admin page.
	 */
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$this->loadPost($_POST['id'])->delete();
			// reload the current page to avoid duplicated delete actions
			$this->refresh();
		}
	}
}
