<?php
$script = <<<EOD
$('#createForm').hide();
$('#newGroup').click(function() {
	$(this).hide();
	$('#createForm').show();
	return false;
}).show();

EOD;

Yii::app()->clientScript->registerScript('groupList', $script, CClientScript::POS_READY);
JavaScript::deleteItem();
?>

<h2>Groups</h2>
<h3>Adding a group</h3>
<p>To add a group, first add one here by clicking "New Group".  The group's id is it's user level.  Usually, the higher the number, the more powers.  After you have added the group here, edit the Group.php model file and add a class constant to Group (following the order of the other constants).</p>
<p>
<?php
echo Html::link('New Group',array('create'), array('id'=>'newGroup', 'style'=>'display:none'))
.Html::form('create', 'post', array('id'=>'createForm'))
.Html::textField('Group[name]','',array('size'=>20))
.Html::submitButton('Add').'</form>';
?>
</p>

<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('id'); ?></th>
    <th><?php echo $sort->link('name'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($groups as $n=>$group): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo Html::link($group->id,array('show','id'=>$group->id)); ?></td>
    <td><?php echo Html::encode($group->name); ?></td>
    <td>
      <?php echo Html::link('Rename',array('update','id'=>$group->id)); ?>
      <?php echo Html::link('Delete', array('delete','id'=>$group->id), array('class'=>'deleteItem')); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>