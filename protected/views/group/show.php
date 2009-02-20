<h2>View Group <?php echo $group->id; ?></h2>

<?php
Yii::app()->clientScript->registerCoreScript('yii');
$script = <<<EOD
function deleteItem(){
	if (confirm('Are you sure?')) {
		jQuery.yii.submitForm(this,this.href,{});
	}
	return false;
}

$(".deleteItem").click(deleteItem);
EOD;

Yii::app()->clientScript->registerScript('userShow', $script, CClientScript::POS_READY);

$items = array();
$items[] = array('Group Listing',array('list'));
$items[] = array('Rename Group',array('update','id'=>$group->id));
$items[] = array('Delete Group',array('delete','id'=>$group->id), 'htmlOptions'=>array('class' => 'deleteItem'));
$this->widget('application.components.Menu',array('items'=>$items));
?>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($group->getAttributeLabel('name')); ?></th>
    <td><?php echo CHtml::encode($group->name); ?></td>
</tr>
</table>
