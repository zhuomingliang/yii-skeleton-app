<?php
/**
 * This is the template for generating the create view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<h2>New <?php echo $modelClass; ?></h2>

<?php echo "<?php\n"; ?>
$this->operations = array(
	array('<?php echo $modelClass?> List', array('list')),
	array('Admin <?php echo $modelClass?>', array('admin')),
);
<?php echo "?>\n"; ?>

<?php echo "<?php echo \$this->renderPartial('_form', array(
	'model'=>\$model,
	'update'=>false,
)); ?>"; ?>
