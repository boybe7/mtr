<?php
	class my_pdf extends TCPDF {

	      //Page header
	      public function Header() {

	        //$this->SetFont('thsarabun', '', 14, '', true);
	        //$footer_text = '<div>Left</div>';               
	        //$this->writeHTMLCell(50, 10, 10, 20, $footer_text, 1, 0, 0, true, 'L', true);

	        $file = Yii::app()->request->baseUrl . '/images/mwa01.png';
	        $this->Image($file, 19, 9, 32, 0, 'PNG', '', 'T', false, 600, '', false, false, 0, false, false, false);

	        //$this->SetFont('thsarabun', '', 14, '', true);
	        //$footer_text = '<div>Right</div>';               
	        //$this->writeHTMLCell(50, 10, 150, 20, $footer_text, 1, 1, 0, true, 'R', true);
	      }

	      // Page footer
	      public function Footer() {
			$this->SetFont('thsarabun', '', 12, '', true);
			$footer_text = '<div><b>สทว.1) ชำระค่าทดสอบ/S77</b></div>';               
			$this->writeHTMLCell(80, 10, 10, 285, $footer_text, 0, 0, false, true, 'L', true);

	        $footer_text = '<div>“รับผิดชอบหน้าที่ มีวินัย โปร่งใส ซื่อสัตย์ ไม่ขัดแย้งผลประโยชน์”<br>ค่านิยม กปน. “มุ่งมั่น พัฒนาตน พัฒนางาน บริการสังคม ด้วยความรับผิดชอบ”
	</div>';               
	        $this->writeHTMLCell(110, 50, 50, 280, $footer_text, 0, 0, false, true, 'C', true);

	        $file = Yii::app()->request->baseUrl . '/images/mwa02.jpg';
	        $this->Image($file, 165, 273, 25, 0, 'JPG', '', 'T', false, 600, '', false, false, 0, false, false, false);
		 }		
	}

	//--- create new PDF document ---//
	$pdf = new my_pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	//--- set document information ---//
	$pdf->SetCreator('Mwa Lab');
	$pdf->SetAuthor('Mwa Lab');
	$pdf->SetTitle('Invoice');
	$pdf->SetSubject('Invoice detail');
	$pdf->SetKeywords('invoice, lab');

	//--- set default header data ---//
	$pdf->setPrintHeader(true);
	$pdf->setPrintFooter(true);

	//--- set default monospaced font ---//
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	//--- set margins ---//
	$pdf->SetMargins(20, 10, 20); // left = 2.5 cm, top = 4 cm, right = 2.5cm
	//$pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
	//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	//--- set auto page breaks ---//
	$pdf->SetAutoPageBreak(TRUE, 1);
	//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	//--- set image scale factor ---//
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	//--- set some language-dependent strings (optional) ---//
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	    require_once(dirname(__FILE__).'/lang/eng.php');
	    $pdf->setLanguageArray($l);
	}

	//--- set default font subsetting mode ---//
	$pdf->setFontSubsetting(true);

	// Set font
	$pdf->SetFont('thsarabun', '', 30, '', true);

	// Add a page
	$pdf->AddPage();

	// set text shadow effect
	$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

	// Set some content to print
	$pdf->SetFont('thsarabun', '', 35, '', true);
	$content = '<div style="text-align:center;line-height: 200%;">บันทึกข้อความ</div>';
	$pdf->writeHTML($content, false, false, false, false, ''); 

	$pdf->SetFont('thsarabun', '', 16, '', true);
	$html = '';
	$html .= '<table border="0">';
	$html .= "<tbody>";
	$html .= "<tr>";
	$html .= '<td style="width:13%;"><b>หน่วยงาน</b></td>';
	$html .= '<td style="width:87%;border-bottom:1px solid black;"> ส่วนทดสอบคุณสมบัติวัสดุ กองมาตรฐานวิศวกรรม (โทร. 1733)</td>';
	$html .= "</tr>";
	$html .= "</tbody>";
	$html .= "</table>";
	$html .= '<table border="0">';
	$html .= "<tbody>";
	$html .= "<tr>";
	$html .= '<td style="width:18%;"><b>อันดับการทดสอบที่</b></td>';
	$html .= '<td style="width:34%;border-bottom:1px solid black;text-align:center;">' . $invoice->request->request_no . '</td>';
	$html .= '<td style="width:5%;">วันที่</td>';
	$html .= '<td style="width:43%;border-bottom:1px solid black;text-align:center;">' . $invoice->request->date . '</td>';
	$html .= "</tr>";
	$html .= "</tbody>";
	$html .= "</table>";
	$html .= '<table border="0">';
	$html .= "<tbody>";
	$html .= "<tr>";
	$html .= '<td style="width:5%;"><b>เรื่อง</b></td>';
	$html .= '<td style="width:95%;border-bottom:1px solid black;"> ขอให้เก็บค่าธรรมเนียมการทดสอบวัสดุ</td>';
	$html .= "</tr>";
	$html .= "</tbody>";
	$html .= "</table>";

	// เรียน ....
	$html .= '<b>เรียน ผอ.กกง.</b>';
	$html .= '<div style="text-indent: 10em;">ด้วย บริษัท/ห้าง   ' . $invoice->request->owner->name .'   ได้นำตัวอย่างวัสดุมาให้ ส่วนทดสอบคุณสมบัติวัสดุ (สทว.)';
	$html .= ' ดำเนินการทดสอบคุณสมบัติ ';
	$count = count($invoice->request->req_std);
	$i = 1;
	foreach ($invoice->request->req_std as $row) {
		$labtype_name = $row->labtype->name;
		$material_detail = $row->labtype->material->name;
		$lot_no = $row->lot_no;
		$lot_num = $row->lot_num;
		$sampling_num = $row->sampling_num;

		$html .= "$labtype_name ของ$material_detail จำนวน $lot_num lot หมายเลข lot $lot_no จำนวนตัวอย่าง $sampling_num ตัวอย่าง";
		if ($i < $count) {
			$html .= " และทดสอบคุณสมบัติ ";
		}
		$i++;
	}
	$html .= '<br/>จึงเรียนมาเพื่อโปรดเก็บเงินและออกใบเสร็จรับเงินให้แก่ บริษัทฯ ห้างฯ ดังกล่าวข้างต้นดังนี้</div>';

	// ค่าทดสอบ
	$html .= '<table border="0">';
	$html .= '<tr>';
	$html .= '<td style="width:14%"></td>';
	$html .= '<td style="width:86%">';
	$html .= 'ค่าทดสอบ .......................' . $invoice->cost . '........................... บาท<br/>';
	$html .= 'ค่าภาษีมูลค่าเพิ่ม .....................' . ($invoice->cost*7)/100 . '........................... บาท<br/>';
	$html .= 'รวมเป็นเงินทั้งสิ้น ....................' . ($invoice->cost + ($invoice->cost*7)/100) . '.................................... บาท<br/>';
	$html .= '(.................................................................................................................)';
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '</table>';

	// ขอความกรุณา....
	$html .= '<table border="0">';
	$html .= '<tr>';
	$html .= '<td style="width:40%;text-align:center;border: solid 1px black;">';
	$html .= 'ขอความกรุณา<br/>โปรดแยกใบเสร็จรับเงิน<br/>1 ฉบับต่อใบแจ้งชำระค่าธรรมเนียม 1 ใบ';
	$html .= '</td>';
	$html .= '<td style="width:60%;text-align:center;">';
	$html .= '<br/><br/><br/>(นายฐิติศักดิ์ ยุทธนาเสวิน)<br/>หน.สทว.กมว.';
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '</table>';
	$pdf->writeHTML($html, false, false, false, false, '');

	// Close and output PDF document
	//echo $html;
	$pdf->Output('invoice.pdf', 'I');

	//$pdf->lastPage(); 

	//============================================================+
	// END OF FILE
	//============================================================+
	/* writeHTMLCell($w, $h, $x, $y, $html = '', $border=0, $ln = 0, $fill = false, $reseth = true, $align = '', $autopadding = true) */		
?>