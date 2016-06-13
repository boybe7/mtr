<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	'Create',
);


?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'modelReqSD1'=>$modelReqSD1,'modelReqSD2'=>$modelReqSD2,'modelReqSD3'=>$modelReqSD3,'title'=>'เพิ่มลงทะเบียนรับตัวอย่าง')); ?>