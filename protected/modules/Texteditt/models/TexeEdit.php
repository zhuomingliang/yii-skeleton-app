<?php
class TextEdit extends ActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function behaviors(){
		return array(
			'ParseCacheBehavior' => array(
				'class' => 'application.components.ParseCacheBehavior',
				'attributes' => array('content'),
				'safeTransform' => false,
			),
		);
	}	
}