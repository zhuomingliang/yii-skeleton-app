<h1>User Recovery</h1>

<?php
if(Yii::app()->user->hasFlash('recover')) {
	Yii::app()->user->flash('recover', array('<div class="confirmation">', '</div>'));
	return;
}
$this->widget('textedit.components.TextEditor', array('id'=>'userRecovery'));
?>
<div class="yiiForm">
<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($user); ?>

<div class="simple">
<?php echo CHtml::activeLabel($user,'email'); ?>
<?php echo CHtml::activeTextField($user,'email') ?>
</div>

<div class="action">
<?php echo CHtml::submitButton('Submit'); ?>
</div>

</form>
</div><!-- yiiForm -->