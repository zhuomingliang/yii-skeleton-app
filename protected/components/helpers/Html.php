<?php
class Html extends CHtml {
	/**
	* Creates absolute link
	*/
	public static function absoluteLink($text,$url='#',$htmlOptions=array(), $rememberClient=false) {
		$url = Yii::app()->request->getHostInfo().parent::normalizeUrl($url);
		return parent::link($text,$url,$htmlOptions,$rememberClient);
	}
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
	/**
	* Creates a date/time field (which is actually contains 4 sub-fields).
	* The model must contain the attribute argumented to this method, and in addition
	* must have the attributes: $attribute.'H', $attribute.'M', $attribute.'PM'.  Works
	* well with the TimeBehavior.  Unfortunitally the behavior can not create the extra needed
	* attributes for you, so you need to add them to the model yourself
	* 
	* @param mixed $model
	* @param mixed $attribute
	* @param mixed $htmlOptions
	*/
	public static function activeDatetime($model,$attribute, $htmlOptions=array()) {
		self::resolveNameID($model,$attributeD=$attribute.'D', $htmlOptions);
		$nameId = $htmlOptions['id'];
		$script = <<<EOD
		var activity;
		$("#$nameId").datepicker();
EOD;
		Yii::app()->clientScript->registerScript('datetime_'.$nameId, $script, CClientScript::POS_READY);
		JavaScript::calenderLoad();
		$hours = array(0=>'Hour');
		for($i=1;$i<=12;$i++) $hours[$i]=$i;
		$minutes = array(-1=>'Minute');
		for($i=0;$i<=59;$i++) $minutes[$i]=str_pad($i, 2, '0', STR_PAD_LEFT);
		return self::activeTextField($model, $attributeD, array('style'=>'width:100px'))
		.' '.self::activeDropDownList($model, $attribute.'H', $hours)
		.':'.self::activeDropDownList($model, $attribute.'M', $minutes)
		.' '.self::activeDropDownList($model, $attribute.'PM', array(0=>'am', 1=>'pm'))
		;
	}
}