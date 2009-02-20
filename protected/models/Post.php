<?php
class Post extends ActiveRecord
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title','length','max'=>50),
			array('content','length','max'=>10000),
			array('title, content', 'required'),
		);
	}
	
	public function behaviors(){
		return array(
			'ParseCacheBehavior' => array(
				'class' => 'application.components.ParseCacheBehavior',
				'columns' => array('content'),
				'cssFile' => '/css/markdown.css'
			),
			'AutoTimestampBehavior' => array(
				'class' => 'application.components.AutoTimestampBehavior',
			)
		);
	}
	
	protected function beforeValidate($on) {
		if ($this->isNewRecord)
			$this->user_id = Yii::app()->user->id;
			
		return parent::beforeValidate($on);	
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'parsecache' => $this->parseCacheRelation(),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
		);
	}
}