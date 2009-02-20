<div class="yiiForm">

<?php echo CHtml::form(); ?>

<?php echo CHtml::errorSummary($post); ?>

<div class="simple">
<?php echo CHtml::activeLabel($post,'title'); ?>
<?php echo CHtml::activeTextField($post,'title'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabel($post,'content'); ?>
<?php echo CHtml::activeTextArea($post,'content',array('style'=>'height:250px')); ?>
<p class="hint">
You may enter content using <?php echo CHtml::link('Markdown syntax', 'http://daringfireball.net/projects/markdown/syntax', array('target'=>'_blank'))?>.
</p>
</div>
<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

</form>
</div><!-- yiiForm -->