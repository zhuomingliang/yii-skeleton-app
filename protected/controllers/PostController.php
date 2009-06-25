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
		$post = $this->loadPost();
		$comment = $this->createComment($post);
		$this->render('show', compact('post', 'comment'));
	}
	protected function createComment($post) {
		$comment = new Comment();
		$comment->post_id = $post->id;
		if (isset($_POST['Comment']))
		{
			$comment->setAttributes($_POST['Comment']);
			if ($comment->save()) {
				if (!Yii::app()->request->isAjaxRequest)
					$this->redirect(array('post/show','id'=>$comment->post_id,'#'=>'c'.$comment->id));
			}	
		}
		return $comment;
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
			$post->setAttributes($_POST['Post']);
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
			$post->setAttributes($_POST['Post']);
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
		$criteria->order = '`post`.`created` DESC';
		$posts=Post::model()->with('user')->together()->findAll($criteria);

		$this->render('list', compact('posts','pages'));
	}
	/**
	 * Example of a news page - just pull posts from admin users.
	 * You may want to modify it to only pull posts under a 'news' category
	 */
	public function actionNews()
	{
		$criteria=new CDbCriteria;
		$criteria->condition = '`group_id` IN ('.Group::ADMIN.','.Group::SITE_ADMIN.')';
		$pages=new CPagination(Post::model()->with('user')->count($criteria));
		$pages->pageSize=4;
		$pages->applyLimit($criteria);
		$criteria->order = '`post`.`created` DESC';
		$posts=Post::model()->with('user')->together()->findAll($criteria);

		$this->render('news', compact('posts','pages'));
	}
	/**
	 * Manages all posts.
	 */
	public function actionAdmin()
	{
		$this->processAdminCommand();

		$criteria=new CDbCriteria;

		$pages=new CPagination(Post::model()->count($criteria));
		$pages->pageSize=35;
		$pages->applyLimit($criteria);

		$sort=new CSort('Post');
		$sort->defaultOrder = '`post`.`created` DESC';
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
