<?php
/**
 * This is the template for generating the update view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<h2>Update <?php echo $modelClass." <?php echo \$model->{$ID}; ?>"; ?></h2>

<?php echo "<?php\n"; ?>
$this->widget('Menu',array('items'=>array(
	array('<?php echo $modelClass?> List',array('list')),
	array('New <?php echo $modelClass?>',array('create')),
	array('Admin <?php echo $modelClass?>',array('admin')),
)));
<?php echo "?>\n"; ?>

<?php echo "<?php echo \$this->renderPartial('_form', array(
	'model'=>\$model,
	'update'=>true,
)); ?>"; ?>