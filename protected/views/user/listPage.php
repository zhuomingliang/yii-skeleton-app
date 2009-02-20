<div class="pager">
<?php echo $this->widget('CLinkPager',array('pages' => $pages, 'cssFile'=>Yii::app()->request->baseUrl.'/css/pager.css')); ?>
</div>
<table class="dataGrid">
	<tr id="sort-buttons">
		<th><?php echo $sort->link('user.username'); ?></th>
		<th><?php echo $sort->link('user.group_id'); ?></th>
		<th><?php echo $sort->link('user.email'); ?></th>
		<th><?php echo $sort->link('user.created'); ?></th>
		<th><?php echo $sort->link('user.email_confirmed'); ?></th>
		<?php if (Yii::app()->user->hasAuth(Group::ADMIN)){ ?><th>Actions</th><?php } ?>
	</tr>
<?php foreach($users as $n => $user): ?>
	<tr class="<?php echo $n%2 ? 'even' : 'odd' ?>">
		<td class="username"><?php echo CHtml::link(CHtml::encode($user->username), array('show', 'id'=>$user->id)); ?></td>
		<td><?php echo $user->group->name; ?></td>
		<td><?php echo $user->publicEmail; ?></td>
		<td><?php echo Time::niceShort($user->created); ?></td>
		<td><?php echo $user->activated ? 'Yes' : 'No'; ?></td>
		<?php if (Yii::app()->user->hasAuth(Group::ADMIN)){ ?>
		<td>
			<?php echo CHtml::link('Modify',array('update','id' => $user->id));
			
			//I am using a normal link below instead of this for unobtrusive javascript with jquery
			//just to remind myself
			//echo CHtml::linkButton('Delete', array('submit' => array('delete', 'id' => $user->id), 'confirm' => 'Are you sure?'));
			?>
			|
			<?php echo CHtml::link('Delete', array('delete', 'id' => $user->id), array('class' => 'deleteItem'));
			?>
		</td>
		<?php } ?>
	</tr>
<?php endforeach; ?>
</table>

<?php //echo $this->widget('CLinkPager',array('pages' => $pages));