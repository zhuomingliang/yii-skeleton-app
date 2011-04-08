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
	public $AR = null;
	public $defaultMsg = '<b>Click here to enter text</b>';
	
	protected $model;
	
	/**
	 * Initializes the widget.
	 * This method starts the output buffering.
	 */
	public function init()
	{
		Yii::app()->getModule('textedit');
		
		if ($this->AR == null) {
			$this->model = Textedit::model()->find('namedId=:id', array('id'=>$this->id));
			if (!$this->model) {
				$this->model = new Textedit;
				$this->model->namedId = $this->id;
			}
		} else {
			$this->model = $this->AR;
		}
		
		if (!Yii::app()->user->hasAuth(Group::ADMIN)) {
			if ($this->model->content)
				echo $this->model->getMarkdown('content', false);
			return;	
		}

		$this->registerScript();
		echo '<div class="texteditId">Id: '.$this->model->namedId.'</div>
		<div class="textedit" id="textedit_'.$this->model->namedId.'">';
		
		if ($this->model->content)
			echo $this->model->getMarkdown('content', false);
		else
			echo '<p>'.$this->defaultMsg.'</p>';
		
		echo '</div>';
	}
	protected function registerScript() {
		if (Yii::app()->clientScript->isScriptRegistered('textedit', CClientScript::POS_READY))
			return;

		Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.jeditable.mini.js');
		$controllerProcess = CHtml::normalizeUrl(array('/textedit/textedit/process'));
		$controllerLoadRaw = CHtml::normalizeUrl(array('/textedit/textedit/loadraw'));
		$script = <<<EOD
		$('.textedit').editable('$controllerProcess', {
			loadurl: '$controllerLoadRaw',
			loaddata: {id: this.id},
			submitdata: {id: this.id},
			onblur: 'ignore',
			submit: 'OK',
			type: 'textarea',
			cancel: 'Cancel'
		}).hover(function() {
		    $(this).css({'backgroundColor': '#FDFD72'});
		}, function() {
		    $(this).css({'backgroundColor': ''});
		});
EOD;
		Yii::app()->clientScript->registerScript('textedit', $script, CClientScript::POS_READY);
	}
}