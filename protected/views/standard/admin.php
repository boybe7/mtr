<?php
$this->breadcrumbs=array(
	'Standards'=>array('index'),
	'Manage',
);

?>

<div class="main_title">มาตรฐาน</div>


<?php

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
                       if($.fn.yiiGridView.getSelection("standard-grid").length==0)
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
										data: { selectedID: $.fn.yiiGridView.getSelection("standard-grid")}
										})
										.done(function( msg ) {
											$("#standard-grid").yiiGridView("update",{});
										});
			                  })',
        'class'=>'pull-right'
    ),
)); 



 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'standard-grid',
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
        'material_id'=>array(
			    'name' => 'material_id',
			    //'value' => array($model,'getName'),
			    'value'=>'Material::Model()->FindByPk($data->material_id)->name',
			    'filter'=>CHtml::listData(Material::model()->findAll(), 'id', 'name'),
				'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center;')
	  	),
		'name'=>array(
			    'name' => 'name',
			    'filter'=>CHtml::activeTextField($model, 'name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("name"))),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		
		'description'=>array(
			    'name' => 'description',
			    'filter'=>CHtml::activeTextField($model, 'description',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("description"))),
				'headerHtmlOptions' => array('style' => 'width:35%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),
			'template' => '{update}',
			
		),
	),
)); ?>


