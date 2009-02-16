<?php
//please ignore
class LogableBehavior extends CActiveRecordBehavior {
	protected $_oldAttributes = array();
 	
	public function afterSave($event) {
		if ($this->Owner->isNewRecord) {
			
			$log=new ActiveRecordLog;
			$log->description = 'User ' . Yii::app()->user->Name . ' created ' . get_class($this->Owner) . '[' . $this->Owner->getPrimaryKey() .'].';
			$log->action = 'CREATE';
			$log->model = get_class($this->Owner);
			$log->idModel = $this->Owner->getPrimaryKey();
			$log->field = '';
			$log->creationdate = new CDbExpression('NOW()');
			$log->userid = Yii::app()->user->id;
			$log->save();
		} else {
			
			$oldAttributes = $this->_oldAttributes;
			$newAttributes = $this->Owner->getAttributes();
			
			// compare old and new
			foreach ($newAttributes as $name => $new) {
				$old = $oldAttributes[$name];
				if ($new === null)
					continue;
				
				if ($new != $old) {
					//echo $name . ' ('.$old.') => ('.$new.'), ';

					$log=new ActiveRecordLog;
					$log->description = 'User '.Yii::app()->user->Name.' changed '.$name.' for '.get_class($this->Owner).'['.$this->Owner->getPrimaryKey().'].';
					$log->action = 'CHANGE';
					$log->model = get_class($this->Owner);
					$log->idModel = $this->Owner->getPrimaryKey();
					$log->field = $name;
					$log->creationdate = new CDbExpression('NOW()');
					$log->userid = Yii::app()->user->id;
					$log->save();
				}
			}
		}
	}


	public function afterDelete($event) {
		$log=new ActiveRecordLog;
		$log->description = 'User ' . Yii::app()->user->Name . ' deleted ' . get_class($this->Owner) . '[' . $this->Owner->getPrimaryKey() .'].';
		$log->action = 'DELETE';
		$log->model = get_class($this->Owner);
		$log->idModel = $this->Owner->getPrimaryKey();
		$log->field = '';
		$log->creationdate = new CDbExpression('NOW()');
		$log->userid = Yii::app()->user->id;
		$log->save();
	}


	public function afterFind($event) {
		// Save old values
		$this->_oldAttributes = $this->Owner->getAttributes();
	}
}