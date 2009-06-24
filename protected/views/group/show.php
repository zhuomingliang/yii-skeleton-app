<h2>View Group <?php echo $group->id; ?></h2>

<?php
JavaScript::deleteItem();

$items = array();
$items[] = array('Group Listing',array('list'));
$items[] = array('Rename Group',array('update','id'=>$group->id));
$items[] = array('Delete Group',array('delete','id'=>$group->id), 'htmlOptions'=>array('class' => 'deleteItem'));
$this->widget('Menu',array('items'=>$items));
?>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo Html::encode($group->getAttributeLabel('name')); ?></th>
    <td><?php echo Html::encode($group->name); ?></td>
</tr>
</table>
