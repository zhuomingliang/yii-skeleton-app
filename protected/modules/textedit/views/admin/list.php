<h2>TextEdit module administration</h2>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
<?php
foreach ($records as $record) {
	echo '<h6>..:: id: '.$record->namedId.' ::..</h6>';
	$this->widget('textedit.components.TextEditor', array('AR'=>$record));
}
?>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>