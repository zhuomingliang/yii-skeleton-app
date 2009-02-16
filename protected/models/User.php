<?php

class User extends CActiveRecord
{
	public $rememberMe;
	public $password_repeat;
	
	//Unhashed password for account verification email
	public $passwordUnHashed;
	
	//Flags on whether to send certain emails in afterSave()
	protected $sendVerificationEmail = false;
	public $sendNewPassword = false;
	
	/**
	 * Returns the static model of the specified AR class.
	 * This method is required by all child classes of CActiveRecord.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
			array('username, password', 'length', 'max'=>35, 'min'=>3),
			array('about', 'length', 'max' => 5000),
			array('username', 'unique', 'on' => 'register'),
			
			array('password', 'authenticatePass', 'on' => 'login'),
			array('password', 'compare', 'on' => 'register, update'),
			
			array('email', 'length', 'max' => 40),
			array('email', 'email'),
			
			array('username, password, password_repeat, email', 'required', 'on' => 'register'),
			
			array('email', 'required', 'on' => 'recover'),
			
			array('email, email_visible, notify_comments, notify_messages', 'required', 'on' => 'update'),
			array('email_visible, notify_comments, notify_messages', 'in', 'range' => array('0','1')),
			
			array('group_id', 'numerical', 'integerOnly' => true),
		);
	}
	
	public function safeAttributes() {
		return array(
			parent::safeAttributes(),
			'update'=>'about, password, password_repeat',
			'login'=>'username, password, rememberMe',
		);
	}
	
	/*
	* I extended this method so that yii will "automagically" understand that
	* 'required' attributes (in the given scenario) are also 'safe'.  This way,
	* when defining 'safe' attributes in the safeAttributes() method, you can
	* neglect to define attributes as safe that you have already defined at "required"
	* in your rules() method.  This basically saves typing (and in some cases stupid
	* mistakes), which I am always a fan of.  This method could be moved to another model
	* from which other models like this could inherit from if you wish.
	* 
	* You should NOT call this method directly but it is used by Yii internally
	*/
	public function getSafeAttributeNames($scenario='') {
		$safe = parent::getSafeAttributeNames($scenario);
		
		foreach ($this->validators as $validator) {
			if ((get_class($validator) != 'CRequiredValidator') || !$validator->applyTo($scenario)) continue;
			$safe = array_merge($safe, $validator->attributes);
		}
		return array_unique($safe);
	}
	
	/**
	 * Authenticates the password.
	 * This is the 'authenticatePass' validator as declared in rules().
	 */
	public function authenticatePass($attribute,$params) {
		
		if (!$this->hasErrors()) { // we only want to authenticate when no input errors
			$identity = new UserIdentity($this->username,$this->password);
			$identity->authenticate();
			
			switch ($identity->errorCode) {
				case UserIdentity::ERROR_NONE:
					$duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
					Yii::app()->user->login($identity, $duration);
					break;
					
				case UserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('username','Username is incorrect.');
					break;
					
				case UserIdentity::ERROR_EMAIL_INVALID:
					$this->addError('username','You must validate your email before logging in.');
					break;
					
				default: // UserIdentity::ERROR_PASSWORD_INVALID
					$this->addError('password','Password is incorrect.');
					break;
			}
		}
	}
	
	public function relations() {
		return array(
			'group' => array(self::BELONGS_TO, 'Group', 'group_id'),
		);
	}

	public function attributeLabels() {
		return array(
			'about'=>'About Yourself',
			'group_id'=>'User Level',
			'email_confirmed'=>'Activated?',
			'created'=>'Date Registered',
			'email_visible'=>'Show Email',
			'notify_comments'=>'Notify me for comments',
			'notify_messages'=>'Notify me for messages',
		);
	}
	
	public function encryptPassword() {
		$this->passwordUnHashed = $this->password;
		$this->password = md5($this->password);
	}
	public function beforeSave() {
		if ($this->isNewRecord)
			$this->created = new CDbExpression('NOW()');
		else
			$this->modified = new CDbExpression('NOW()');
			
		return parent::beforeSave();
	}
	
	public function afterSave() {
		if ($this->sendVerificationEmail) {
			//so not to try to logout new registrations (that have not even been logged in yet)
			//must logout user before flashing, as flashes are erased when logged out.
			if ((Yii::app()->user->id == $this->id) && (!Yii::app()->user->isGuest))
				Yii::app()->user->logout();
				
			//send email
			$email = Yii::app()->email;
			$email->to = $this->email;
			$email->view = 'verifyEmail';
			$email->send(array('user' => &$this));
		}
		
		if ($this->sendNewPassword) {				
			//send email
			$email = Yii::app()->email;
			$email->to = $this->email;
			$email->view = 'changePassword';
			$email->send(array('user' => &$this));
		}
		parent::afterSave();
	}

	public function generatePassword($length=20) {
		$chars = "abcdefghijkmnopqrstuvwxyz023456789";
		srand((double)microtime()*1000000);
		$i = 0;
		$pass = '' ;
		
		while ($i <= $length) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass .= $tmp;
			$i++;
		}
		return $pass;	
	}
	
	public function getActivated() {
		return $this->email_confirmed==null;
	}
	public function setActivated($val) {
		if ($val)
			$this->email_confirmed = null;
		else {
			$this->email_confirmed = $this->generatePassword();
			
			/*
			* we don't send the verification email until afterSave() in case the user is
			* actually not saved (for some reason or another, e.g. an error)
			* So we simply set a flag instead
			*/
			$this->sendVerificationEmail = true;
		}
	}
	public function getActivationCode() {
		return ($this->email_confirmed != null) ? $this->email_confirmed : false;
	}
	public function getPublicEmail($hidden = 'Hidden') {
		return $this->email_visible ? $this->email : $hidden;
	}

}