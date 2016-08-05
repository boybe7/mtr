<?php
$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	'Manage',
);

?>

<div class="main_title"><?php echo $type;?></div>



<?php 
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่มข้อมูล',
    'icon'=>'plus-sign',
    'url'=>array($url),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 0px 0px 10px;'),

)); 



$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'danger',
    'label'=>'ลบข้อมูล',
    'icon'=>'minus-sign',
    'htmlOptions'=>array(
        'onclick'=>'      
                      
                       if($.fn.yiiGridView.getSelection("vendor-grid").length==0)
                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");
                       else  
                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
			                   function(confirmed){

                                if(confirmed)
			                   	 $.ajax({
										type: "POST",
										url: "deleteSelected",
										data: { selectedID: $.fn.yiiGridView.getSelection("vendor-grid")}
										})
										.done(function( msg ) {
											$("#vendor-grid").yiiGridView("update",{});
										});
			                  })',
        'class'=>'pull-right'
    ),
)); 

echo "<br>";
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'vendor-grid',
	'dataProvider'=>$provider,
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:20px'),
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
        'name'=>array(
			    'name' => 'name',
			     'class' => 'editable.EditableColumn',
			    'filter'=>CHtml::activeTextField($model, 'name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("name"))),
				'headerHtmlOptions' => array('style' => 'width:45%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;'),
				'editable' => array( //editable section
			
					'title'=>'แก้ไข',
					'url' => $this->createUrl('update'),
					'success' => 'js: function(response, newValue) {
									if(!response.success) return response.msg;

										$("#vendor-grid").yiiGridView("update",{});
									}',
					'options' => array(
						'ajaxOptions' => array('dataType' => 'json'),

					), 
					'placement' => 'right',
					'display' => 'js: function() {
				
					    
					}'
				)
	
	  	),
		'address'=>array(
			    'name' => 'address',
			     'class' => 'editable.EditableColumn',
			    'filter'=>CHtml::activeTextField($model, 'address',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("address"))),
				'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;'),
				'editable' => array( //editable section
			
					'title'=>'แก้ไข',
					'url' => $this->createUrl('update'),
					'success' => 'js: function(response, newValue) {
									if(!response.success) return response.msg;

										$("#vendor-grid").yiiGridView("update",{});
									}',
					'options' => array(
						'ajaxOptions' => array('dataType' => 'json'),

					), 
					'placement' => 'right',
					'display' => 'js: function() {
				
					    
					}'
				)
	
	  	),
	  	array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;'),
			'template' => '{delete}',
			
            )    
	
	),
));

 ?>
