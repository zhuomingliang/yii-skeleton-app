<h2>New Post</h2>

<div class="actionBar">
<?php
echo CHtml::link('Archive',array('list'))." ";

if (Yii::app()->user->hasAuth(Group::ADMIN))
	echo CHtml::link('Admin',array('admin'));
?>
</div>

<?php echo $this->renderPartial('_form', array(
	'post'=>$post,
	'update'=>false,
)); ?>