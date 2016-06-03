<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	'Create',
);


?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'modelReqSD'=>$modelReqSD,'title'=>'เพิ่มลงทะเบียนรับตัวอย่าง')); ?>