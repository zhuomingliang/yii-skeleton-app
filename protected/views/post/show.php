<div class="actionBar">
<?php
echo CHtml::link('Archive',array('list'))." ";

echo CHtml::link('New Post',array('create'))." ";

if (($post->user_id == Yii::app()->user->id) || Yii::app()->user->hasAuth(Group::ADMIN))
	echo CHtml::link('Edit Post',array('update','id'=>$post->id))." ";

if (($post->user_id == Yii::app()->user->id) || Yii::app()->user->hasAuth(Group::ADMIN))
	echo CHtml::linkButton('Delete Post',array('submit'=>array('delete','id'=>$post->id),'confirm'=>'Are you sure?'))." ";

if (Yii::app()->user->hasAuth(Group::ADMIN))
	echo CHtml::link('Admin',array('admin'));
?>
</div>

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
