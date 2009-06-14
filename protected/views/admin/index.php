<h2>Admin Panel</h2>
<?php
$this->widget('Menu',array(
	'items'=>array(
		array('Groups', array('/group/list')),
		array('TextEdit module', array('/textedit/admin/list')),
	),
	'view' => 'menuAdmin'
)); ?>