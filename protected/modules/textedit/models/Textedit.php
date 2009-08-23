<?php
class Textedit extends ActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	public function behaviors(){
		return array(
			'ParseCacheBehavior' => array(
				'class' => 'ParseCacheBehavior',
				'attributes' => array('content'),
				'safeTransform' => false,
			),
		);
	}	
}