

<?php
	// Model Data
	$request_standard = $output['request_standard'];
	$reqstd_id = $request_standard['reqstd_id'];
	$header_list = $request_standard['header_list'];
	$sample_list = $request_standard['sample_list'];
	$result_list = $request_standard['result_list'];

	echo CHtml::beginForm('', 'POST', array('id'=>'add-raw-form'));
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
			echo "<td style='text-align:center;'>";
			echo CHtml::textField("result[$result_id]", $result_value, array('style'=>'width:100px;'));
			echo "</td>";
		}
		echo "</tr>";
	}
	echo "</tbody>";
	echo "</table>";
	echo CHtml::endForm();
?>