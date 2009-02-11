<h2>Group List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New Group',array('create')); ?>]
</div>

<table class="dataGrid">
  <tr>
    <th><?php echo $this->generateColumnHeader('id'); ?></th>
    <th><?php echo $this->generateColumnHeader('name'); ?></th>
    <th><?php echo $this->generateColumnHeader('created'); ?></th>
    <th><?php echo $this->generateColumnHeader('modified'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($groupList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->name); ?></td>
    <td><?php echo CHtml::encode($model->created); ?></td>
    <td><?php echo CHtml::encode($model->modified); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->id)); ?>
      <?php echo CHtml::linkButton('Delete',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>