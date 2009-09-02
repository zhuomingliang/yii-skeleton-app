<h2>New Group</h2>

<?php
$this->operations = array(array('Group List',array('list')));
?>


<div class="yiiForm">
<?php echo Html::form(); ?>

<?php echo Html::errorSummary($group); ?>

<div class="simple">
<?php echo Html::activeLabel($group,'name'); ?>
<?php echo Html::activeTextField($group,'name',array('size'=>50,'maxlength'=>50)); ?>
</div>

<div class="action">
<?php echo Html::submitButton('Create'); ?>
</div>

</form>
</div><!-- yiiForm -->