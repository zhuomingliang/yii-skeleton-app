<h2>Account Settings</h2>

<div class="yiiForm">
<?php echo CHtml::form('', 'post', array('autocomplete'=>'off')); ?>

<?php echo CHtml::errorSummary($user); ?>

<div class="simple">
<?php echo CHtml::activeLabel($user,'email'); ?>
<?php echo CHtml::activeTextField($user,'email'); ?>
<p class="hint">Note: If you change your email address you will be immediately logged out and will not be able to log back in until you revalidate your email address.</p>
</div>

<div class="simple">
<?php echo CHtml::activeLabel($user,'about'); ?>
<?php echo CHtml::activeTextArea($user,'about'); ?>
<p class="hint">This will appear on your user page.<br />
You may enter content using <?php echo CHtml::link('Markdown syntax', 'http://daringfireball.net/projects/markdown/syntax', array('target'=>'_blank'))?>.
</p>
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
<?php echo CHtml::activeLabel($user,'email_visible'); ?>
<?php echo CHtml::activeCheckBox($user,'email_visible'); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabel($user,'notify_comments'); ?>
<?php echo CHtml::activeCheckBox($user,'notify_comments'); ?>
</div>

<div class="simple">
<?php echo CHtml::activeLabel($user,'notify_messages'); ?>
<?php echo CHtml::activeCheckBox($user,'notify_messages'); ?>
</div>
<?php if (Yii::app()->user->hasAuth(Group::ADMIN)) { ?>
<div class="simple">
<?php echo CHtml::activeLabel($user, 'group_id'); ?>
<?php echo CHtml::activeDropDownList($user, 'group_id', CHtml::listData(Group::model()->getListed(), 'id', 'name')); ?>
</div>
<?php } ?>
<div class="action">
<?php echo CHtml::submitButton('Save'); ?>
</div>

</form>
</div><!-- yiiForm -->