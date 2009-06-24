<h2>Register</h2>

<div class="yiiForm">
<?php echo Html::form(); ?>

<?php echo Html::errorSummary($user); ?>

<div class="simple">
<?php echo Html::activeLabel($user,'username'); ?>
<?php echo Html::activeTextField($user,'username'); ?>
</div>
<div class="simple">
<?php echo Html::activeLabel($user,'password'); ?>
<?php echo Html::activePasswordField($user,'password'); ?>
</div>
<div class="simple">
<?php echo Html::activeLabel($user,'password_repeat'); ?>
<?php echo Html::activePasswordField($user,'password_repeat'); ?>
</div>
<div class="simple">
<?php echo Html::activeLabel($user,'email'); ?>
<?php echo Html::activeTextField($user,'email'); ?>
<p class="hint">Email will not be viewable by <b>anyone</b> but yourself.</p>
</div>

<div class="action">
<?php echo Html::submitButton('Create'); ?>
</div>

</form>
</div><!-- yiiForm -->