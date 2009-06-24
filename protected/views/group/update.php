<h2>Update Group <?php echo $group->id; ?></h2>

<?php
$items = array();
$items[] = array('Group Listing',array('list'));
$items[] = array('New Group',array('create'));
$this->widget('Menu',array('items'=>$items));
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