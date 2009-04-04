<?php
/**
 * Menu is a widget displaying menu items.
 *
 */
class Menu extends CWidget
{
	/**
	* Items.
	* 
	* 	array('label', 'url', additional options..)
	* 
	* Additional Options:
	* - visible
	* - pattern
	* 		pattern used to check if this item matches current page.  Otherwise the url 
	* 		option is used
	* - htmlOptions
	*/
	public $items=array();

	/**
	* Whether to hide any active/open menu items
	*/
	public $hideActive=false;

	/**
	* The view to use
	*/
	public $view='menu';
	
	public function run()
	{
		$items=array();
		$controller=$this->controller;
		$action=$controller->action;
		foreach($this->items as $item)
		{
			if(isset($item['visible']) && !$item['visible'])
				continue;
		
			$pattern=isset($item['pattern'])?$item['pattern']:$item[1];
			$active=$this->isActive($pattern,$controller->id,$action->id);
			if ($this->hideActive && $active)
				continue;
				
			$item2['label']=$item[0];
			$item2['url'] = $item[1];
				
			$item2['htmlOptions'] = isset($item['htmlOptions']) ? $item['htmlOptions'] : array();
			if ($active) {
				if (isset($item2['htmlOptions']['class']))
					$item2['htmlOptions']['class'] .= ' active';
				else
					$item2['htmlOptions']['class'] = 'active';
			}

			$items[]=$item2;
		}
		$this->render($this->view,compact('items'));
	}

	protected function isActive($pattern,$controllerID,$actionID)
	{
		if(!is_array($pattern) || !isset($pattern[0]))
			return false;
		$pattern[0]=trim($pattern[0],'/');
		if(strpos($pattern[0],'/')!==false)
			$matched=$pattern[0]===$controllerID.'/'.$actionID;
		else
			$matched=$pattern[0]===$controllerID;

		if($matched && count($pattern)>1)
		{
			foreach(array_splice($pattern,1) as $name=>$value)
			{
				if(!isset($_GET[$name]) || $_GET[$name]!=$value)
					return false;
			}
			return true;
		}
		else
			return $matched;
	}
}