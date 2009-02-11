<h2>Register</h2>

<div class="yiiForm">
<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($user); ?>

<div class="simple">
<?php echo CHtml::activeLabel($user,'username'); ?>
<?php echo CHtml::activeTextField($user,'username'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($user,'password'); ?>
<?php echo CHtml::activePasswordField($user,'password'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($user,'password_repeat'); ?>
<?php echo CHtml::activePasswordField($user,'password_repeat'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($user,'email'); ?>
<?php echo CHtml::activeTextField($user,'email'); ?>
<p class="hint">Email will not be viewable by <b>anyone</b> but yourself.</p>
</div>

<div class="action">
<?php echo CHtml::submitButton('Create'); ?>
</div>

</form>
</div><!-- yiiForm -->