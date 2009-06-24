<p>
<?php
$email->subject = 'Please Confirm Email';

echo $user->username; ?>,
</p>
<?php if ($user->isNewRecord) { ?>
<p>
Thank you for registering at <?php echo Html::encode(Yii::app()->name); ?> (<?php echo Html::link(Yii::app()->request->getBaseUrl(true), Yii::app()->request->getBaseUrl(true)) ?>)
</p>
<p>
Username: <?php echo $user->username; ?>
<br />
Password: <?php echo $user->passwordUnHashed ?>
</p>
<?php } else {?>
<p>
You have changed your email at <?php echo Html::encode(Yii::app()->name); ?> (<?php echo Html::link(Yii::app()->request->getBaseUrl(true), Yii::app()->request->getBaseUrl(true)) ?>).  You must now re-verify your email to login.
</p>
<?php }?>
<p>
Follow this link to activate your account:<br />
<?php
$url = Yii::app()->request->getHostInfo().Html::normalizeUrl(array('user/verify', 'id'=>$user->id, 'code'=>$user->email_confirmed));
echo Html::link($url, $url);
?>
</p>