<?php
JavaScript::deleteItem();

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

<div class="post">
<h2><?php echo CHtml::encode($post->title); ?></h2>
<p class="summary">By <?php echo CHtml::link(CHtml::encode($post->user->username), array('user/show', 'id'=>$post->user->id)); ?>  on 
<?php echo Time::nice($post->created);
if ($post->modified) {
	echo '<br />Modified on ';
	echo Time::nice($post->modified);
}
?>
</p>

<?php echo $post->getMarkdown('content'); ?>

</div>

</p>
