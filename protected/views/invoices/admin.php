<?php
$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Manage',
);

?>

<div class="main_title">Manage Invoices</div>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'invoices-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:40px'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
	'columns'=>array(
		'id'=>array(
			    'name' => 'id',
			    'filter'=>CHtml::activeTextField($model, 'id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("id"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center;')
	  	),
		'invoice_no',
		'cost',
		'bill_no',
		'bill_date',
		'request_id',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
