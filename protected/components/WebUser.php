<?php
class WebUser extends CWebUser {
	public $email;
	public $rank = 1;
	
	/**
	* Holds an AR intance of the logged in user, or null otherwise
	*/
	public $data;
	
	public function init() {
		parent::init();
		
		if (($user = $this->getState('userModel')) !== null) {
			$this->setUserData(unserialize($user));
		}
	}
	/*
	* This sets the persistant data as well as setting the email and rank.
	* The email is only set here for backward compatability
	* The user rank defaults to 1 (meaning not logged on)
	* See the group model for information on the ranks
	*/
	public function setUserData($user) {
			$this->data = $user;
			$this->email = $this->data->email; //old, needs to go
			$this->rank = $this->data->group_id;
	}
	/**
	* Compares the current user to $rank
	*
	* Should be used in view to decide if e.g. an admin-only link should be rendered
	* Example:
	* <?php if (Yii::app()->user->hasAuth(Group::ADMIN, 'min')){ ?>
	* 	<p>Something only an admin or higher ranking user should see</p>
	* <?php } ?>
	*
	* This is a very simple yet fairly flexible authorization technic.
	* Note I have also extended the AccessControlFilter to be simpler and yet also
	* reasonably flexible
	* 
	* @param integer the rank to campare the current user to
	* @param string the camparison type.  Can be 'min', 'max', or 'equal'
	*/
	public function hasAuth($rank = 2, $comparison = 'min') {
		$mapConditions = array(
			'min' => ($this->rank >= $rank),
			'max' => ($this->rank <= $rank),
			'equal' => ($this->rank == $rank),
		);
		return $mapConditions[$comparison];
	}
	
	/**
	* @param string the id of the flash
	* @param mixed you may set this argument to the name of the view file to imbed the flash in
	* (you may access the flash content in the view via $content), or an array of the form:
	* array(<before>, <after>), where <before> is rendered before the flash and <after> after it.
	* Or, you may leave it as null to wrap it in <p class="flash"></p> (the default)
	* @param mixed value to be returned if the flash message is not available.
	* @param boolean whether to delete this flash message after accessing it. Defaults to true.
	* @param whether to return the flash or echo it.  Defaults to false (eg echo it)
	* @return mixed the message message
	*/
	public function flash($id, $view=null, $defaultValue=null,$delete=true, $return=false) {
		if (!$this->hasFlash($id))
			return;
			
		$flash = $this->getFlash($id, $defaultValue, $delete);
		
		if ($view==null)
			$buff = '<p class="flash">'.$flash.'</p>';
		elseif (is_array($view))
			$buff = $view[0].$flash.$view[1];
		else
			$buff = Yii::app()->controller->renderPartial('application.views.flash.'.$view, array('content'=>$flash), true);
		
		if ($return)
			return $buff;
		else
			echo $buff;
	}


	/**
	 * Populates the current user object with the information obtained from cookie.
	 * This method is used when automatic login ({@link allowAutoLogin}) is enabled.
	 * The user identity information is recovered from cookie.
	 * Sufficient security measures are used to prevent cookie data from being tampered.
	 * @see saveToCookie
	 */
	protected function restoreFromCookie()
	{
		$app=Yii::app();
		$cookie=$app->getRequest()->getCookies()->itemAt($this->getStateKeyPrefix());
		if($cookie && !empty($cookie->value) && ($data=$app->getSecurityManager()->validateData($cookie->value))!==false)
		{
			$data=unserialize($data);
			if(isset($data[0],$data[1])) {
				list($id,$password)=$data;
				$identity = new UserIdentity;
				$identity->id = $id;
				$identity->password = $password;
				$identity->authenticate();
				
				if ($identity->errorCode == UserIdentity::ERROR_NONE)
					$this->changeIdentity($identity->getId(),$identity->getName(),$identity->getPersistentStates());
				else
					throw new CHttpException(500,'Bad cookie information.');
			}
		}
	}

	/**
	 * Saves necessary user data into a cookie.
	 * This method is used when automatic login ({@link allowAutoLogin}) is enabled.
	 * This method saves user ID and hashed password
	 * These information are used to do authentication next time when user visits the application.
	 * @param integer number of seconds that the user can remain in logged-in status. Defaults to 0, meaning login till the user closes the browser.
	 * @see restoreFromCookie
	 */
	protected function saveToCookie($duration)
	{
		$app=Yii::app();
		$cookie=$this->createIdentityCookie($this->getStateKeyPrefix());
		$cookie->expire=time()+$duration;
		$data=array(
			$this->data->id,
			$this->data->password,
		);
		$cookie->value=$app->getSecurityManager()->hashData(serialize($data));
		$app->getRequest()->getCookies()->add($cookie->name,$cookie);
	}
}
