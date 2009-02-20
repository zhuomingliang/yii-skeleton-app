<h2>New Post</h2>


<?php
$items = array();
$items[] = array('Archive',array('list'));

if (Yii::app()->user->hasAuth(Group::ADMIN)){
	$items[] = array('Manage Post',array('admin'));
}
$this->widget('application.components.Menu',array('items'=>$items));


echo $this->renderPartial('_form', array(
	'post'=>$post,
	'update'=>false,
));
?>