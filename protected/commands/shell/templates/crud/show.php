<?php
/**
 * This is the template for generating the show view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<?php echo "<?php\n"; ?>
JavaScript::deleteItem();
<?php echo "?>\n"; ?>
<h2>View <?php echo $modelClass." <?php echo \$model->{$ID}; ?>"; ?></h2>

<?php echo "<?php\n"; ?>
$this->widget('Menu',array('items'=>array(
	array('<?php echo $modelClass?> List', array('list')),
	array('New <?php echo $modelClass?>', array('create')),
	array('Update <?php echo $modelClass?>', array('update','id'=>$model-><?php echo $ID?>)),
	array('Delete <?php echo $modelClass?>', array('delete','id'=>$model-><?php echo $ID?>), 'htmlOptions'=>array('class' => 'deleteItem')),
	array('Admin <?php echo $modelClass?>',array('admin')),
)));
<?php echo "?>\n"; ?>

<table class="dataGrid">
<?php foreach($columns as $name=>$column): ?>
<tr>
	<th class="label"><?php echo "<?php echo Html::encode(\$model->getAttributeLabel('$name')); ?>\n"; ?></th>
    <td><?php echo "<?php echo Html::encode(\$model->{$name}); ?>\n"; ?></td>
</tr>
<?php endforeach; ?>
</table>
