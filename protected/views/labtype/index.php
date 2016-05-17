<?php
$this->breadcrumbs=array(
	'Labtypes',
);

$this->menu=array(
	array('label'=>'Create Labtype','url'=>array('create')),
	array('label'=>'Manage Labtype','url'=>array('admin')),
);
?>

<h1>Labtypes</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
