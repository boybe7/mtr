<?php
$this->breadcrumbs=array(
	'Standards',
);

$this->menu=array(
	array('label'=>'Create Standard','url'=>array('create')),
	array('label'=>'Manage Standard','url'=>array('admin')),
);
?>

<h1>Standards</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
