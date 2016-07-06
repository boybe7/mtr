<div class="main_title">บันทึกผลทดสอบ</div>
<div style="padding-bottom: 20px"></div>
<div style="padding-top:10px" class="grid-view">

<?php echo CHtml::beginForm(); ?>

<?php
	// Request
	$request = $output['request'];
	$request_id = $request['request_id'];
	$request_no = $request['request_no'];
	$job_name = $request['job_name'];
	$owner_name = $request['owner_name'];
	$vendor_name = $request['vendor_name'];

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
	echo '<span class="add-on"><i class="icon-calendar"></i></span>';
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("เจ้าหน้าที่ทดสอบ 1", "");
	echo CHtml::textField("result_header[tester_1]", $tester_1);
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("เจ้าหน้าที่ทดสอบ 2", "");
	echo CHtml::textField("result_header[tester_2]", $tester_2);
	echo "</div>";
	echo "</div>";

	echo "<div class='row'>";
	echo "<div class='span3'>";
	echo CHtml::label("ผู้ตรวจ", "");
	echo CHtml::textField("result_header[approver]", $approver);
	echo "</div>";
	echo "<div class='span3'>";
	echo CHtml::label("ผู้รายงานผล", "");
	echo CHtml::textField("result_header[reporter]", $reporter);
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
	echo CHtml::textField("result_header[signer]", $signer);
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

		echo "<div class='main_title'>$labtype_name</div>";
		echo "ชนิดวัสดุ: " . CHtml::textField("", $material_name, array('readonly'=>true));
		$this->widget('bootstrap.widgets.TbButton', array(
		  'buttonType'=>'link',
		  'type'=>'success',
		  'label'=>'Add Raw',
		  'icon'=>'plus-sign',
		  'htmlOptions'=>array(
		    'class'=>'pull-right',
		    'style'=>'margin:-20px 10px 10px 10px;',
		     'onclick'=>'addRaw(' . $reqstd_id . ')'
		   ),
		));

		echo "<table border='1' class='items table table-bordered table-condensed'>";
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
				if($decimal==0)
					echo CHtml::textField("result[$result_id]", $result_value, array('style'=>'width:100px;'));
				else
					echo CHtml::textField("result[$result_id]", number_format($result_value,$decimal), array('style'=>'width:100px;'));
				echo "</td>";
			}
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "มาตรฐาน " . $standard_name . "<br/>";
		echo "สรุปผลทดสอบ: " . CHtml::textField("reqstd[$reqstd_id]", $conclude, array('class'=>'span9'));
		echo "<hr/>";
	}

	// ResultHeader End
	echo CHtml::label("หมายเหตุ", "");
	echo CHtml::textField("result_header[comment]", $comment, array('class'=>'span9'));
	echo CHtml::hiddenField("result_header[result_header_id]", $result_header_id);
?>

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
<?php echo CHtml::endForm(); ?>
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
                    	//console.log(msg);
                    });
                }
            });
	}
</script>