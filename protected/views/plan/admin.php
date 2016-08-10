<?php
$this->breadcrumbs=array(
	'Plans'=>array('index'),
	'Manage',
);
?>
<h4>กำหนดเป้าหมายประจำปี</h4>


<div style="padding-bottom: 20px"></div>
<div class="row-fluid">
 	<div class="span2">
		<?php 
		        echo CHtml::textField('year', '',array('class'=>'span12','placeholder'=>'ปี'));

               ?>
	</div>
	<div class="span3">
		<?php echo CHtml::textField('sample', '',array('class'=>'span12','placeholder'=>'จำนวนตัวอย่าง')); ?>
	</div>
	<div class="span3">
		<?php echo CHtml::textField('income', '',array('class'=>'span12','placeholder'=>'เก็บเงินค่าบริการ (ล้านบาท)')); ?>
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
                	'data' => array('year' => 'js:$("#year").val()','sample' => 'js:$("#sample").val()','income' => 'js:$("#income").val()'),
                	'success' => 'function(html){ $.fn.yiiGridView.update("plan-grid"); }'
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

			                       if($.fn.yiiGridView.getSelection("plan-grid").length==0)
			                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");
			                       else  
			                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
						                   function(confirmed){
						               
			                                if(confirmed)
						                   	 $.ajax({
													type: "POST",
													url: "deleteSelected",
													data: { selectedID: $.fn.yiiGridView.getSelection("plan-grid")}
													})
													.done(function( msg ) {
														$("#plan-grid").yiiGridView("update",{});
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
	'id'=>'plan-grid',
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
        'year'=>array(
			    'name' => 'year',
			    'class' => 'editable.EditableColumn',
			    'filter'=>CHtml::activeTextField($model, 'year',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("year"))),
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

										$("#plan-grid").yiiGridView("update",{});
									}',
					'options' => array(
						'ajaxOptions' => array('dataType' => 'json'),

					), 
					'placement' => 'right',
					'display' => 'js: function() {
				
					    
					}'
				)
	  	),
        'sample'=>array(
			    'name' => 'sample',
			    'class' => 'editable.EditableColumn',
			    'filter'=>CHtml::activeTextField($model, 'sample',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("sample"))),
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

										$("#plan-grid").yiiGridView("update",{});
									}',
					'options' => array(
						'ajaxOptions' => array('dataType' => 'json'),

					), 
					'placement' => 'right',
					'display' => 'js: function() {
				
					    
					}'
				)
	  	),
		'income'=>array(
			    'name' => 'income',
			    'class' => 'editable.EditableColumn',
			    'filter'=>CHtml::activeTextField($model, 'income',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("income"))),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:right;padding-right:10px;'),
				'editable' => array( //editable section
					//'apply' => '$data->user_status != 4', //can't edit deleted users
					//'text'=>'Click',
					//'tooltip'=>'Click',
					'title'=>'แก้ไข',
					'url' => $this->createUrl('update'),
					'success' => 'js: function(response, newValue) {
									if(!response.success) return response.msg;

										$("#plan-grid").yiiGridView("update",{});
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
