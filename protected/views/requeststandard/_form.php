<div class="row-fluid">
		<div class="span4">		
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
												'update'=>'#RequestStandard_['.$index.']labtype_id', //selector to update
										
											))); 
			        

			?>
		</div>
		<div class="span4">		
			<?php
					$data = array();
			        $typelist = CHtml::listData($data,'value','text');
			        //echo CHtml::label('วิธีการทดสอบ','labtype');
			        echo CHtml::activeLabelEx($model, '[' . $index . ']labtype_id'); 
			        echo CHtml::activeDropDownList($model, '[' . $index . ']labtype_id',$typelist, array('class'=>'span12','empty'=>''));
			 ?>
		</div>
</div>				

<div class="row-fluid">
        	<div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']material_detail'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']material_detail', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']material_detail',array('class'=>'help-block error')); ?>
            </div>  
</div>            
