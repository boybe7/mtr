<div class="main_title">บันทึกผลทดสอบ</div>
<div style="padding-bottom: 20px"></div>
<div style="padding-top:10px" class="grid-view well span10">
<style type="text/css">
	input[type="text"] {
		margin-bottom: 0px;
	}
</style>

<?php //echo CHtml::beginForm(); ?>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'request-form',
	'htmlOptions' => array('class' => ''),
	'enableAjaxValidation'=>false,
)); 
?>

<?php
	// Request
	$request = $output['request'];
	$request_id = $request['request_id'];
	$request_no = $request['request_no'];
	$job_name = $request['job_name'];
	$owner_name = $request['owner_name'];
	$vendor_name = $request['vendor_name'];

	$models = User::model()->with(array('positionsId1' => array('condition' => "level = 1")
                                    ))->findAll(array('order'=>'', 'condition'=>'', 'params'=>array()));
	
    $list = array();
    foreach ($models as $key => $value) {
        $list[$value['name']] = $value['name'];        
    }    

    $models = User::model()->with(array('positionsId1' => array('condition' => "level = 2")
                                    ))->findAll(array('order'=>'', 'condition'=>'', 'params'=>array()));

	
    $list2 = array();
    foreach ($models as $key => $value) {
        $list2[$value['name']] = $value['name'];        
    }

    $models = User::model()->with(array('positionsId1' => array('condition' => "level = 3")
                                    ))->findAll(array('order'=>'', 'condition'=>'', 'params'=>array()));

	
    $list3 = array();
    foreach ($models as $key => $value) {
        $list3[$value['name']] = $value['name'];        
    }    
    

	echo "<div class='row'>";
	echo "<div class='span3'>";
	echo CHtml::label("เลขที่ลำดับทดสอบ", "");
	echo CHtml::textField("", $request_no, array('readonly'=>true));
	echo "</div>";
	echo "</div>";

	echo "<div class='row'>";
	echo "<div class='span3'>";
	echo CHtml::label("เจ้าของตัวอย่าง", "");
	echo CHtml::textField("", $owner_name, array('readonly'=>true));
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("ประเภทงาน", "");
	echo CHtml::textField("", $job_name, array('readonly'=>true));
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("ผู้ผลิต", "");
	echo CHtml::textField("", $vendor_name, array('readonly'=>true));
	echo "</div>";
	echo "</div>";

	// ResultHeader Begin
	$result_header = $output['result_header'];
	$result_header_id = $result_header['result_header_id'];
	$test_date = $result_header['test_date'];
	$tester_1 = $result_header['tester_1'];
	$tester_2 = $result_header['tester_2'];
	$approver = $result_header['approver'];
	$reporter = $result_header['reporter'];
	$signer = $result_header['signer'];
	$signed_date = $result_header['signed_date'];
	$comment = $result_header['comment'];

	echo "<div class='row'>";
	echo "<div class='span3 input-append'>";
	echo CHtml::label("วันที่ทดสอบ", "");
	$this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'result_header[test_date]',
	    'value'=>$test_date,
	    // additional javascript options for the date picker plugin
	    'options'=>array(
	        'showAnim'=>'fold',
	        'mode'=>'focus',
	        'format'=>'dd/mm/yyyy', //กำหนด date Format
	    ),
	    'htmlOptions'=>array(
	        'style'=>'height:20px;'
	    ),
	));



    //echo CHtml::dropDownList('categories', '', $list,array('empty' => '(Select a category)'));


	echo '<span class="add-on"><i class="icon-calendar"></i></span>';
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("เจ้าหน้าที่ทดสอบ 1", "");
	echo CHtml::dropDownList('result_header[tester_1]', $tester_1, $list,array('empty' => '----เลือกเจ้าหน้าที่ทดสอบ---------'));
	//echo CHtml::textField("result_header[tester_1]", $tester_1);
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("เจ้าหน้าที่ทดสอบ 2", "");
	//echo CHtml::textField("result_header[tester_2]", $tester_2);
	echo CHtml::dropDownList('result_header[tester_2]', $tester_2, $list,array('empty' => '----เลือกเจ้าหน้าที่ทดสอบ---------'));
	echo "</div>";
	echo "</div>";

	echo "<div class='row'>";
	echo "<div class='span3'>";
	echo CHtml::label("ผู้ตรวจ", "");
	//echo CHtml::textField("result_header[approver]", $approver);
	echo CHtml::dropDownList('result_header[approver]', $approver, $list2);
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("ผู้รายงานผล", "");
	//echo CHtml::textField("result_header[reporter]", $reporter);
	echo CHtml::dropDownList('result_header[reporter]', $reporter, $list,array('empty' => '----เลือกผู้รายงานผล---------'));
	echo "</div>";
	echo "</div>";
	
	echo "<div class='row'>";
	echo "<div class='span3 input-append'>";
	echo CHtml::label("วันที่รับรอง", "");
	$this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'result_header[signed_date]',
	    'value'=>$signed_date,
	    // additional javascript options for the date picker plugin
	    'options'=>array(
	        'showAnim'=>'fold',
	        'mode'=>'focus',
	        'format'=>'dd/mm/yyyy', //กำหนด date Format
	    ),
	    'htmlOptions'=>array(
	        'style'=>'height:20px;'
	    ),
	));
	echo '<span class="add-on"><i class="icon-calendar"></i></span>';
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("ผู้รับรอง", "");
	//echo CHtml::textField("result_header[signer]", $signer);
	echo CHtml::dropDownList('result_header[signer]', $signer, $list3);
	echo "</div>";
	echo "</div>";
	echo "<hr/>";

	// RequestStandard
	foreach ($output['request_standard'] as $request_standard) {
		$reqstd_id = $request_standard['reqstd_id'];
		$labtype_name = $request_standard['labtype_name'];
		$material_name = $request_standard['material_name'];
		$standard_name = $request_standard['standard_name'];
		$conclude = $request_standard['conclude'];
		$header_list = $request_standard['header_list'];
		$sample_list = $request_standard['sample_list'];
		$result_list = $request_standard['result_list'];

		$modelSTDParam = Yii::app()->db->createCommand()
				->select('value,labtype_input_id')
				->from('standard_parameters') 
				->where('standard_id='.$request_standard['standard_id'])                             
				->queryAll();
		
		//print_r($modelSTDParam);

		$modelLabtype = LabtypeInput::model()->findAll(array("condition"=>"labtype_id=".$request_standard['labtype_id']));
		$index = 1;
		$std_val = array();
		$std_col = array();

		$max_col = count($modelLabtype);
		foreach ($modelLabtype as $key => $value) {
			
			foreach ($modelSTDParam as $key => $sd) {
				if($sd['labtype_input_id']==$value->id)
				{
					$std_val[] = $sd['value'];
					$std_col[] = $index;
					
				}	
			}
				
			
			$index++;	
		}	

		//print_r($std_col);

		//echo count($std_val);


		echo "<div class='main_title'>$labtype_name</div>";
		echo "ชนิดวัสดุ: " . CHtml::textField("", $material_name, array('readonly'=>true));
		$this->widget('bootstrap.widgets.TbButton', array(
		  'buttonType'=>'link',
		  'type'=>'success',
		  'label'=>'บันทึกข้อมูลที่ใช้คำนวณ',
		  'icon'=>'plus-sign',
		  'htmlOptions'=>array(
		    'class'=>'pull-right',
		    'style'=>'margin:0px 10px 10px 10px;',
		     'onclick'=>'addRaw(' . $reqstd_id . ')'
		   )
		));

		$this->widget('bootstrap.widgets.TbButton', array(
		  'buttonType'=>'ajaxLink',
		  'type'=>'info',
		  'label'=>'คำนวณ',
		  'icon'=>'repeat',
		  'url'=>array('requestStandard/index/'.$id),
		  'htmlOptions'=>array(
		    'class'=>'pull-right',
		    'style'=>'margin:0px 0px 10px 10px;',
		     
		   ),
		  'ajaxOptions'=>array(
		    	    
		     	    'type' => 'POST',
                	'data' =>  'js:$("#request-form").serialize()',
                	'success' => 'function(msg){ 

         			}'
                ) 

		));
		//echo "<form name='req".$reqstd_id."' action='/mtr/requestStandard/index/52'>";
		echo "<table style='margin-top:10px' border='1' class='items table table-bordered table-condensed'>";
		// Columns
		echo "<thead>";
		echo "<tr>";
		//echo "<th>Sampling no</th>";
		foreach ($header_list as $header) {
			echo "<th style='text-align:center;'>" . $header['name'] . "</th>";
		}
		echo "</tr>";
		echo "</thead>";

		// Rows
		echo "<tbody>";
		foreach ($sample_list as $sample) {
			$sampling_no = $sample['sampling_no'];
			echo "<tr>";
			//echo "<td>$sampling_no</td>";
			foreach ($header_list as $header) {
				$labtype_input_id = $header['id'];
				//$header_name = $header['name'];

				$result_id = $result_list[$sampling_no][$labtype_input_id]['id'];
				$result_value = $result_list[$sampling_no][$labtype_input_id]['value'];
				$decimal = $result_list[$sampling_no][$labtype_input_id]['decimal'];
				echo "<td style='text-align:center;'>";

				if($decimal==0 && !is_numeric($result_value))
					echo CHtml::textField("result[$result_id]", $result_value, array('style'=>'width:100px;text-align:center'));
				else
					echo CHtml::textField("result[$result_id]", number_format($result_value,$decimal), array('style'=>'width:100px;text-align:right'));
				echo "</td>";
			}
			echo "</tr>";
		}

		//get standard value
		if(count($std_col)>0)
		{
			echo "<tr>";
				echo "<td colspan=".($std_col[0]-1).">";
					echo "<b>" . $standard_name."</b>";
				echo "</td>";

				
						for ($i=$std_col[0]; $i < $std_col[count($std_col)-1]+1; $i++) { 
							//echo $i."|";
							$found = 0;
							$value;
							for($j=0;$j<count($std_col) && !$found;$j++)
							{
								//echo "j:".$std_col[$j]."xx";
								if($std_col[$j]==$i)
								{  
								 $found = 1; $value = $std_val[$j]; 
								}
							}		

							if($found)
							{	
								if(is_numeric($value))
								      echo "<td style='background-color:#eeeeee;text-align:right;padding-right:10px;'>".$value."</td>";
								else  
									  echo "<td style='background-color:#eeeeee;text-align:center'>".$value."</td>"; 
   							}
							else
							    echo "<td></td>";	 
						}


			echo "</tr>";
		}


		echo "</tbody>";
		echo "</table>";
		//echo "</form>";
		if(count($std_col)==0)
			echo "<b>" . $standard_name . "</b><br/><br/>";
	
			echo "<b>สรุปผลทดสอบ :</b> <br>" . CHtml::textArea("reqstd[$reqstd_id]", $conclude, array('class'=>'span10','rows'=>4));
		
	}

	// ResultHeader End
	echo "<b>หมายเหตุ :</b> <br>";
	echo CHtml::textArea("result_header[comment]", $comment, array('class'=>'span10','rows'=>2));
	echo CHtml::hiddenField("result_header[result_header_id]", $result_header_id);

?>
<br>
<!-- Submit Form -->
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
<?php// echo CHtml::endForm(); ?>
<?php $this->endWidget(); ?>
</div>
<style type="text/css">
	.modal {
		width: 900px;
	}
</style>

<!-- AddRaw Dialog -->

<div id="modal-content" class="modal hide">
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    </div>
    <div id="modal-body" class='modal-body'>
    </div>
</div>

<!-- JS Function -->
<script type='text/javascript'>
	// Show AddRaw Dialog
	function addRaw(reqstd_id){
		
		// IF modal loaded!
		if($("#modal-body")[0]==null)
		{
			$("#modal-content").append("<div id='modal-body'></div>")
		}

        var v = $("#modal-body").load("../addRaw/" + reqstd_id);
        js:bootbox.confirm(v,"ยกเลิก","ตกลง",
            function(confirmed){           
                if(confirmed)
                {
                    $.ajax({
                        type: "POST",
                        url: "../addRaw/" + reqstd_id,
                        dataType:"json",
                        data: $(".modal-body #add-raw-form").serialize()
                    })                                  
                    .done(function(msg) {
                    	window.location.reload()
                    });
                }
            });
	}
</script>