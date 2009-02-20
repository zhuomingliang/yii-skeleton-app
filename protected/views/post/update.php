<h2>Edit Post</h2>

<div class="actionBar">
<?php
echo CHtml::link('Archive',array('list'))." ";

echo CHtml::link('New Post',array('create'))." ";

if (Yii::app()->user->hasAuth(Group::ADMIN))
	echo CHtml::link('Manage Post',array('admin'));
?>
</div>

<?php echo $this->renderPartial('_form', array(
	'post'=>$post,
	'update'=>true,
)); ?>