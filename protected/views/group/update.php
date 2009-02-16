<h2>Update Group <?php echo $group->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('Group List',array('list')); ?>]
[<?php echo CHtml::link('New Group',array('create')); ?>]
</div>

<div class="yiiForm">
<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($group); ?>

<div class="simple">
<?php echo CHtml::activeLabel($group,'name'); ?>
<?php echo CHtml::activeTextField($group,'name',array('size'=>50,'maxlength'=>50)); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton('Save'); ?>
</div>

</form>
</div><!-- yiiForm -->