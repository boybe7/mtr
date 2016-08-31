<?php
$this->breadcrumbs=array(
	'Jobs'=>array('index')
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('job-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<div class="main_title">ประเภทงาน</div>

<div style="padding-bottom: 20px"></div>
<div class="row-fluid">
 	<div class="span6">
		<?php 
		        echo CHtml::textField('newjob', '',array('class'=>'span12','placeholder'=>'กรอกประเภทงานใหม่'));

               ?>
	</div>
	<div class="span2">
		<?php 
			echo CHtml::radioButtonList('job_group','',array('งานภายใน กปน.'=>'งานภายใน กปน.','งานบริการ'=>'งานบริการ'),array('labelOptions'=>array('style'=>'display:inline'))); 

    	?>
	</div>
	
	<div class="span2">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'ajaxLink',
		    
		    'type'=>'success',
		    'label'=>'เพิ่มข้อมูล',
		    'icon'=>'plus-sign',
		    'url'=>array('create'),
		    'htmlOptions'=>array('class'=>'span12','style'=>''),
		    'ajaxOptions'=>array(
		    	    //'url'=>$this->createUrl('create'),
		     	    'type' => 'POST',
                	'data' => array('name' => 'js:$("#newjob").val()','job_group' => 'js:$("#job_group :checked").val()'),
                	'success' => 'function(html){ console.log("success"); $("#newjob").val("");$("#job_group").val(""); $("#job-grid").yiiGridView("update",{}); }'
                ) 
		)); 




		?>
	</div>	
	<div class="span2">	
		<?php
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

			                       if($.fn.yiiGridView.getSelection("job-grid").length==0)
			                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ","ตกลง");
			                       else  
			                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
						                   function(confirmed){
						               
			                                if(confirmed)
						                   	 $.ajax({
													type: "POST",
													url: "deleteSelected",
													data: { selectedID: $.fn.yiiGridView.getSelection("job-grid")}
													})
													.done(function( msg ) {
														$("#job-grid").yiiGridView("update",{});
													});
						                  })',
			        'class'=>'span12'
			    ),
			)); 
		?>
	</div>	
</div>

<?php 

$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'job-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:10px'),
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
				'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left'),
				'editable' => array( //editable section
					//'apply' => '$data->user_status != 4', //can't edit deleted users
					//'text'=>'Click',
					//'tooltip'=>'Click',
					'title'=>'แก้ไข',
					'url' => $this->createUrl('update'),
					'success' => 'js: function(response, newValue) {
									if(!response.success) return response.msg;

										$("#job-grid").yiiGridView("update",{});
									}',
					'options' => array(
						'ajaxOptions' => array('dataType' => 'json'),

					), 
					'placement' => 'right',
					'display' => 'js: function() {
						$(this).attr( "rel", "tooltip");
						$(this).attr( "data-original-title", "แก้ไข");
					    
					}'
				)
	  	),
		'job_group'=>array(
				'name' => 'job_group',
			    'class' => 'editable.EditableColumn',
			    'filter'=>CHtml::activeTextField($model, 'job_group',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("job_group"))),
				'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left'),
				'editable' => array(
					'type' => 'select',
					'title'=>'แก้ไขกลุ่มประเภทงาน',
					'url' => $this->createUrl('update'),
					'source' => $this->createUrl('list'),
					'options' => array('ajaxOptions' => array('dataType' => 'json'),
					'display' => 'js: function(value, sourceData) {

						var selected = $.grep(sourceData, function(o){ return o.value == value; });

						colors = {1: "green", 2: "blue", 3: "purple", 4: "gray"};
						$(this).text(selected[0].text).css("color", colors[value]);            
						$(this).attr( "rel", "tooltip");
						$(this).attr( "data-original-title", "แก้ไข");
					}'
					),
					//onsave event handler
					'onSave' => 'js: function(e, params) {
						//console && console.log("saved value: "+params.newValue);
					}',
					
				)
	  	),
	),
));




?>

