<?php

/**
* Call it like this:
* $this->widget('path.to.widget', array('id'=><unique id>));
*/

class TextEditor extends CWidget
{
	/**
	* string unique id of the text editor
	*/
	public $id;
	public $defaultMsg = '<b>Click here to enter text</b>';
	
	protected $model;
	protected $registeredScript = false;
	
	/**
	 * Initializes the widget.
	 * This method starts the output buffering.
	 */
	public function init()
	{
		Yii::import('textedit.models.*');
		$model = Textedit::model()->find("`namedId`='{$this->id}'");
		if (!Yii::app()->user->hasAuth(Group::ADMIN)) {
			if ($model)
				echo $model->getMarkdown('content', false);
			return;	
		}
		$this->registerScript();

		echo '<div class="textedit" id="'.$this->id.'">';
		
		if ($model)
			echo $model->getMarkdown('content', false);
		else
			echo '<p>'.$this->defaultMsg.'</p>';
		
		echo '</div>';
	}
	protected function registerScript() {
		if ($this->registeredScript)
			return;
		$this->registeredScript = true;
		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.jeditable.mini.js');
		$controllerProcess = CHtml::normalizeUrl(array('textedit/textedit/process'));
		$controllerLoadRaw = CHtml::normalizeUrl(array('textedit/textedit/loadraw'));
		$script = <<<EOD
		$('.textedit').editable('$controllerProcess', {
			loadurl: '$controllerLoadRaw',
			loaddata: {id: $(this).attr('id')},
			submitdata: {id: $(this).attr('id')},
			onblur: 'ignore',
			submit: 'OK',
			type: 'textarea',
			cancel: 'Cancel'
		}).hover(function() {
		    $(this).css({'backgroundColor': '#FFFF9E'});
		}, function() {
		    $(this).css({'backgroundColor': ''});
		});
EOD;
		Yii::app()->clientScript->registerScript('textedit', $script, CClientScript::POS_READY);
	}
}