<?php
$this->breadcrumbs=array(
	'Standards'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Standard','url'=>array('index')),
	array('label'=>'Create Standard','url'=>array('create')),
	array('label'=>'Update Standard','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Standard','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Standard','url'=>array('admin')),
);
?>

<h1>View Standard #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
	),
)); ?>
