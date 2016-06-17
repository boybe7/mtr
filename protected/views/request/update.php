<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	'Update',
);

?>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model,'num'=>$num,'modelReqSD1'=>$modelReqSD1,'modelReqSD2'=>$modelReqSD2,'modelReqSD3'=>$modelReqSD3,'title'=>'แก้ไขลงทะเบียนรับตัวอย่าง')); ?>