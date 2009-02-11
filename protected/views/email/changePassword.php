<p>
<?php
$email->subject = 'New Password';

echo $user->username; ?>,
</p>

<p>
You have changed your password at <?php echo CHtml::encode(Yii::app()->name); ?> (<?php echo CHtml::link(Yii::app()->request->getBaseUrl(true), Yii::app()->request->getBaseUrl(true)) ?>).  Please keep this email for your records.
</p>

<p>
New Password: <?php echo $user->passwordUnHashed ?>
</p>