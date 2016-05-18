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
        echo $form->dropDownListRow($model, 'material_id', $typelist,array('class'=>'span5','empty'=>"",
        						'ajax' => array(
									'type'=>'POST', //request type
									'data'=>array('material'=>'js:this.value'),
									'url'=>CController::createUrl('./labtype/getLabtypeByMaterial'), 		
									'update'=>'#labtype', //selector to update
							
								)

        	)); 

	 ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span8','maxlength'=>200)); ?>

	<?php echo $form->textAreaRow($model,'description',array('class'=>'span8','maxlength'=>400)); ?>


<div id="errorHeader" name="errorHeader" class=""></div>

<div class="row-fluid">
 	<div class="span4">
		<?php 
		$labtypeModels = Yii::app()->db->createCommand()
                        ->select('id,name')
                        ->from('labtypes')
                        ->where('material_id='.$model->material_id)
                        ->order('id')
                        ->queryAll();
		$data = array();

        foreach ($labtypeModels as $key => $value) {
          		$data[] = array(
                          'value'=>$value['id'],
                          'text'=>$value['name'],
                       );
        } 

        $typelist = CHtml::listData($data,'value','text');

		echo CHtml::dropDownList('labtype','',$typelist, array('class'=>'span12','empty'=>'เลือกวิธีการทดสอบ',
								'ajax' => array(
									'type'=>'POST', //request type
									'data'=>array('labtype'=>'js:this.value'),
									'url'=>CController::createUrl('./labtype/getLabtypeInput'), 		
									'update'=>'#parameter', //selector to update
							
								)

			));

		   ?>
	</div>
	<div class="span4">
		<?php 
		
		echo CHtml::dropDownList('parameter','', array('empty'=>'เลือกพารามิเตอร์'),array('class'=>'span12','onchange' => ''));

		 ?>
	</div>
	<div class="span2">
		<?php echo CHtml::textField('value', '',array('class'=>'span12','placeholder'=>'ค่า')); ?>
	</div>
	
	<div class="span2">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'ajaxLink',
		    
		    'type'=>'success',
		    'label'=>'เพิ่มข้อมูล',
		    'icon'=>'plus-sign',
		    'url'=>array('createParameter'),
		    'htmlOptions'=>array('class'=>'span12','style'=>''),
		    'ajaxOptions'=>array(
		    	    
		     	    'type' => 'POST',
                	'data' => array('standard' => $model->id,'parameter' => 'js:$("#parameter").val()','value' => 'js:$("#value").val()'),
                	'success' => 'function(msg){  
                		
                		console.log(msg)

						if(msg!="")
                             $("#errorHeader").addClass( "alert alert-block alert-error" );
						else	
							 $("#errorHeader").removeClass( "alert alert-block alert-error" );
						                		 
                		$("#errorHeader").html(msg); 
                		
                		$("#value").val("");
                		
                		$.fn.yiiGridView.update("parameter-grid"); 
                	}',
                	'error'=>'function(html){  console.log("fail");  }'
                ) 
		)); 




		?>
	</div>	
	
</div>

<?php

		$this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'parameter-grid',
			'type'=>'bordered condensed',
			'selectableRows' =>2,
			'htmlOptions'=>array('style'=>'padding-top:5px'),
		    'enablePagination' => true,
		    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
		    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
			'dataProvider'=>StandardParameter::model()->searchByStandard($model->id),
			
			'columns'=>array(
				
				'name'=>array(
					    'name' => 'labtype_input_id',	
					    'value'=>'LabtypeInput::Model()->FindByPk($data->labtype_input_id)->name',						   
						'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:left'),
						
	  			),
				'value'=>array(
					    'name' => 'value',					   
						'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
					
	  			),
	  			'labtype'=>array(
					    'name' => 'labtype_input_id',	
					    'header'=>'วิธีการทดสอบ',	
					    'value'=>'Labtype::Model()->FindByPk(LabtypeInput::Model()->FindByPk($data->labtype_input_id)->labtype_id)->name',			   
						'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center'),
					
	  			),
			
				array(
					'class'=>'bootstrap.widgets.TbButtonColumn',
					'template' => '{delete}'
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
