<?php
if (empty($comments))
	echo '<p>No comments at this time</p>';
foreach($comments as $comment){ ?>

<div class="comment" id="c<?php echo $comment->id; ?>">
	<div class="content"><?php echo $comment->getMarkdown('content'); ?></div>
	<div class="small">By <?php echo $comment->user->username; ?> on <?php echo Time::nice($comment->created); ?>
	<?php if (Yii::app()->user->hasAuth(Group::ADMIN)) echo ' | '.CHtml::linkButton('delete', array('submit'=>array('comment/delete', 'id'=>$comment->id),
	'confirm'=>"Are you sure to delete comment #{$comment->id}?",
	));?>
	 - <?php echo CHtml::link('Permalink',array('post/show','id'=>isset($post)?$post->id:$comment->post->id,'#'=>'c'.$comment->id),array(
		'class'=>'permalink',
		'title'=>'Permalink to this comment',
	)); ?>
	</div>
</div><!-- comment -->

<?php } ?>
