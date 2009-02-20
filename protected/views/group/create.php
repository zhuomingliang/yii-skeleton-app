<h2>New Group</h2>

<?php
$items = array();
$items[] = array('Group List',array('list'));
$this->widget('application.components.Menu',array('items'=>$items));
?>


<div class="yiiForm">
<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($group); ?>

<div class="simple">
<?php echo CHtml::activeLabel($group,'name'); ?>
<?php echo CHtml::activeTextField($group,'name',array('size'=>50,'maxlength'=>50)); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton('Create'); ?>
</div>

</form>
</div><!-- yiiForm -->