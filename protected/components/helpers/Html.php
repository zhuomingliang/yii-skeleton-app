<?php
class Html extends CHtml {
	/**
	* Makes the given URL relative to the /image directory
	*/
	public static function imageUrl($url) {
		return Yii::app()->baseUrl.'/images/'.$url;
	}
}