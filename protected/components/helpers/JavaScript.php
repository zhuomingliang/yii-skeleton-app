<?php
class JavaScript {
	public static function deleteItem($message='Are you sure you want to delete this?', $element='.deleteItem') {
		Yii::app()->clientScript->registerCoreScript('yii');
		$script = <<<EOD
function deleteItem(){
	if (confirm('$message')) {
		jQuery.yii.submitForm(this,this.href,{});
	}
	return false;
}

$("$element").click(deleteItem);
EOD;

		Yii::app()->clientScript->registerScript('delete', $script, CClientScript::POS_READY);
	}
	public static function makeAjaxSafe() {
		Yii::app()->log->routes['web']->enabled = false;
	}
}