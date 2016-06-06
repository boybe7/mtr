<?php

$baseUrl = Yii::app()->request->baseUrl; 
$clientScriptUrl = "{$baseUrl}/javascripts/jquery.tagsinput.js"; 
$clientScript = Yii::app()->clientScript;
$clientScript->registerScriptFile($clientScriptUrl, CClientScript::POS_HEAD);
$clientScript->registerCssFile($baseUrl.'/javascripts/jquery.tagsinput.css');

?>

<script type="text/javascript">
	
	$(function(){
        //autocomplete search on focus    	
	  // $('#RequestStandard_1_lot_no,#RequestStandard_2_lot_no').tagsInput();
	    $( "#RequestStandard_1_lot_no" ).focusout(function() {
	    	console.log("xxx")
		   	$.ajax({
		        url: '/getNumberOfLot',
		        success:function(response){

		        }
		    });
		});
  });


</script>

<div class="row-fluid">
		<div class="span3">		
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
			        echo CHtml::label('ชนิดวัสดุ','material_id');
			        echo CHtml::dropDownList('material_id','', $typelist,array('class'=>'span12','empty'=>"",
			        						'ajax' => array(
												'type'=>'POST', //request type
												'data'=>array('material'=>'js:this.value'),
												'url'=>CController::createUrl('./labtype/getLabtypeByMaterial'), 		
												'update'=>'#RequestStandard_'.$index.'_labtype_id', //selector to update
										
											))); 
			        

			?>
		</div>
		<div class="span4">		
			<?php
					$data = array();
			        $typelist = CHtml::listData($data,'value','text');
			        //echo CHtml::label('วิธีการทดสอบ','labtype');
			        echo CHtml::activeLabelEx($model, '[' . $index . ']labtype_id'); 
			        echo CHtml::activeDropDownList($model, '[' . $index . ']labtype_id',$typelist, array('class'=>'span12','empty'=>'',
			        						'ajax' => array(
												'type'=>'POST', //request type
												'data'=>array('labtype'=>'js:this.value'),
												'url'=>CController::createUrl('./standard/getStandardByLabtype'), 
												'update'=>'#RequestStandard_'.$index.'_standard_id', //selector to update
										
											))); 
			        echo CHtml::error($model, '[' . $index . ']labtype_id',array('class'=>'help-block error')); 
			 ?>
		</div>
		<div class="span5">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']standard_id'); ?>
              <?php 
              	$data = array();
			    $typelist = CHtml::listData($data,'value','text');
              	 echo CHtml::activeDropDownList($model, '[' . $index . ']standard_id',$typelist, array('class'=>'span12','empty'=>''));
              ?>
              <?php echo CHtml::error($model, '[' . $index . ']standard_id',array('class'=>'help-block error')); ?>
        </div>  
</div>				

<div class="row-fluid">
        	<div class="span12">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']material_detail'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']material_detail', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']material_detail',array('class'=>'help-block error')); ?>
            </div>  
</div> 
 

<div class="row-fluid">
        	<div class="span12">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']lot_no'); ?>
              <?php echo CHtml::activeTextArea($model, '[' . $index . ']lot_no', array('rows'=>2, 'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']lot_no',array('class'=>'help-block error')); ?>
            </div>  
            
</div>   

<div class="row-fluid">
			<div class="span3">	
			    <?php echo CHtml::activeLabelEx($model, '[' . $index . ']lot_num'); ?>
			    <?php echo CHtml::activeTextField($model, '[' . $index . ']lot_num', array('size' => 20,'style'=>'text-align:right',  'maxlength' => 255,'class'=>'span12','disabled'=>true)); ?>
			    <?php echo CHtml::error($model, '[' . $index . ']lot_num',array('class'=>'help-block error')); ?>
            </div>  
        	<div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']sampling_num'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']sampling_num', array( 'style'=>'text-align:right', 'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']sampling_num',array('class'=>'help-block error')); ?>
            </div>  
            <div class="span6">	
			   <?php echo CHtml::activeLabelEx($model, '[' . $index . ']sampling_no'); ?>
			   <?php echo CHtml::activeTextField($model, '[' . $index . ']sampling_no', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
			   <?php echo CHtml::error($model, '[' . $index . ']sampling_no',array('class'=>'help-block error')); ?>
            </div>  
</div>     

<div class="row-fluid">
			<div class="span3">	
			    <?php echo CHtml::activeLabelEx($model, '[' . $index . ']cost'); ?>
			    <?php echo CHtml::activeTextField($model, '[' . $index . ']cost', array('size' => 20, 'style'=>'text-align:right', 'maxlength' => 255,'class'=>'span12','disabled'=>true)); ?>
			    <?php echo CHtml::error($model, '[' . $index . ']cost',array('class'=>'help-block error')); ?>
            </div>  
            <div class="span3">	
				  <div style="padding-bottom:6px">&nbsp;</div>
				  <?php 

				  	echo CHtml::ajaxButton(
					    $label = 'คำนวณค่าธรรมเนียมทดสอบ', 
					    $url = CController::createUrl('./standard/getCost'), 
					    $ajaxOptions=array (
					      						'type'=>'POST', //request type
												'data'=>array('labtype'=>'js:$("#RequestStandard_'.$index.'_labtype_id").val()','sampling'=>'js:$("#RequestStandard_'.$index.'_sampling_num").val()'),
												'success'=>'function(res){

														$("#RequestStandard_'.$index.'_cost").val(res)
												}'
											
												//'update'=>'#RequestStandard_'.$index.'_standard_id', //selector to update
					        ), 
					    $htmlOptions=array ('class'=>'btn btn-warning')
				    );

			    ?>
            </div>  
        	
</div>      
