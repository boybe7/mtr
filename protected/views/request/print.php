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

	function bahtTranslate($value)
	{
		
			$str = strval($value);
			//$str = "1219";
			$k = strlen($str);

			$priceStr = '';
			for ($i=0;$i<strlen($str);$i++) {
			    //echo $str[$i]."<br>";
			    $n='';
			    $b='';
			    switch (intval($str[$i])){
			        case 1: $n="หนึ่ง"; break;
			        case 2: $n="สอง"; break;
			        case 3: $n="สาม"; break;
			        case 4: $n="สี่"; break;
			        case 5: $n="ห้า"; break;
			        case 6: $n="หก"; break;
			        case 7: $n="เจ็ด"; break;
			        case 8: $n="แปด"; break;
			        case 9: $n="เก้า"; break;
			    }
			   if(intval($str[$i])!=0) 
			    switch ($k){
			        
			        case 2: $b="สิบ"; break;
			        case 3: $b="ร้อย"; break;
			        case 4: $b="พัน"; break;
			        case 5: $b="หมื่น"; break;
			        case 6: $b="แสน"; break;
			        case 7: $b="ล้าน"; break;
			        
			    }
			    if($k==2 && intval($str[$i])==2)
			        $n = "ยี่";
			    if($k==2 && intval($str[$i])==1)
			        $n = "";
			    
			    $priceStr .=$n.$b;
			    $k--;
			}

			return $priceStr."บาทถ้วน";
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
	$html .= '<td style="width:34%;border-bottom:1px solid black;text-align:center;">' . $invoice->invoice_no . '</td>';
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
	$html .= 'ค่าทดสอบ .......................' . number_format($invoice->cost,2) . '........................... บาท<br/>';
	$html .= 'ค่าภาษีมูลค่าเพิ่ม .....................' . number_format(($invoice->cost*7)/100,2) . '........................... บาท<br/>';
	$html .= 'รวมเป็นเงินทั้งสิ้น ....................' . number_format($invoice->cost + ($invoice->cost*7)/100,2) . '............................ บาท<br/>';
	$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(............'.bahtTranslate($invoice->cost + ($invoice->cost*7)/100).'..............)';
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '</table>';

	// ขอความกรุณา....
	$html .= '<br><br><table border="0">';
	$html .= '<tr>';
	$html .= '<td style="width:40%;text-align:center;border: solid 1px black;">';
	$html .= 'ขอความกรุณา<br/>โปรดแยกใบเสร็จรับเงิน<br/>1 ฉบับต่อใบแจ้งชำระค่าธรรมเนียม 1 ใบ';
	$html .= '</td>';
	$html .= '<td style="width:60%;text-align:center;">';
	$html .= '<br/><br/><br/>(นายฐิติศักดิ์ ยุทธนาเสวิน)<br/>หน.สทว.กมว.';
	$html .= '</td>';
	$html .= '</tr>';
	$html .= '</table><br><br>';

	// ตอบกลับ
	$html .= '<br><b>เรียน หน.สทว.</b>';
	$html .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;กกง. ได้รับเงินค่าทดสอบดังกล่าวข้างต้นไว้แล้ว โดยออกหลักฐานดังนี้ ';
	$html .= '<br>ใบเสร็จรับเงินเล่มที่................................................เลขที่..................................................ลงวันที่.................................';
	$html .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;จึงเรียนมาเพื่อโปรดทราบ';

	$html .= '<br><table border="0">';
	$html .= '<tr>';
	$html .= '<td style="width:40%;">';
	$html .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	$html .= '</td>';
	$html .= '<td style="width:60%;text-align:center;">';
	$html .= '<br/><br/><br/>(................................................)<br/>................................................';
	$html .= '</td></tr>';
	$html .= '<tr><td>&nbsp;&nbsp;&nbsp;</td><td style="width:60%;text-align:center;">ผู้รับเงิน</td>';
	$html .= '</tr>';
	$html .= '</table><br><br>';
	
	$html .= '<br><b><u>หมายเหตุ</u></b>';
	$html .= '<br><b>1.สทว.กมว. สงวนสิทธิ์ที่จะไม่ทำการทดสอบ จนกว่าผู้ส่งตัวอย่างจะชำระค่าธรรมเนียมการทดสอบวัสดุ<br>เป็นที่เรียบร้อยแล้ว</b>';

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