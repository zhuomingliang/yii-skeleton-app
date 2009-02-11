<?php
class WebUser extends CWebUser {
	public $email;
	public $rank = 1;
	
	public function init() {
		parent::init();
		
		/*
		* Sets the user email and rank
		* The reason I use this method is so that I can access the user states as attributes (you can do that anyways as of Yii 1.0.3 though)
		* and so that the user rank defaults to 1 (meaning not logged on)
		* See the group model for information on the ranks
		*/
		$this->email = $this->getState('email');
		$rank = $this->getState('rank');
		if ($rank != null)
			$this->rank = $rank;
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
	
}
?>
