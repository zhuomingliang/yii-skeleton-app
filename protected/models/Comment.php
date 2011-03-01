<?php

class Comment extends ActiveRecord
{
	/**
     * The followings are the available columns in table 'Comment':
	 * @var integer $id
	 * @var integer $user_id
	 * @var integer $post_id
	 * @var string $title
	 * @var string $content
	 * @var string $content_parsed
	 * @var string $created
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function behaviors(){
		return array(
			'ParseCacheBehavior' => array(
				'class' => 'ParseCacheBehavior',
				'attributes' => array('content'),
			),
			'AutoTimestampBehavior' => array(
				'class' => 'AutoTimestampBehavior',
				'modified' => null,
			)
		);
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('content','length','max'=>2000, 'min'=>2),
			array('content, post_id', 'required'),
			array('post_id', 'exist', 'className'=>'Post', 'attributeName' => 'id'),			
			array('post_id', 'numerical', 'integerOnly' => true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'post' => array(self::BELONGS_TO, 'Post', 'post_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}
	protected function beforeValidate() {
		if ($this->isNewRecord)
			$this->user_id = Yii::app()->user->id;
			
		return parent::beforeValidate();	
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'=>'Id',
			'user_id'=>'User',
			'post_id'=>'Post',
			'content'=>'Content',
			'created'=>'Date Created',
		);
	}
}