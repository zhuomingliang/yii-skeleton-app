<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_EMAIL_INVALID=3;
	public $user;

	public $id;
	
	public function __construct($username=null,$password=null) {
		$this->username=$username;
		$this->password=$password;
	}
	
	public function authenticate() {
		$criteria = new CDbCriteria;
		if (isset($this->id)) {
			$criteria->condition = 'id=:id';
			$criteria->params['id'] = $this->id;
		} else {
			$criteria->condition = 'username=:username';
			$criteria->params['username'] = $this->username;
		}
		$record = User::model()->find($criteria);
		
		if ($record === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} elseif ($record->password !== $this->password) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} elseif ($record->email_confirmed != null) {
			$this->errorCode = self::ERROR_EMAIL_INVALID;
		} else {
			$this->user = $record;
			$this->setState('userModel', serialize($record));
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;
	}
	
	public function getId(){
		return $this->user->id;
	}
	
	public function getName() {
		return $this->user->username;
	}
}