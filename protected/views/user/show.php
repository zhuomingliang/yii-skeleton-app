<?php
JavaScript::deleteItem();

$items = array();
$items[] = array('User List', array('list'));
if (Yii::app()->user->hasAuth(Group::ADMIN)){
	$items[] = array('Update User', array('update','id'=>$user->id));
	$items[] = array('Delete User', array('delete','id'=>$user->id), 'htmlOptions'=>array('class' => 'deleteItem'));
}
$this->widget('Menu',array('items'=>$items));

$username = Html::encode($user->username); //cache the encoding
?>
<h2><?php echo $username ?>'s Profile</h2>
<p>
	Joined on <b><?php echo Time::nice($user->created, 'F d, o'); ?></b>
	<?php if ($user->email_visible) {?>
		<br />Email: <b><?php echo $user->email ?></b>
	<?php } ?>
	<br />This user has published <?php echo $user->num_posts;?> posts
</p>
<?php if (!empty($user->about)) { ?>
	<h3>About <?php echo $username; ?></h3>
	<?php echo $user->getMarkdown('about'); ?>
<?php }
if (!empty($posts)) {
?>
<h4>Posts by <?php echo $username; ?></h4>
<?php
foreach($posts as $n=>$post){ ?>
<div class="post">
<h3><?php echo Html::link($post->title,array('post/show','id'=>$post->id)); ?></h3>
<p class="summary">
On <?php echo Time::nice($post->created); ?>
</p>

<?php echo $post->getMarkdown('content'); ?>

</div>
<?php }
$this->widget('CLinkPager',array('pages'=>$pages));
?>
<?php } ?>
