<?php

$script = <<<EOD

function updatePage() {
	$('#listPage .pager ul').after('<div style="display:inline;">Loading...</div>');
	$.post($(this).attr('href'), {}, function(page) {
		$('#listPage').html(page);
		
		$('.yiiPager a').bind("click", updatePage);
		$('#listPage #sort-buttons a').bind("click", updatePage);
		$('#listPage .deleteItem').bind("click", deleteItem);
	});

	return false;
}

function deleteItem(){
	if (confirm('Are you sure you want to delete the user "'+$(this).parent().parent().find(".username a").html()+'"?')) {
		$.post($(this).attr('href'), {}, function(response) {
		});
		$(this).parent().parent().fadeOut("slow");
	}
	
	return false;
}

$(".deleteItem").click(deleteItem).ajaxError(function(event, request, settings){
  alert("Error requesting page " + settings.url);
});

$('#sort-buttons a, .yiiPager a').click(updatePage);

EOD;

//echo CHtml::script($script);
Yii::app()->clientScript->registerScript('userListPagination', $script, CClientScript::POS_READY);
//Yii::app()->clientScript->registerCoreScript('jquery'); //not needed when using CClientScript::POS_READY

?>
<h2>User List</h2>
<div id="listPage">
	<?php
		$this->renderPartial('listPage', compact('users', 'pages', 'sort'));
	?>
</div>