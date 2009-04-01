<div class="actionBar">
<?php
$amount = count($items);
foreach($items as $n => $item){
	echo CHtml::link($item['label'],$item['exactUrl'], $item['htmlOptions']);
	if ($amount != $n+1)
		echo ' | ';
}
?>
</div>