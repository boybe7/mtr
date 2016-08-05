<?php
$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	'Create',
);

?>

<h4><?php echo $title; ?></h4>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>