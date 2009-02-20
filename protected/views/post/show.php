<?php
Yii::app()->clientScript->registerCoreScript('yii');
$script = <<<EOD
function deleteItem(){
	if (confirm('Are you sure?')) {
		jQuery.yii.submitForm(this,this.href,{});
	}
	return false;
}

$(".deleteItem").click(deleteItem);
EOD;
Yii::app()->clientScript->registerScript('userShow', $script, CClientScript::POS_READY);


$items = array();
$items[] = array('Archive',array('list'));
$items[] = array('New Post',array('create'));
if (($post->user_id == Yii::app()->user->id) || Yii::app()->user->hasAuth(Group::ADMIN)) {
	$items[] = array('Edit Post',array('update','id'=>$post->id));
	$items[] = array('Delete Post',array('delete','id'=>$post->id), 'htmlOptions'=>array('class' => 'deleteItem'));
}
if (Yii::app()->user->hasAuth(Group::ADMIN))
	$items[] = array('Admin',array('admin'));

$this->widget('application.components.Menu',array('items'=>$items));
?>


<h2><?php echo CHtml::encode($post->title); ?></h2>
<p class="summary">By <?php echo CHtml::link(CHtml::encode($post->user->username), array('user/show', 'id'=>$post->user->id)); ?>  on 
<?php echo Time::nice($post->created);
if ($post->modified) {
	echo '<br />Modified on ';
	echo Time::nice($post->modified);
}
?>
</p>

<div class="markdown">
<?php echo $post->getCache('content'); ?>
</div>

</p>
