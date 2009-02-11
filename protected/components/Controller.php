<?php
class Controller extends CController {
	
	public function filterAccessControl($filterChain) {
		$filter=new AccessControlFilter;
		$filter->setRules($this->accessRules());
		$filter->filter($filterChain);
	}
	
}