<?php
$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	'Update',
);


?>

<h4>แก้ไขข้อมูล</h4>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>