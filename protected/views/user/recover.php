<h1>User Recovery</h1>

<?php
if(Yii::app()->user->hasFlash('recover')) {
	Yii::app()->user->flash('recover', array('<div class="confirmation">', '</div>'));
	return;
}
$this->widget('textedit.components.TextEditor', array('id'=>'userRecovery'));
?>
<div class="yiiForm">
<?php echo Html::form(); ?>

<?php echo Html::errorSummary($user); ?>

<div class="simple">
<?php echo Html::activeLabel($user,'email'); ?>
<?php echo Html::activeTextField($user,'email') ?>
</div>

<div class="action">
<?php echo Html::submitButton('Submit'); ?>
</div>

</form>
</div><!-- yiiForm -->