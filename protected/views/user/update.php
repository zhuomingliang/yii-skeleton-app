<h2>Account Settings</h2>

<div class="yiiForm">
<?php echo Html::form('', 'post', array('autocomplete'=>'off')); ?>

<?php echo Html::errorSummary($user); ?>

<div class="simple">
<?php echo Html::activeLabel($user,'email'); ?>
<?php echo Html::activeTextField($user,'email'); ?>
<p class="hint">Note: If you change your email address you will be immediately logged out and will not be able to log back in until you revalidate your email address.</p>
</div>

<div class="simple">
<?php echo Html::activeLabel($user,'about'); ?>
<?php echo Html::activeTextArea($user,'about'); ?>
<p class="hint">This will appear on your user page.<br />
You may enter content using <?php echo Html::link('Markdown syntax', 'http://daringfireball.net/projects/markdown/syntax', array('target'=>'_blank'))?>.
</p>
</div>
<div class="simple">
<?php echo Html::activeLabel($user,'password'); ?>
<?php echo Html::activePasswordField($user,'password', array('value'=>'')); ?>
</div>
<div class="simple">
<?php echo Html::activeLabel($user,'password_repeat'); ?>
<?php echo Html::activePasswordField($user,'password_repeat', array('value'=>'')); ?>
</div>
<div class="simple">
<?php echo Html::activeLabel($user,'email_visible'); ?>
<?php echo Html::activeCheckBox($user,'email_visible'); ?>
</div>

<div class="simple">
<?php echo Html::activeLabel($user,'notify_comments'); ?>
<?php echo Html::activeCheckBox($user,'notify_comments'); ?>
</div>

<div class="simple">
<?php echo Html::activeLabel($user,'notify_messages'); ?>
<?php echo Html::activeCheckBox($user,'notify_messages'); ?>
</div>
<?php if (Yii::app()->user->hasAuth(Group::ADMIN)) { ?>
<div class="simple">
<?php echo Html::activeLabel($user, 'group_id'); ?>
<?php echo Html::activeDropDownList($user, 'group_id', Html::listData(Group::model()->getListed(), 'id', 'name')); ?>
</div>
<?php } ?>
<div class="action">
<?php echo Html::submitButton('Save'); ?>
</div>

</form>
</div><!-- yiiForm -->