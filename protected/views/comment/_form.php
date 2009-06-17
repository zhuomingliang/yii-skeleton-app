<?php
if (Yii::app()->user->isGuest) {
	echo "<p>You must be logged in to comment</p>";
	return;	
}
?>
<div class="yiiForm">
<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($comment); ?>

<div class="simple">
<?php echo CHtml::activeLabel($comment,'content'); ?>
<?php echo CHtml::activeTextArea($comment,'content'); ?>
<p class="hint">
You may enter content using <?php echo CHtml::link('Markdown syntax', 'http://daringfireball.net/projects/markdown/syntax', array('target'=>'_blank'))?>.
</p>
</div>
<div class="action">
<?php echo CHtml::submitButton('done'); ?>
</div>

</form>
</div><!-- yiiForm -->