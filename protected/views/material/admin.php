<?php
$this->breadcrumbs=array(
	'Material'=>array('index')
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('prodtype-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="main_title">ชนิดวัสดุ</div>

<div style="padding-bottom: 20px"></div>
<div class="row-fluid">
 	<div class="span2">
		<?php 
		        echo CHtml::textField('code', '',array('class'=>'span12','placeholder'=>'กรอกรหัส'));

               ?>
	</div>
	<div class="span6">
		<?php echo CHtml::textField('newprodtype', '',array('class'=>'span12','placeholder'=>'กรอกชื่อชนิดวัสดุ')); ?>
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
                	'data' => array('name' => 'js:$("#newprodtype").val()','code' => 'js:$("#code").val()'),
                	'success' => 'function(html){ $("#newprodtype").val("");$("#code").val(""); $.fn.yiiGridView.update("prodtype-grid"); }'
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

			                       if($.fn.yiiGridView.getSelection("prodtype-grid").length==0)
			                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");
			                       else  
			                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
						                   function(confirmed){
						               
			                                if(confirmed)
						                   	 $.ajax({
													type: "POST",
													url: "deleteSelected",
													data: { selectedID: $.fn.yiiGridView.getSelection("prodtype-grid")}
													})
													.done(function( msg ) {
														$("#prodtype-grid").yiiGridView("update",{});
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
	'id'=>'prodtype-grid',
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
        'code'=>array(
			    'name' => 'code',
			    'class' => 'editable.EditableColumn',
			    'filter'=>CHtml::activeTextField($model, 'code',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("code"))),
				'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center'),
				'editable' => array( //editable section
					//'apply' => '$data->user_status != 4', //can't edit deleted users
					//'text'=>'Click',
					//'tooltip'=>'Click',
					'title'=>'แก้ไข',
					'url' => $this->createUrl('update'),
					'success' => 'js: function(response, newValue) {
									if(!response.success) return response.msg;

										$("#prodtype-grid").yiiGridView("update",{});
									}',
					'options' => array(
						'ajaxOptions' => array('dataType' => 'json'),

					), 
					'placement' => 'right',
					'display' => 'js: function() {
				
					    
					}'
				)
	  	),
		'name'=>array(
			    'name' => 'name',
			    'class' => 'editable.EditableColumn',
			    'filter'=>CHtml::activeTextField($model, 'name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("name"))),
				'headerHtmlOptions' => array('style' => 'width:60%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;'),
				'editable' => array( //editable section
					//'apply' => '$data->user_status != 4', //can't edit deleted users
					//'text'=>'Click',
					//'tooltip'=>'Click',
					'title'=>'แก้ไข',
					'url' => $this->createUrl('update'),
					'success' => 'js: function(response, newValue) {
									if(!response.success) return response.msg;

										$("#prodtype-grid").yiiGridView("update",{});
									}',
					'options' => array(
						'ajaxOptions' => array('dataType' => 'json'),

					), 
					'placement' => 'right',
					'display' => 'js: function() {
				
					    
					}'
				)
	  	),
	
	),
));




?>
