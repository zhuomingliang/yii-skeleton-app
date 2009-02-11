<h2>View Group <?php echo $group->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('Group List',array('list')); ?>]
[<?php echo CHtml::link('New Group',array('create')); ?>]
[<?php echo CHtml::link('Update Group',array('update','id'=>$group->id)); ?>]
[<?php echo CHtml::linkButton('Delete Group',array('submit'=>array('delete','id'=>$group->id),'confirm'=>'Are you sure?')); ?>
]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($group->getAttributeLabel('name')); ?>
</th>
    <td><?php echo CHtml::encode($group->name); ?>
</td>
    </div>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($group->getAttributeLabel('created')); ?>
</th>
    <td><?php echo CHtml::encode($group->created); ?>
</td>
    </div>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($group->getAttributeLabel('modified')); ?>
</th>
    <td><?php echo CHtml::encode($group->modified); ?>
</td>
    </div>
</tr>
</table>
