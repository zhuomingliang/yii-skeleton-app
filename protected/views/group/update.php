<h2>Update Group <?php echo $group->id; ?></h2>

<?php
$this->operations  = array(
	array('Group Listing',array('list')),
	array('New Group',array('create'))
);
?>
<div class="yiiForm">
<?php echo Html::form(); ?>

<?php echo Html::errorSummary($group); ?>

<div class="simple">
<?php echo Html::activeLabel($group,'name'); ?>
<?php echo Html::activeTextField($group,'name',array('size'=>50,'maxlength'=>50)); ?>
</div>

<div class="action">
<?php echo Html::submitButton('Save'); ?>
</div>

</form>
</div><!-- yiiForm -->