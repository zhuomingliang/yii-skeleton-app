<?php
JavaScript::deleteItem();
?>

<h2>Managing Post</h2>

<?php
$items = array();
$items[] = array('Post List',array('list'));
$items[] = array('New Post',array('create'));
$this->widget('application.components.Menu',array('items'=>$items));
?>


<table class="dataGrid">
  <tr>
    <th><?php echo $sort->link('id'); ?></th>
    <th><?php echo $sort->link('user_id'); ?></th>
    <th><?php echo $sort->link('title'); ?></th>
    <th><?php echo $sort->link('created'); ?></th>
    <th><?php echo $sort->link('modified'); ?></th>
	<th>Actions</th>
  </tr>
<?php foreach($postList as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo CHtml::encode($model->user_id); ?></td>
    <td><?php echo CHtml::encode($model->title); ?></td>
    <td><?php echo CHtml::encode($model->created); ?></td>
    <td><?php echo CHtml::encode($model->modified); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->id)); ?>
      <?php echo CHtml::link('Delete',array('delete','id'=>$model->id), array('class'=>'deleteItem')); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>