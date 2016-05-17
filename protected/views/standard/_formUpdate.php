<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'standard-form',
	'htmlOptions' => array('class' => 'well'),
	'enableAjaxValidation'=>false,
)); 
  	
  	echo "<h4>".$title."</h4>";
  	echo "<hr>";	
?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php

	 	//echo $form->textFieldRow($model,'material_id',array('class'=>'span5')); 

	  	$materialModels = Yii::app()->db->createCommand()
                        ->select('id,name')
                        ->from('materials')
                        ->order('id')
                        ->queryAll();


       //$models=Position::model()->findAll();
        $data = array();
        foreach ($materialModels as $key => $value) {
          $data[] = array(
                          'value'=>$value['id'],
                          'text'=>$value['name'],
                       );
        } 
        $typelist = CHtml::listData($data,'value','text');
        echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span5','empty'=>"")); 

	 ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span8','maxlength'=>200)); ?>

	<?php echo $form->textAreaRow($model,'description',array('class'=>'span8','maxlength'=>400)); ?>


<div id="errorHeader" name="errorHeader" class=""></div>
<div class="row-fluid">
 	<div class="span5">
		<?php 
		$labtypeModels = Yii::app()->db->createCommand()
                        ->select('id,name')
                        ->from('labtypes')
                        ->where('material_id='.$model->)
                        ->order('id')
                        ->queryAll();
		$data = array();
        foreach ($materialModels as $key => $value) {
          $data[] = array(
                          'value'=>$value['id'],
                          'text'=>$value['name'],
                       );
        } 
        $typelist = CHtml::listData($data,'value','text');

		echo CHtml::dropDownList('labtype','', array('empty'=>'กรุณาเลือกวิธีการทดสอบ'));

		echo CHtml::textField('name', '',array('class'=>'span12','placeholder'=>'ชื่อ'));        ?>
	</div>
	<div class="span2">
		<?php echo CHtml::textField('column', '',array('class'=>'span12','placeholder'=>'คอลัมภ์')); ?>
	</div>
	<div class="span3">
		<?php echo CHtml::textField('formula', '',array('class'=>'span12','placeholder'=>'สูตรคำนวณ')); ?>
	</div>
	
	<div class="span2">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'ajaxLink',
		    
		    'type'=>'success',
		    'label'=>'เพิ่มข้อมูล',
		    'icon'=>'plus-sign',
		    'url'=>array('createHeader'),
		    'htmlOptions'=>array('class'=>'span12','style'=>''),
		    'ajaxOptions'=>array(
		    	    
		     	    'type' => 'POST',
                	'data' => array('name' => 'js:$("#name").val()','column' => 'js:$("#column").val()','formula' => 'js:$("#formula").val()'),
                	'success' => 'function(msg){  
                		
                		
                		error = "";
                		var obj = $.parseJSON(msg);
                		jQuery.each(obj, function(i, val) {
						   error += val+"<br>";
						});

						if(error!="")
                             $("#errorHeader").addClass( "alert alert-block alert-error" );
						else	
							 $("#errorHeader").removeClass( "alert alert-block alert-error" );
						                		 
                		$("#errorHeader").html(error); 
                		
                		$("#formula").val("");
                		$("#name").val("");
                		$("#column").val(""); 
                		$.fn.yiiGridView.update("labtype-input-header-grid"); 
                	}',
                	'error'=>'function(html){  console.log("fail");  }'
                ) 
		)); 




		?>
	</div>	
	
</div>

<?php

		$this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'labtype-input-header-grid',
			'type'=>'bordered condensed',
			'selectableRows' =>2,
			'htmlOptions'=>array('style'=>'padding-top:5px'),
		    'enablePagination' => true,
		    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
		    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
			'dataProvider'=>StandardParameter::model()->searchByStandard('header'),
			
			'columns'=>array(
				
				'name'=>array(
					    'name' => 'labtype_input_id',					   
						'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:left'),
						
	  			),
				'value'=>array(
					    'name' => 'value',					   
						'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
					
	  			),
			
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template' => '{delete}',
				),
			),
		)); 

	 ?>

	

	<div class="form-actions">
		<div class="pull-right">
		<?php

		 $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'บันทึก',
		)); 
		 echo "<span>  </span>";
		 $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'link',
					'type'=>'danger',
					'url'=>array("index"),
					'label'=>'ยกเลิก',
				)); 


		?>
		</div>
	</div>

<?php $this->endWidget(); ?>
