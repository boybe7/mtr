<?php
$this->breadcrumbs=array(
	'Plans'=>array('index'),
	'Manage',
);
?>
<h3>กำหนดเป้าหมายประจำปี</h3>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'plan-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'sample',
		'income',
		'year',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
