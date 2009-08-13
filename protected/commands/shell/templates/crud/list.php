<?php
/**
 * This is the template for generating the list view for crud.
 * The following variables are available in this template:
 * - $ID: the primary key name
 * - $modelClass: the model class name
 * - $columns: a list of column schema objects
 */
?>
<h2><?php echo $modelClass; ?> List</h2>

<?php echo "<?php\n"; ?>
$this->widget('Menu',array('items'=>array(
	array('<?php echo $modelClass?> List', array('list')),
	array('Admin <?php echo $modelClass?>', array('admin')),
)));
<?php echo "?>\n"; ?>

<?php echo "<?php \$this->widget('CLinkPager',array('pages'=>\$pages)); ?>" ?>


<?php echo "<?php foreach(\$models as \$n=>\$model): ?>\n"; ?>
<div class="item">
<?php echo "<?php echo Html::encode(\$model->getAttributeLabel('{$ID}')); ?>"; ?>:
<?php echo "<?php echo Html::link(\$model->{$ID},array('show','id'=>\$model->{$ID})); ?>"; ?>

<br/>
<?php foreach($columns as $column): ?>
<?php echo "<?php echo Html::encode(\$model->getAttributeLabel('{$column->name}')); ?>"; ?>:
<?php echo "<?php echo Html::encode(\$model->{$column->name}); ?>"; ?>

<br/>
<?php endforeach; ?>

</div>
<?php echo "<?php endforeach; ?>\n"; ?>
<br/>
<?php echo "<?php \$this->widget('CLinkPager',array('pages'=>\$pages)); ?>" ?>
