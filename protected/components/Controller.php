<?php
class Controller extends CController {
	public $operations=array();
	
	public function filterAccessControl($filterChain) {
		$filter=new AccessControlFilter;
		$filter->setRules($this->accessRules());
		$filter->filter($filterChain);
	}
	
}