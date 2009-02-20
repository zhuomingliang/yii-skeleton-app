<h2>Edit Post</h2>

<?php
$items = array();
$items[] = array('Archive',array('list'));
$items[] = array('New Post',array('create'));
if (Yii::app()->user->hasAuth(Group::ADMIN)){
	$items[] = array('Manage Post',array('admin'));
}
$this->widget('application.components.Menu',array('items'=>$items));


echo $this->renderPartial('_form', array(
	'post'=>$post,
	'update'=>true,
));
?>