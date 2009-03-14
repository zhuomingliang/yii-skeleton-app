<h1>User Recovery</h1>

<?php
if(Yii::app()->user->hasFlash('recover')) {
	Yii::app()->user->flash('recover', array('<div class="confirmation">', '</div>'));
	return;
}
?>
<p>
Forgot your username and/or password?  Not to worry.  Enter the email below that you used to create an account with and press "submit" and we will email your login credentials to you.
</p>
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