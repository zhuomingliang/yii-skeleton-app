<h2>View Group <?php echo $group->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('Groups Listing',array('list')); ?>]
[<?php echo CHtml::link('New Group',array('create')); ?>]
[<?php echo CHtml::link('Rename Group',array('update','id'=>$group->id)); ?>]
[<?php echo CHtml::linkButton('Delete Group',array('submit'=>array('delete','id'=>$group->id),'confirm'=>'Are you sure?')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($group->getAttributeLabel('name')); ?></th>
    <td><?php echo CHtml::encode($group->name); ?></td>
</tr>
</table>
