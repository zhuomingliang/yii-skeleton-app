<h2>Admin Panel</h2>
<?php
$this->widget('Menu',array(
	'items'=>AdminController::menu(),
	'view' => 'menuAdmin'
)); ?>