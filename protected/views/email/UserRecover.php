<?php
$email->subject = 'User Recovery';
?>

<p>
You have requested us to recover your login credentials at <?php echo CHtml::encode(Yii::app()->name); ?> (<?php echo CHtml::link(Yii::app()->request->getBaseUrl(true), Yii::app()->request->getBaseUrl(true)) ?>).
</p>

<p>
Your Username: <?php echo $user->username ?>
<?php if ($newPassword) { ?>
Your New Password: <?php echo $user->passwordUnHashed ?>
</p>
<p>
You may change your password in your 
<?php
$url = Yii::app()->request->getHostInfo().CHtml::normalizeUrl(array('user/update'));
echo CHtml::link('account settings', $url);
?>.
<?php } else { ?>
</p>
<p>
Unfortunetally we are not able to recover your password as it is encrypted.  However, you may reset it and we will send a new randomly generated password to you.  After you attain your new password, you may change it under
<?php
$url = Yii::app()->request->getHostInfo().CHtml::normalizeUrl(array('user/update'));
echo CHtml::link('account settings', $url);
?>.
To reset your password, please click the following url:
<?php
$url = Yii::app()->request->getHostInfo().CHtml::normalizeUrl(array('user/recoverPassword', 'id'=>$user->id, 'pass'=>$user->password));
echo CHtml::link($url, $url);
}
?>
</p>