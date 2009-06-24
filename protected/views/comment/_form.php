<?php
if (Yii::app()->user->isGuest) {
	echo "<p>You must be logged in to comment</p>";
	return;	
}
?>
<div class="yiiForm">
<?php echo Html::form(); ?>

<?php echo Html::errorSummary($comment); ?>

<div class="simple">
<?php echo Html::activeLabel($comment,'content'); ?>
<?php echo Html::activeTextArea($comment,'content'); ?>
<p class="hint">
You may enter content using <?php echo Html::link('Markdown syntax', 'http://daringfireball.net/projects/markdown/syntax', array('target'=>'_blank'))?>.
</p>
</div>
<div class="action">
<?php echo Html::submitButton('done'); ?>
</div>

</form>
</div><!-- yiiForm -->