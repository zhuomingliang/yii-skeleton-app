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
				'class' => 'ParseCacheBehavior',
				'attributes' => array('content'),
			),
			'AutoTimestampBehavior' => array(
				'class' => 'AutoTimestampBehavior',
			)
		);
	}
	
	protected function beforeValidate() {
		if ($this->isNewRecord)
			$this->user_id = Yii::app()->user->id;
			
		return parent::beforeValidate();	
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id', 'with'=>'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'created'=>'Date Created',
			'modified'=>'Date Modefied',
		);
	}
}