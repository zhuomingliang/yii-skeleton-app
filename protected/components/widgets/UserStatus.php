<?php
class UserStatus extends CWidget {
	public function run() {
		if (Yii::app()->user->isGuest) {
			$this->render('userStatusGuest', array());
		} else {
			$this->render('userStatusLoggedOn', array('displayName' => Yii::app()->user->name));
		}
	}
}
?>