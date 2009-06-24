<h1>Login</h1>

<div class="yiiForm">
<?php echo Html::form(); ?>

<?php echo Html::errorSummary($user); ?>

<div class="simple">
<?php echo Html::activeLabel($user,'username'); ?>
<?php echo Html::activeTextField($user,'username') ?>
</div>

<div class="simple">
<?php echo Html::activeLabel($user,'password'); ?>
<?php echo Html::activePasswordField($user,'password') ?>
</div>

<div class="action">
<?php echo Html::activeCheckBox($user,'rememberMe'); ?> Remember me next time<br/>
<?php echo Html::submitButton('Login'); ?>
</div>

</form>
</div><!-- yiiForm -->
<p>
<?php echo Html::link('Lost your username?', array('user/recover')); ?>
<br />
Don't have an account? <?php echo Html::link('Create one', array('user/create')); ?>.
</p>