<ul>
<?php foreach($items as $item): ?>
<li><?php echo CHtml::link($item['label'],$item['exactUrl'], $item['htmlOptions']); ?></li>
<?php endforeach; ?>
</ul>
