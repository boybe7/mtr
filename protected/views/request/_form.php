<script type="text/javascript">
	
	$(function(){
        //autocomplete search on focus    	
	    $("#contract_id").autocomplete({
       
                minLength: 0
            }).bind('focus', function () {
                $(this).autocomplete("search");
      });

  });


</script>



<script type="text/javascript">
     
    function gentSamplingNo(index) {

    		if($( "#RequestStandard_"+index+"_sampling_num" ).val()!="" && $( "#material_id" ).val()!="")
		   	{	
				   	$.ajax({
				        url: './gentSamplingNo',
				        type: 'post',
				        data : {'sampling_num':$( "#RequestStandard_"+index+"_sampling_num" ).val(),
				                'material':$( "#material_id_"+index ).val(),
				                'index':index,
				                'labtype': $( "#RequestStandard_"+index+"_labtype_id" ).val(),

				            },
				        success:function(response){


							$.each(JSON.parse(response), function(idx, obj) {
								//console.log(obj.index+":"+obj.value)
								$( "#RequestStandard_"+obj.index+"_sampling_no" ).val(obj.value)
							});

				        		
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

    function getNumLot(index)
    {

		   	val = $("#RequestStandard_"+index+"_lot_no").val();
		   	str = val.split(",");
		    lotnum = str.length ;
            //console.log(str.length) 
		   	if(str.length!=0 && str[str.length-1]=="")
               lotnum--;  
            if(str.length==0 && val!="")
            	lotnum = 1;

		   	$("#RequestStandard_"+index+"_lot_num").val(lotnum);
		
    }
	
	$(function(){
        //autocomplete search on focus    	
	  // $('#RequestStandard_1_lot_no,#RequestStandard_2_lot_no').tagsInput();
	   
	   
	    $( "#RequestStandard_1_lot_no" ).focusout(function() {
	    	 getNumLot(1);
		
		});

		$( "#RequestStandard_1_sampling_num" ).focusout(function() {
	    	
	    	  gentSamplingNo(1);
	    	  calCost(1)
		});	

	
		$( "#material_id_1" ).change(function() {
	    	 $( "#RequestStandard_1_labtype_id" ).val("");
	    	 $( "#RequestStandard_1_standard_id" ).empty();
	    	 gentSamplingNo(1);
	    	 calCost(1);

		});	

		$( "#RequestStandard_1_labtype_id" ).change(function() {
             gentSamplingNo(1);
	    	 calCost(1);

		});	




		$( "#RequestStandard_2_lot_no" ).focusout(function() {
	    	
		   
		   	 getNumLot(2);
		
		});

		$( "#RequestStandard_2_sampling_num" ).focusout(function() {

	    	  gentSamplingNo(2);
	    	  calCost(2)
		});	

		$( "#material_id_2" ).change(function() {
	    	 
	    	 $( "#RequestStandard_2_labtype_id" ).val("");
	    	 $( "#RequestStandard_2_standard_id" ).empty();
	    	 gentSamplingNo(2);
	    	 calCost(2);


		});	

		$( "#RequestStandard_2_labtype_id" ).change(function() {
             gentSamplingNo(2);  
	    	 calCost(2);

		});	


		$( "#RequestStandard_3_lot_no" ).focusout(function() {
	    	
		   
		   	 getNumLot(3);
		
		});

		$( "#RequestStandard_3_sampling_num" ).focusout(function() {
	    	
	    	  gentSamplingNo(3);
	    	  calCost(3)
		});	

		$( "#material_id_3" ).change(function() {
	    	 $( "#RequestStandard_3_labtype_id" ).val("");
	    	 $( "#RequestStandard_3_standard_id" ).empty();
	    	 gentSamplingNo(3);
	    	 calCost(3);

		});	

		$( "#RequestStandard_3_labtype_id" ).change(function() {
             gentSamplingNo(3);
	    	 calCost(3);

		});	
  });


</script>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'request-form',
	'htmlOptions' => array('class' => 'well'),
	'enableAjaxValidation'=>false,
)); 

	echo "<h4>".$title."</h4>";
  	echo "<hr>";	
?>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
		<div class="span3">

				<?php echo $form->textFieldRow($model,'request_no',array('class'=>'span12','maxlength'=>15)); ?>
		</div>
		<div class="span4">
		       <?php 
		         		echo $form->labelEx($model,'date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));
		         		echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'date',
		                        'attribute'=>'date',
		                        'model'=>$model,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$model->date, 'disabled' =>true),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		       			//echo $form->textFieldRow($model,'date',array('class'=>'span12')); 
		       ?>

		</div>
		<div class="span4">
		       <?php

		        $data = array();
		        foreach (Job::model()->findAll() as $key => $value) {
		          $data[] = array(
		                          'value'=>$value['id'],
		                          'text'=>$value['name'],
		                       );
		        } 
		        $typelist = CHtml::listData($data,'value','text');
		        echo $form->dropDownListRow($model, 'job_id', $typelist,array('class'=>'span12','empty'=>"")); 

		        //echo $form->textFieldRow($model,'job_id',array('class'=>'span12')); ?>

		</div>
	</div>			



	<?php 
		$vendorModels = Yii::app()->db->createCommand()
                        ->select('id,name')
                        ->from('vendors')
                        ->where('type=1')
                        ->order('id')
                        ->queryAll();


       //$models=Position::model()->findAll();
        $data = array();
        foreach ($vendorModels as $key => $value) {
          $data[] = array(
                          'value'=>$value['id'],
                          'text'=>$value['name'],
                       );
        } 
        $typelist = CHtml::listData($data,'value','text');
        echo $form->dropDownListRow($model, 'owner_id', $typelist,array('class'=>'span8','empty'=>"")); 

	

	?>


	<?php 

	  	$vendorModels = Yii::app()->db->createCommand()
                        ->select('id,name')
                        ->from('vendors')
                        ->where('type=2')
                        ->order('id')
                        ->queryAll();


       //$models=Position::model()->findAll();
        $data = array();
        foreach ($vendorModels as $key => $value) {
          $data[] = array(
                          'value'=>$value['id'],
                          'text'=>$value['name'],
                       );
        } 
        $typelist = CHtml::listData($data,'value','text');
        echo $form->dropDownListRow($model, 'vendor_id', $typelist,array('class'=>'span8','empty'=>"")); 

	?>	

	
	<?php echo $form->textAreaRow($model,'detail',array('class'=>'span8','maxlength'=>500)); ?>
	

	<?php 
						echo $form->hiddenField($model,'contract_id');
                        echo $form->labelEx($model,'contract_id',array('class'=>'span12','style'=>'text-align:left;margin-left:-1px;'));
                        //$m = Prodtype::model()->findByPK($model->prod_id);
                        //$m = Prodtype::model()->findAll(array('order'=>'', 'condition'=>'prot_name=:name', 'params'=>array('name'=>$model->prod_id)));
                        //print_r($m);
                        //$value = empty($model->prod_id) ? "" : $m->prot_code."-".$m->prot_name;  
                        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'contract_id',
                            'id'=>'contract_id',
                            'value'=>$model->contract_id,
                           // 'source'=>$this->createUrl('Ajax/GetDrug'),
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('Contract/GetContract').'",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                       
                                    },
                                    success: function (data) {
                                            response(data);

                                    }
                                })
                             }',
                            // additional javascript options for the autocomplete plugin
                            'options'=>array(
                                     'showAnim'=>'fold',
                                     'minLength'=>0,
                                     'select'=>'js: function(event, ui) {
                                        
                                           //console.log(ui.item.id)
                                            $("#Request_contract_id").val(ui.item.id);
                                          
                                     }',
                                     //'close'=>'js:function(){$(this).val("");}',
                                     
                            ),
                           'htmlOptions'=>array(
                                'class'=>'span8'
                            ),
                                  
                        ));


					//echo $form->textFieldRow($model,'contract_id',array('class'=>'span3')); 


	?>

	<?php echo $form->textAreaRow($model,'note',array('class'=>'span8','maxlength'=>500)); ?>

	
	<?php
			if(Yii::app()->user->isExecutive() || Yii::app()->user->isAdmin())
            {  
                echo $form->dropDownListRow($model, 'status', array("1"=>"เปิด","2"=>"ปิด","3"=>"ยกเลิก"),array('class'=>'span2','style'=>'height:30px;'), array('options' => array('status'=>array('selected'=>true)))); 
    
            }   ?>

    <hr> 


	 <?php 
		    $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'link',
		    'type'=>'danger',
		    'label'=>'ลบตัวอย่าง',
		    'icon'=>'minus-sign',
		    'htmlOptions'=>array(
		        'onclick'=>'     
		             num =  parseInt($("#num_sample").val()) - 1;
		             if(num>0)
		             {
		             	$("#num_sample").val(num+"");
		             	//console.log(num)
		             	$("#index"+(num+1)).hide();
		           	 }
		                    ',
		        'class'=>'pull-right','style'=>'margin:0px 0px 0px 10px;'
		    ),
		));   
	?>	    
   
    <?php 
		    $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'link',
		    'type'=>'success',
		    'label'=>'เพิ่มตัวอย่าง',
		    'icon'=>'plus-sign',
		    'htmlOptions'=>array(
		        'onclick'=>'     
		             num =  parseInt($("#num_sample").val()) + 1;
		             if(num<4)
		             {
		             	$("#num_sample").val(num+"");
		             	//console.log(num)
		             	$("#index"+num).show();
		           	 }
		                    ',
		        'class'=>'pull-right'
		    ),
		));   
	?>	  

	<input type="hidden" id="num_sample" name="num_sample" value="1">

	<div style="margin-top:40px;">
    
    <h5>ตัวอย่างทดสอบที่ 1</h5>
	
	<?php
	 		
            
	 		$this->renderPartial('//requestStandard/_form', array(
                  'model' => $modelReqSD1,
                  'index' => 1,
                  'display' => 'block'
              ));  
	?>
	</div>
	
     <div id="index2" style="display:none">
     <hr>
	 <h5>ตัวอย่างทดสอบที่ 2</h5>
	
	<?php 		
	 	
            $this->renderPartial('//requestStandard/_form', array(
                  'model' => $modelReqSD2,
                  'index' => 2,
                  'display' => 'block'
             ));  
    ?>
    </div>

      <div id="index3" style="display:none">
      <hr>
	<h5>ตัวอย่างทดสอบที่ 3</h5> 
    <?php        

            $this->renderPartial('//requestStandard/_form', array(
                  'model' => $modelReqSD3,
                  'index' => 3,
                  'display' => 'block'
            ));  
          
    ?>
    </div>




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
