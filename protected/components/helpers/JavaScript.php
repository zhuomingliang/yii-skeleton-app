<?php
class JavaScript {
	public static function deleteItem() {
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

	Yii::app()->clientScript->registerScript('delete', $script, CClientScript::POS_READY);
	}
	public static function makeAjaxSafe() {
		$tmp = Yii::app()->log->routes['web'];
		$tmp->enabled=false;	
	}
}