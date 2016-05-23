<?php
$this->breadcrumbs=array(
	'Contracts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Contract','url'=>array('index')),
	array('label'=>'Create Contract','url'=>array('create')),
	array('label'=>'Update Contract','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Contract','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Contract','url'=>array('admin')),
);
?>

<h1>View Contract #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'status',
	),
)); ?>
