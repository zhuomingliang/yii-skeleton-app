<h2>Archive</h2>

<div class="actionBar">
<?php

echo CHtml::link('New Post',array('create'))." ";

if (Yii::app()->user->hasAuth(Group::ADMIN))
	echo CHtml::link('Admin',array('admin'));
?>
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
<?php foreach($posts as $n=>$post): ?>
<h4><?php echo CHtml::link($post->title,array('show','id'=>$post->id)); ?></h4>
<p class="summary">
By <?php echo CHtml::link(CHtml::encode($post->user->username), array('user/show', 'id'=>$post->user->id)); ?> 
on Created on <?php echo Time::nice($post->created); ?>
</p>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>