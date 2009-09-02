<h2>Edit Post</h2>

<?php
$this->operations[] = array('Archive',array('list'));
$this->operations[] = array('New Post',array('create'));
if (Yii::app()->user->hasAuth(Group::ADMIN)){
	$this->operations[] = array('Manage Post',array('admin'));
}

echo $this->renderPartial('_form', array(
	'post'=>$post,
	'update'=>true,
));
?>