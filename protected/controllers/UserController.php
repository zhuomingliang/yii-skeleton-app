<?php
class UserController extends Controller {
	
	/**
	 * @var string specifies the default action to be 'list'.
	 */
	public $defaultAction='list';

	/**
	 * Specifies the action filters.
	 * This method overrides the parent implementation.
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules() {
		return array(
			'logout, update',
			'login, create, recover' => array(Group::GUEST, 'equal'),
			'delete' => array(Group::ADMIN, 'min'),
		);
	}


	public function actionLogin() {
		$user = new User;
		if (Yii::app()->request->isPostRequest) {
			// collect user input data
			if (isset($_POST['User']))
				$user->setAttributes($_POST['User']);
			// validate user input and redirect to previous page if valid
			if ($user->validate('login'))// ;
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('user' => $user));
	}

	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionList() {
		$criteria = new CDbCriteria;

		$pages = new CPagination(User::model()->count($criteria));
		$pages->pageSize = 25;
		$pages->applyLimit($criteria);
		
		$sort = new CSort('user');
		$sort->attributes = array(
			'user.username'=>'username',
			'user.group_id'=>'group_id',
			'user.email'=>'email',
			'user.created'=>'created',
			'user.email_confirmed'=>'email_confirmed',
		);
		$sort->applyOrder($criteria);
		
		$users=User::model()->with('group')->findAll($criteria);
		
		//The user list supports AJAX.  Not sure if this is a good thing in this case,
		//but I'll leave it as an example
		if (Yii::app()->request->isAjaxRequest)
			$this->renderPartial('listPage', compact('users', 'pages', 'sort'));
		else
			$this->render('list', compact('users', 'pages', 'sort'));
	}

	public function actionShow() {
		$user = $this->loadUser(isset($_GET['id']) ? $_GET['id'] : Yii::app()->user->id);

		$this->render('show', compact('user'));
	}

	public function actionCreate() {
		$user = new User;
		
		if (isset($_POST['User'])) {
			$user->setAttributes($_POST['User'], 'register');

			$user->activated = false;
			if ($user->validate('register')) {
				$user->encryptPassword();
				if ($user->save(false))
					$this->redirect(array('site/index'));
			}
		}
		$this->render('create', compact('user'));
	}

	public function actionUpdate() {
		$id = isset($_GET['id']) ? $_GET['id'] : Yii::app()->user->id;
		
		if ((!Yii::app()->user->hasAuth(Group::ADMIN)) && ($id != Yii::app()->user->id))
			throw new CHttpException(404, 'Permission Denied');

		$user = $this->loadUser($id);
		
		if (isset($_POST['User'])) {
			$oldEmail = $user->email;
			$user->setAttributes($_POST['User'], 'update');

			if ($user->validate('update')) {
				$redirect = array('show', 'id'=>$id);
				
				//email logic
				if ($user->email != $oldEmail) {
					$user->activated = false;
					$redirect = array('site/index');
				}
				
				//so not to save blank password
				if (empty($user->password))
					unset($user->password);
				else {
					$user->encryptPassword();
					//email notification of new password
					$user->sendNewPassword = true;
				}
				
				if ($user->save(false))
					$this->redirect($redirect);

			}
		}
		unset($user->password);
		$this->render('update', compact('user'));
	}
	
	public function actionRecover() {
		$user = new User;

		if (isset($_POST['User'])) {
			$user->setAttributes($_POST['User']);

			if ($user->validate('recover')) {				
				$found = User::model()->findByAttributes(array('email'=>$user->email));
				
				if ($found !== null) {
					$email = Yii::app()->email;
					$email->to = $found->email;
					$email->view = 'UserRecover';
					$email->send(array('user' => $found, 'newPassword'=>false));
					Yii::app()->user->setFlash('recover', "An email has been sent to {$user->email}.  Please check your email.");
					$this->refresh();
				} else {
					$user->addError('email', 'Email not found');
				}
			}
		}

		$this->render('recover', compact('user'));
	}
	public function actionRecoverPassword() {
		if (!isset($_GET['id'], $_GET['pass']))
			throw new CHttpException(404,'Invalid request');
			
		if ($user = User::model()->findbyPk($_GET['id'])) {
			if ($user->password != $_GET['pass']) 
				throw new CHttpException(404,'Invalid auth key');
			$user->password = $user->generatePassword(6);
			$user->encryptPassword();
			$user->save(false);
			
			$email = Yii::app()->email;
			$email->to = $user->email;
			$email->view = 'UserRecover';
			$email->send(array('user' => $user, 'newPassword'=>true));
			
			Yii::app()->user->setFlash('recover', "Thank you.  A new password has been sent to your email.");
			$this->render('recover',array('user' => $user));
		} else
			throw new CHttpException(404,'Invalid user');
	}

	public function actionDelete() {
		//throw new CHttpException(404,'bad'); //was used for testing ajax
		
		//  --  Sorry for the commented out code.  I may need it but just ignore  --
		//if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadUser()->delete();
			if (!Yii::app()->request->isAjaxRequest)
				$this->redirect(array('list'));
		//}
		//else
			//throw new CHttpException(404,'Invalid request. Please do not repeat this request again.  You must have JavaScript turned on!');
	}

	public function actionVerify() {
		if (!isset($_GET['id'], $_GET['code']))
			throw new CHttpException(404,'Invalid request');
			
		if ($user = User::model()->findbyPk($_GET['id'])) {
			if ($user->activated)
				throw new CHttpException(400,'User already verified');
			if ($user->activationCode == $_GET['code']) {
				$user->activated = true;
				$user->save(false);	
				$this->render('activated');
			} else
				throw new CHttpException(400,'Incorrect verification code');
		} else
			throw new CHttpException(404,'Invalid user');
			
	}
	
	protected function loadUser($id = null) {
		if ($id == null)
			$id = $_GET['id'];
		if (isset($id))
			$user = User::model()->findbyPk($id);
		if (isset($user))
			return $user;
		else
			throw new CHttpException(404,'The requested user does not exist.');
	}

}