<?php
class Html extends CHtml {
	/**
	* Makes the given URL relative to the /image directory
	*/
	public static function imageUrl($url) {
		return Yii::app()->baseUrl.'/images/'.$url;
	}
	public static function cssUrl($url) {
		return Yii::app()->baseUrl.'/css/'.$url;
	}
	public static function jsUrl($url) {
		return Yii::app()->baseUrl.'/js/'.$url;
	}
	public static function jqueryCssUrl($url) {
		return Yii::app()->baseUrl.'/js/jqueryUI/theme/'.$url;
	}
	public static function addClass(&$htmlOptions, $class) {
		if (isset($htmlOptions['class']))
			$htmlOptions['class'] .= ' '.$class;
		else
			$htmlOptions['class'] = $class;
	}
	//I was hoping this would work, but because there are no late-static bindings it does not
//	public static function tag($tag,$htmlOptions=array(),$content=false,$closeTag=true) {echo 'aaab';
//		if ($tag == 'input') {
//			if ($htmlOptions['type'] == 'submit')
//				self::addClass($htmlOptions, 'submit');
//			elseif ($htmlOptions['type'] == 'checkbox')
//				self::addClass($htmlOptions, 'checkbox');
//		}
//		return parent::tag($tag,$htmlOptions,$content,$closeTag);	
//	}
	public static function submitButton($label='submit',$htmlOptions=array())
	{
		self::addClass($htmlOptions, 'submit');
		return parent::submitButton($label,$htmlOptions);
	}
	public static function activeCheckBox($model,$attribute,$htmlOptions=array())
	{
		self::addClass($htmlOptions, 'checkbox');
		return parent::activeCheckBox($model,$attribute,$htmlOptions);
	}
	public static function checkBox($name,$checked=false,$htmlOptions=array())
	{
		self::addClass($htmlOptions, 'checkbox');
		return parent::checkBox($name,$checked,$htmlOptions);
	}
}