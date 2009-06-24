<div class="yiiForm">

<?php echo Html::form(); ?>

<?php echo Html::errorSummary($post); ?>

<div class="simple">
<?php echo Html::activeLabel($post,'title'); ?>
<?php echo Html::activeTextField($post,'title'); ?>
</div>
<div class="simple">
<?php echo Html::activeLabel($post,'content'); ?>
<?php echo Html::activeTextArea($post,'content',array('style'=>'height:250px')); ?>
<p class="hint">
You may enter content using <?php echo Html::link('Markdown syntax', 'http://daringfireball.net/projects/markdown/syntax', array('target'=>'_blank'))?>.
</p>
</div>
<div class="action">
<?php echo Html::submitButton($update ? 'Save' : 'Create'); ?>
</div>

</form>
</div><!-- yiiForm -->