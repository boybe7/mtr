<?php
$this->breadcrumbs=array(
	'Report'
);

?>

<div class="main_title">รายงานผลการทดสอบวัสดุ</div>


<?php



 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'labtype-grid',
	'dataProvider'=>$model->searchGuest(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:40px'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
	'columns'=>array(
		'checkbox'=> array(
        	    'id'=>'selectedID',
            	'class'=>'CCheckBoxColumn',
            	//'selectableRows' => 2, 
        		 'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;'),
	  	         'htmlOptions'=>array(
	  	            	  			'style'=>'text-align:center'

	  	            	  		)   	  		
        ),
        'request_no'=>array(
			    'name' => 'request_no',
			    'type'=>"raw",
			    'value'=>array($this,'getReqNoGuest'), 
			    'filter'=>CHtml::activeTextField($model, 'request_no',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("request_no"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center;')
	  	),
		'owner_id'=>array(
			    'name' => 'owner_id',
			    'value'=>'Vendor::Model()->FindByPk($data->owner_id)->name',
			    'filter'=>CHtml::activeTextField($model, 'owner_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("owner_id"))),
				'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		'material'=>array(
			    'name'=>'material',
			    'type'=>'raw',
			    //'header' => 'ชนิดวัสดุ',
			    'value'=>array($this,'getMaterial'), 
			    'filter'=>CHtml::activeTextField($model, 'material',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("material"))),
				'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
	  	'contract'=>array(
			    //'header' => 'หมายเลขตัวอย่าง',
	  		    'name'=>'contract_id',
			    'type'=>'raw',
			    'value'=>array($this,'getContract'), 
			    //'value'=>'Contract::Model()->FindByPk($data->contract_id)->name',
			    'filter'=>CHtml::activeTextField($model, 'contract_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract_id"))),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		'date'=>array(
			    'name' => 'date',
			    //'value'=>'date("dd/mm/yyyy", $data->date)',
			    'filter'=>CHtml::activeTextField($model, 'date',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("date"))),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center;')
	  	),
	  	'job_id'=>array(
			    'name' => 'job_id',
			    'value'=>'Job::Model()->FindByPk($data->job_id)->name',
			    'filter' => CHtml::listData(Job::model()->findAll(), 'id', 'name'),
			    //'filter'=>CHtml::activeTextField($model, 'job_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("job_id"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	)

	),
)); 


echo "หมายเหตุ :  <img src='".Yii::app()->baseUrl."/images/red_star.png' width='10px'>  มีการทดสอบเพิ่ม";
?>
<div id="modal-content" class="modal hide">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  
    <div id="modal-body2" class='modal-body'>
         <div>หมายเหตุ :</div> 
         <form id="note-form" accept-charset="UTF-8">
         	
         <textarea class='span5' rows=4 cols=4 name='comment' id='comment'></textarea>
        </form>
    </div>
  
</div>