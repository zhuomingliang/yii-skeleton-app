<?php

class CommentController extends Controller
{
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_comment;
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}
	
	public function accessRules() {
		return array(
			'delete' => array(Group::ADMIN, 'min'),
		);
	}
	/**
	 * Deletes a particular comment.
	 * If deletion is successful, the browser will be redirected to the post page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$comment=$this->loadComment();
			$comment->delete();
			$this->redirect(array('post/show','id'=>$comment->post_id));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadComment($id=null)
	{
		if($this->_comment===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_comment=Comment::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_comment===null)
				throw new CHttpException(404,'The requested comment does not exist.');
		}
		return $this->_comment;
	}
}