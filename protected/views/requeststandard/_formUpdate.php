<?php

// $baseUrl = Yii::app()->request->baseUrl; 
// $clientScriptUrl = "{$baseUrl}/javascripts/jquery.tagsinput.js"; 
// $clientScript = Yii::app()->clientScript;
// $clientScript->registerScriptFile($clientScriptUrl, CClientScript::POS_HEAD);
// $clientScript->registerCssFile($baseUrl.'/javascripts/jquery.tagsinput.css');

?>
<!-- 
<script type="text/javascript">
     
    function gentSamplingNo(index) {
    		if($( "#RequestStandard_"+index+"_sampling_num" ).val()!="" && $( "#material_id" ).val()!="")
		   	{	
				   	$.ajax({
				        url: './gentSamplingNo',
				        type: 'post',
				        data : {'sampling_num':$( "#RequestStandard_"+index+"_sampling_num" ).val(), 'material':$( "#material_id" ).val()},
				        success:function(response){

				        		$( "#RequestStandard_"+index+"_sampling_no" ).val(response)
				        }
				    });
			}	   	
    }

    function calCost(index){

    		$.ajax({
    			url: '../standard/getCost', 
				type:'POST', //request type
				data:{'labtype':$('#RequestStandard_'+index+'_labtype_id').val(),'sampling':$('#RequestStandard_'+index+'_sampling_num').val()},
				success:function(res){


					$("#RequestStandard_"+index+"_cost").val(res)
				}
			});
    }
	
	$(function(){
        //autocomplete search on focus    	
	  // $('#RequestStandard_1_lot_no,#RequestStandard_2_lot_no').tagsInput();
	     var index = $("#index").val();
	    $( "#RequestStandard_"+index+"_lot_no" ).focusout(function() {
	    	
		   
		   	str = $(this).val().split(",");
		   	lotnum = str.length ;
		   	if(str[str.length-1]=="")
               lotnum--;  

		   	$( "#RequestStandard_"+index+"_lot_num" ).val(lotnum);

		   


		});

		$( "#RequestStandard_"+index+"_sampling_num" ).focusout(function() {
	    	
	    	  gentSamplingNo(index);
	    	  calCost(index)
		});	

		$( "#material_id" ).change(function() {
	    	 gentSamplingNo(index);
	    	 calCost(index);

		});	

		$( "#RequestStandard_"+index+"_labtype_id" ).change(function() {

	    	 calCost(index);

		});	
  });


</script> -->

<input type="hidden" name="index" id="index" value=<?php echo $index;?> >

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

			        $modelLabtype = Labtype::model()->findByPk($model->labtype_id);
			        $selectMaterial = !empty($modelLabtype) ? $modelLabtype->material_id : '';

			        $typelist = CHtml::listData($data,'value','text');
			        echo CHtml::label('ชนิดวัสดุ','material_id');
			        echo CHtml::dropDownList('material_id_'.$index,$selectMaterial, $typelist,array('class'=>'span12','empty'=>"",
			        						'ajax' => array(
												'type'=>'POST', //request type
												'data'=>array('material'=>'js:this.value'),
												'url'=>CController::createUrl('./labtype/getLabtypeByMaterial'), 		
												'update'=>'#RequestStandard_'.$index.'_labtype_id', //selector to update
										
											)

											)); 
			        

			?>
		</div>
		<div class="span4">		
			<?php
					$data = array();
					//echo $selectMaterial;
					//$modelLabtypes = Labtype::model()->findAll(array("condition"=>"material_id=".$selectMaterial));
					
					$modelLabtypes = Yii::app()->db->createCommand()
			                        ->select('id,name')
			                        ->from('labtypes')
			                        ->where('material_id=:id', array(':id'=>$selectMaterial))
			                        ->order('id')
			                        ->queryAll();

					foreach ($modelLabtypes as $key => $value) {
			          $data[] = array(
			                          'value'=>$value['id'],
			                          'text'=>$value['name'],
			                       );
			        } 
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
              	$modelStandards = Yii::app()->db->createCommand()
			                        ->select('id,name')
			                        ->from('standards')
			                        ->where('material_id=:id', array(':id'=>$selectMaterial))
			                        ->order('id')
			                        ->queryAll();

				foreach ($modelStandards as $key => $value) {
			          $data[] = array(
			                          'value'=>$value['id'],
			                          'text'=>$value['name'],
			                       );
			    } 

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
			    <?php echo CHtml::activeTextField($model, '[' . $index . ']lot_num', array('size' => 20,'style'=>'text-align:right',  'maxlength' => 255,'class'=>'span12','readonly'=>true)); ?>
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
			    <?php echo CHtml::activeTextField($model, '[' . $index . ']cost', array('size' => 20, 'style'=>'text-align:right', 'maxlength' => 255,'class'=>'span12','readonly'=>true)); ?>
			    <?php echo CHtml::error($model, '[' . $index . ']cost',array('class'=>'help-block error')); ?>
            </div>  
            <div class="span3">	
				  <div style="padding-bottom:6px">&nbsp;</div>
				  <?php 

				  	// echo CHtml::ajaxButton(
					  //   $label = 'ทดสอบเพิ่ม', 
					  //   $url = CController::createUrl('./standard/getCost'), 
					  //   $ajaxOptions=array (
					  //     						'type'=>'POST', //request type
							// 					'data'=>array('labtype'=>'js:$("#RequestStandard_'.$index.'_labtype_id").val()','sampling'=>'js:$("#RequestStandard_'.$index.'_sampling_num").val()'),
							// 					'success'=>'function(res){

							// 							$("#RequestStandard_'.$index.'_cost").val(res)
							// 					}'
											
							// 					//'update'=>'#RequestStandard_'.$index.'_standard_id', //selector to update
					  //       ), 
					  //   $htmlOptions=array ('class'=>'btn btn-warning')
				   //  );

			    ?>
            </div>  
        	
</div>    


