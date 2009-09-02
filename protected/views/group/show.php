<h2>View Group <?php echo $group->id; ?></h2>

<?php
JavaScript::deleteItem();

$this->operations = array(
	array('Group Listing',array('list')),
	array('Rename Group',array('update','id'=>$group->id)),
	array('Delete Group',array('delete','id'=>$group->id), 'htmlOptions'=>array('class' => 'deleteItem'))
);
?>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo Html::encode($group->getAttributeLabel('name')); ?></th>
    <td><?php echo Html::encode($group->name); ?></td>
</tr>
</table>
