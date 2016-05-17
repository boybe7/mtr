<?php
$this->breadcrumbs=array(
	'Labtypes'=>array('index'),
	'Create',
);

?>

<?php echo $this->renderPartial('_formTemplate', array('model'=>$model,'id'=>$id,'title'=>'บันทึก template')); ?>