<?php
	//echo "<pre>";
	//var_dump($output['result']);
	//echo "</pre>";
?>
<div class="main_title">บันทึกผลทดสอบ</div>
<div style="padding-bottom: 20px"></div>
<div style="padding-top:10px" class="grid-view">

<?php echo CHtml::beginForm(); ?>

<?php
	foreach ($output['request_standard'] as $row) {
		$material_name = $row['material_name'];
		$labtype_name = $row['labtype_name'];
		$header_list = $row['header_list'];
		$sample_list = $row['sample_list'];
		$result_list = $row['result_list'];

		echo "<div class='main_title'>$labtype_name</div>";
		echo "ชนิดวัสดุ: " . CHtml::textField("labtype_name", $labtype_name, array('readonly'=>true));
		echo "<table border='1' class='items table table-bordered table-condensed'>";
		// Columns
		echo "<thead>";
		echo "<tr>";
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
			foreach ($header_list as $header) {
				$labtype_input_id = $header['id'];
				$header_name = $header['name'];

				$result_id = $result_list[$sampling_no][$labtype_input_id]['id'];
				$result_value = $result_list[$sampling_no][$labtype_input_id]['value'];
				if($header_name == 'SPECIMEN MARK'){
					echo "<td style='text-align:center;'>$result_value</td>";
				}else{
					echo "<td style='text-align:center;'>";
					echo CHtml::textField("result[$result_id]", $result_value, array('style'=>'width:100px;'));
					echo "</td>";
				}
			}
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		echo "มาตรฐาน .....<br/>";
		echo "สรุปผลการทดสอบ: " . CHtml::textField("", '', array('width:100%;'));
		echo "<br/><br/>";
	}
?>
<center>
<?php echo CHtml::submitButton('บันทึกผล'); ?>
</center>
<?php echo CHtml::endForm(); ?>
</div>