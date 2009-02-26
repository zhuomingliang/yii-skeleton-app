<?php
JavaScript::deleteItem();

$items = array();
$items[] = array('User List', array('list'));
if (Yii::app()->user->hasAuth(Group::ADMIN)){
	$items[] = array('Update User', array('update','id'=>$user->id));
	$items[] = array('Delete User', array('delete','id'=>$user->id), 'htmlOptions'=>array('class' => 'deleteItem'));
}
$this->widget('application.components.Menu',array('items'=>$items));

$username = CHtml::encode($user->username); //cache the encoding
?>
<h2><?php echo $username ?>'s Profile</h2>
<p>
	Joined on <b><?php echo Time::nice($user->created, 'F d, o'); ?></b>
	<?php if ($user->email_visible) {?>
		<br />Email: <b><?php echo $user->email ?></b>
	<?php } ?>
</p>
<?php if (!empty($user->about)) { ?>
	<h3>About <?php echo $username; ?></h3>
	<div class="markdown">
	<?php echo $user->getParsed('about'); ?>
	</div>
<?php }
if (!empty($user->post)) {
?>
<h4>Posts by <?php echo $username; ?></h4>
<?php
foreach($user->post as $n=>$post){ ?>
<div class="post">
<h4><?php echo CHtml::link($post->title,array('post/show','id'=>$post->id)); ?></h4>
<p class="summary">
On <?php echo Time::nice($post->created); ?>
</p>
<div class="markdown">
<?php echo $post->getParsed('content'); ?>
</div>
</div>
<?php }
$this->widget('CLinkPager',array('pages'=>$pages));
?>
<?php } ?>
