<?php
$this->breadcrumbs=array(
	'Jobs'=>array('index'),
	'Manage',
);

?>

<h3>ประเภทงาน</h3>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'job-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
