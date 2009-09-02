<h2>New Post</h2>


<?php
$this->operations[] = array('Archive',array('list'));

if (Yii::app()->user->hasAuth(Group::ADMIN)){
	$this->operations[] = array('Manage Post',array('admin'));
}

echo $this->renderPartial('_form', array(
	'post'=>$post,
	'update'=>false,
));
?>