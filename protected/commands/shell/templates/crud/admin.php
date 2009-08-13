<?php
/**
 * This is the template for generating the admin view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<?php echo "<?php\n"; ?>
JavaScript::deleteItem();
<?php echo "?>\n"; ?>
<h2>Managing <?php echo $modelClass; ?></h2>

<?php echo "<?php\n"; ?>
$this->widget('Menu',array('items'=>array(
	array('<?php echo $modelClass?> List', array('list')),
	array('New <?php echo $modelClass?>', array('create')),
)));
<?php echo "?>\n"; ?>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo "<?php echo \$sort->link('$ID'); ?>"; ?></th>
<?php foreach($columns as $column): ?>
    <th><?php echo "<?php echo \$sort->link('{$column->name}'); ?>"; ?></th>
<?php endforeach; ?>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php echo "<?php foreach(\$models as \$n=>\$model): ?>\n"; ?>
  <tr class="<?php echo "<?php echo \$n%2?'even':'odd';?>"; ?>">
    <td><?php echo "<?php echo Html::link(\$model->{$ID},array('show','id'=>\$model->{$ID})); ?>"; ?></td>
<?php foreach($columns as $column): ?>
    <td><?php echo "<?php echo Html::encode(\$model->{$column->name}); ?>"; ?></td>
<?php endforeach; ?>
    <td>
      <?php echo "<?php echo Html::link('Update',array('update','id'=>\$model->{$ID})); ?>\n"; ?>
      <?php echo "<?php echo Html::link('Delete', array('delete','id'=>\$model->{$ID}), array('class'=>'deleteItem')); ?>"; ?>
	</td>
  </tr>
<?php echo "<?php endforeach; ?>\n"; ?>
  </tbody>
</table>
<br/>
<?php echo "<?php \$this->widget('CLinkPager',array('pages'=>\$pages)); ?>" ?>
