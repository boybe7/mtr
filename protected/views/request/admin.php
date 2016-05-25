<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	'Manage',
);

?>

<div class="main_title">รับตัวอย่างทดสอบ</div>


<?php
// $this->widget('bootstrap.widgets.TbButton', array(
//     'buttonType'=>'link',
    
//     'type'=>'primary',
//     'label'=>'template',
//     'icon'=>'plus-sign',
//     //'url'=>array('template'),
//     'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;',
//     		'onclick'=>'
//     			console.log($.fn.yiiGridView.getSelection("labtype-grid"))

//     		'
//     	),
// )); 

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มข้อมูล',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 0px 0px 10px;'),

)); 

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'danger',
    'label'=>'ลบข้อมูล',
    'icon'=>'minus-sign',
    //'url'=>array('delAll'),
    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
    'htmlOptions'=>array(
        //'data-toggle'=>'modal',
        //'data-target'=>'#myModal',
        'onclick'=>'      
                       //console.log($.fn.yiiGridView.getSelection("labtype-grid").length);
                       if($.fn.yiiGridView.getSelection("labtype-grid").length==0)
                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");
                       else  
                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
			                   function(confirmed){
			                   	 	
			                   	 //console.log("Confirmed: "+confirmed);
			                   	 //console.log($.fn.yiiGridView.getSelection("user-grid"));
                                if(confirmed)
			                   	 $.ajax({
										type: "POST",
										url: "deleteSelected",
										data: { selectedID: $.fn.yiiGridView.getSelection("labtype-grid")}
										})
										.done(function( msg ) {
											$("#labtype-grid").yiiGridView("update",{});
										});
			                  })',
        'class'=>'pull-right'
    ),
)); 



 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'labtype-grid',
	'dataProvider'=>$model->search(),
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
	  	'lot'=>array(
			    'header' => 'Lot no.',
			     'type'=>'raw',
			    'value'=>array($this,'getLot'), 
			    'filter'=>CHtml::activeTextField($model, 'owner_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("owner_id"))),
				'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		'date'=>array(
			    'name' => 'date',
			    //'value'=>'date("dd/mm/yyyy", $data->date)',
			    'filter'=>CHtml::activeTextField($model, 'date',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("date"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center;')
	  	),
	  	'job_id'=>array(
			    'name' => 'job_id',
			    'value'=>'Job::Model()->FindByPk($data->job_id)->name',
			    'filter'=>CHtml::activeTextField($model, 'job_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("job_id"))),
				'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		
		
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),
			'template' => '{update}{template}',
			'buttons'=>array
            (
                'template' => array
                (
                    'label'=>'template',
                    'icon'=>'plus',
                    'url'=>'Yii::app()->createUrl("labtype/template", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'',
                    ),
                ),
            )    
		),
	),
)); ?>