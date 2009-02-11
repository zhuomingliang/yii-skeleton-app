<?php
$email->subject = 'User Recovery';
?>

<p>
You have requested us to recover your login credentials at <?php echo CHtml::encode(Yii::app()->name); ?> (<?php echo CHtml::link(Yii::app()->request->getBaseUrl(true), Yii::app()->request->getBaseUrl(true)) ?>).
</p>

<p>
Your Username: <?php echo $user->username ?>
<br />Unfortunetally we are not able to recover your password as it is encrypted
</p>