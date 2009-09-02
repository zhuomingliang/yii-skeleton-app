<?php
JavaScript::deleteItem();
?>

<h2>Managing Post</h2>

<?php
$this->operations = array(
	array('Post List',array('list')),
	array('New Post',array('create')),
);
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
    <td><?php echo Html::link($model->id,array('show','id'=>$model->id)); ?></td>
    <td><?php echo Html::encode($model->user_id); ?></td>
    <td><?php echo Html::encode($model->title); ?></td>
    <td><?php echo Time::niceShort($model->created); ?></td>
    <td><?php if ($model->modified) echo Time::niceShort($model->modified); ?></td>
    <td>
      <?php echo Html::link('Update',array('update','id'=>$model->id)); ?>
      <?php echo Html::link('Delete',array('delete','id'=>$model->id), array('class'=>'deleteItem')); ?>
	</td>
  </tr>
<?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>