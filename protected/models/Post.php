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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'comments' => array(self::HAS_MANY, 'Comment', 'post_id', 'with'=>'user'),
		);
	}
	public function safeAttributes() {
		/**
		* ActiveRecord is extended to know that 'required' attributes are 'safe'.
		* We return a empty array so that it won't think 'created' and 'modified' are 'safe'.
		* It will still know 'title' and 'content' are safe because they are 'required'
		*/
		return array(); 
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