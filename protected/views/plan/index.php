<?php
$this->breadcrumbs=array(
	'Plans',
);

$this->menu=array(
	array('label'=>'Create Plan','url'=>array('create')),
	array('label'=>'Manage Plan','url'=>array('admin')),
);
?>

<h1>Plans</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
