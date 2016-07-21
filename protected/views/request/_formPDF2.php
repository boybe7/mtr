<?php

	//require_once($_SERVER['DOCUMENT_ROOT'].'/engstd/protected/tcpdf/tcpdf.php');

	function renderDate($value)
	{
	    $th_month = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	    $dates = explode("/", $value);
	    $d=0;
	    $mi = 0;
	    $yi = 0;
	    foreach ($dates as $key => $value) {
	         $d++;
	         if($d==2)
	            $mi = $value;
	         if($d==3)
	            $yi = $value;
	    }
	    if(substr($mi, 0,1)==0)
	        $mi = substr($mi, 1);
	    if(substr($dates[0], 0,1)==0)
	        $d = substr($dates[0], 1);
	    else
	    	$d = $dates[0];

	    $renderDate = $d." ".$th_month[$mi]." ".$yi;
	    if($renderDate==0)
	        $renderDate = "";   

	    return $renderDate;             
	}

	class MYPDF extends TCPDF {
			private $cer_no;
			private $contract_no;
			private $contractor;
			private $vendor;
			private $inspec_no;
			private $dept_order;
			private $prod_type;
			private $date_op;

			public function setHeaderInfo($cer_no, $contract_no,$contractor,$vendor,$inspec_no,$dept_order,$prod_type,$date_op) {
		        $this->cer_no = $cer_no;
		        $this->contract_no = $contract_no;
		        $this->contractor = $contractor;
		        $this->vendor = $vendor;
		        $this->inspec_no = $inspec_no;
		        $this->dept_order = $dept_order;
		        $this->prod_type = $prod_type;
		        $this->date_op = $date_op;
		        
		    }



			private $author1;
			private $author2;
			private $author3;
			private $pos_author2;
			private $pos_author3;
			private $is_acting2;
			private $is_acting3;

			public function setFooterInfo($author1, $author2,$author3,$pos_author2,$pos_author3,$is_acting2,$is_acting3){
				$this->author1 = $author1;
		        $this->author2 = $author2;
		        $this->author3 = $author3;
		        $this->pos_author2 = $pos_author2;
		        $this->pos_author3 = $pos_author3;
		        $this->is_acting2 = $is_acting2;
		        $this->is_acting3 = $is_acting3;
			}


		    //Page header
		    public function Header() {
		        
		        // Set font
		        //$this->SetFont('thsarabun', '', 18);
		        $this->SetFont('angsanaupc', '', 18);
		        $this->writeHTMLCell(145, 20, 40, 41, '<p style="font-weight:bold;">ใบรับรองคุณภาพท่อและอุปกรณ์ประปาเลขที่ '.$this->cer_no, 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(145, 20, 40, 53, '<p style="font-weight:bold;font-size:12">แนบท้ายหนังสือกมว.ที่..................</p>', 0, 1, false, true, 'C', false);
		        
		        $this->writeHTMLCell(150, 20, 47, 53, '<p style="font-weight:bold;font-size:12">'.$this->dept_order.'</p>', 0, 1, false, true, 'R', false);
		        $this->writeHTMLCell(150, 20, 47, 60, '<p style="font-weight:bold;font-size:12">'.$this->inspec_no.'</p>', 0, 1, false, true, 'R', false);
				
		        $this->writeHTMLCell(145, 20, 15, 65, '<p style="font-weight:bold;font-size:12">สัญญา </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 30, 65, '<p style="font-weight:bold;font-size:12">'.$this->contract_no.'</p>', 0, 1, false, true, 'L', false);
		        
		        $this->writeHTMLCell(145, 20, 15, 70, '<p style="font-weight:bold;font-size:12">คู่สัญญา </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 30, 70, '<p style="font-weight:bold;font-size:12">'.$this->contractor.'</p>', 0, 1, false, true, 'L', false);
				$this->writeHTMLCell(145, 20, 110, 70, '<p style="font-weight:bold;font-size:12">ผู้ผลิต/จัดส่ง</p>', 0, 1, false, true, 'L', false);
				$this->writeHTMLCell(145, 20, 129, 70, '<p style="font-weight:bold;font-size:12">'.$this->vendor.'</p>', 0, 1, false, true, 'L', false);
		        		        		        

		        $this->writeHTMLCell(145, 20, 15, 75, '<p style="font-weight:bold;font-size:12">ท่อ/อุปกรณ์ </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 30, 75, '<p style="font-weight:bold;font-size:12">'.$this->prod_type.'</p>', 0, 1, false, true, 'L', false);
				$this->writeHTMLCell(145, 20, 110, 75, '<p style="font-weight:bold;font-size:12">วันที่ดำเนินการ</p>', 0, 1, false, true, 'L', false);
				$this->writeHTMLCell(145, 20, 129, 75, '<p style="font-weight:bold;font-size:12">'.$this->date_op.'</p>', 0, 1, false, true, 'L', false);
		        			        


		        // Title
		        //\\$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		    }

		    // Page footer
		    public function Footer() {
		        // Position at 15 mm from bottom
		        $this->SetY(-10);

		        //$this->SetFont('thsarabun', '', 11);
		        $this->SetFont('angsanaupc', '', 10);

		        $this->writeHTMLCell(50, 150, 12, 230,'.................................................................' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(50, 150, 12, 235,'<p style="font-weight:bold;font-size:14px;">('.$this->author1.')</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(50, 150, 12, 240,'<p style="font-weight:bold;font-size:14px;">วิศวกรผู้ตรวจสอบ</p>' , 0, 1, false, true, 'C', false);

		        if($this->is_acting2==false)
		        {	
		        	$this->writeHTMLCell(50, 150, 80, 230,'.................................................................' , 0, 1, false, true, 'C', false);
		        	$this->writeHTMLCell(50, 150, 80, 235,'<p style="font-weight:bold;font-size:14px;">('.$this->author2.')</p>' , 0, 1, false, true, 'C', false);
		        	$this->writeHTMLCell(50, 150, 80, 240,'<p style="font-weight:bold;font-size:14px;">'.$this->pos_author2.'</p>' , 0, 1, false, true, 'C', false);
		        }
		        else
		        {
		        	$this->writeHTMLCell(50, 170, 80, 230,'.................................................................' , 0, 1, false, true, 'C', false);
		        	$this->writeHTMLCell(50, 170, 80, 235,'<p style="font-weight:bold;font-size:14px;">('.$this->author2.')</p>' , 0, 1, false, true, 'C', false);
		        	$this->writeHTMLCell(50, 170, 80, 240,'<p style="font-weight:bold;font-size:14px;">'.$this->pos_author2.' รักษาการแทน</p>' , 0, 1, false, true, 'C', false);
		        	$this->writeHTMLCell(50, 170, 80, 244,'<p style="font-weight:bold;font-size:14px;">หัวหน้าส่วนควบคุมคุณภาพท่อและอุปกรณ์' , 0, 1, false, true, 'C', false);
		        	
		        }

		        if($this->is_acting3==false)
		        {	
			        $this->writeHTMLCell(50, 150, 147, 230,'.................................................................' , 0, 1, false, true, 'C', false);
			        $this->writeHTMLCell(50, 150, 147, 235,'<p style="font-weight:bold;font-size:14px;">('.$this->author3.')</p>' , 0, 1, false, true, 'C', false);
			        $this->writeHTMLCell(50, 150, 147, 240,'<p style="font-weight:bold;font-size:14px;">'.$this->pos_author3.'</p>' , 0, 1, false, true, 'C', false);
			    }
			    else
			    {
			    	$this->writeHTMLCell(50, 150, 147, 230,'.................................................................' , 0, 1, false, true, 'C', false);
			        $this->writeHTMLCell(50, 150, 147, 235,'<p style="font-weight:bold;font-size:14px;">('.$this->author3.')</p>' , 0, 1, false, true, 'C', false);
			        $this->writeHTMLCell(50, 150, 147, 240,'<p style="font-weight:bold;font-size:14px;">หน.สคภ. รักษาการแทน</p>' , 0, 1, false, true, 'C', false);
			    	$this->writeHTMLCell(50, 150, 147, 244,'<p style="font-weight:bold;font-size:14px;">ผู้อำนวยการกองมาตรฐานวิศวกรรม' , 0, 1, false, true, 'C', false);
		        	
			    }
			        
		        $this->writeHTMLCell(145, 550, 10, 258,'<p style="font-weight:bold;">ข้อควรพึงปฏิบัติ</p>' , 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(170, 750, 28, 258,'<p style="font-weight:bold;">1.ใบรับรองนี้ให้ถือเสมือนหนึ่งเป็นใบกำกับผลิตภัณฑ์ ให้ผู้ผลิตแนบไปพร้อมกับการส่งท่อ/อุปกรณ์ที่ได้ผ่านการตรวจสอบมาตรฐานจากกองมาตรฐานวิศวกรรมแล้วทุกครั้ง</p>' , 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(170, 750, 28, 263,'<p style="font-weight:bold;">2.ท่อ/อุปกรณ์ใดที่ไม่มีใบรับรองฯ หรือมีรายละเอียดผิดไปจากใบรับรองฯ ซึ่งกำกับผลิตภัณฑ์มาด้วยนี้ จะไม่ได้รับการตรวจรับงานจากเจ้าหน้าที่ตรวจรับของการประปานครหลวง</p>' , 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(170, 750, 28, 268,'<p style="font-weight:bold;">3.ใบรับรองฯที่ส่งให้หน่วยงานของกปน. ให้หน่วยงานฯใช้ประกอบในการตรวจสอบ/ตรวจรับ ให้ถูกต้องตรงกับฉบับซึ่งมาพร้อมกับผลิตภัณฑ์จากผู้ผลิตและให้รวบรวมเก็บไว้เป็น<br>  หลักฐานเพื่อตรวจสอบภายหลังได้</p>' , 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(170, 750, 28, 278,'<p style="font-weight:bold;">4.ใบรับรองฯจะต้องไม่มีรอยขูดขีด แก้ ลบใดๆ หากมีการแก้ดังกล่าวต้องมีลายมือชื่อเจ้าหน้าที่ควบคุม กำกับทุกแห่ง ในส่วนที่เป็นอำนาจหน้าที่ของเจ้าหน้าที่นั้นๆ</p>' , 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 550, 100, 283,'<p style="font-weight:bold;">กองมาตรฐานวิศวกรรม</p>' , 0, 1, false, true, 'C', false);
			    
		       
		    }
		}

		// create new PDF document
		//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$width = 210;
		$height = 305 ;
		$pagelayout = array($width, $height); //  or array($height, $width) 
        //new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
		//$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf = new MYPDF('P', PDF_UNIT, $pagelayout, true, 'UTF-8', false);	


		//set info header   
		//$prod = ProdType::model()->findByPk($model->prod_id); 
		/*$m = Yii::app()->db->createCommand()
					->select('prot_name')
					->from('m_prodtype')	
					->where('prot_id="'.$model->prod_id.'"')					                   
					->queryAll();*/
					
		$inspec_no = $model->request_no;
		//$date_oper = renderDate($model->cer_oper_date);
		$con = $model->result_headers;
		foreach ($con as $key => $value) {
			print_r($value);
		}


		$pdf->setHeaderInfo($model->request_no, "","","",$inspec_no,"","","");
		//$pdf->setHeaderInfo($model->request_no, $model->contract->name,$model->contractor,$model->vend_id,$inspec_no,$model->dept_id,$model->prod_id,$date_oper);


		//set info footer   
		//$pos_author2 = "หัวหน้าส่วนควบคุมคุณภาพท่อและอุปกรณ์";
		/*$is_acting2 = strpos($model->cer_ct_name, "รักษาการแทน");
		$name2 = str_replace("(รักษาการแทน)", "", $model->cer_ct_name);
		$author = Yii::app()->db->createCommand()
					->select('posi_name')
					->from('user')
					->join('m_position p', 'user.position=p.id')
					->where('name="'.$name2.'"')	                   
					->queryAll();
		$pos_author2 = $author[0]['posi_name'];		

		$is_acting3 = strpos($model->cer_di_name, "รักษาการแทน");	
		$name3 = str_replace("(รักษาการแทน)", "", $model->cer_di_name);
		$author = Yii::app()->db->createCommand()
					->select('posi_name')
					->from('user')
					->join('m_position p', 'user.position=p.id')
					->where('name="'.$name3.'"')	                   
					->queryAll();*/
		//$pos_author3 = "ผู้อำนวยการกองมาตรฐานวิศวกรรม";
		//$pos_author3 = $author[0]['posi_name'];					
		//$pdf->setFooterInfo($model->cer_name, $name2,$name3,$pos_author2,$pos_author3,$is_acting2,$is_acting3);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Boybe');
		$pdf->SetTitle('MWA');
		$pdf->SetSubject('MWA');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
		$pdf->setPrintHeader(true);
		$pdf->setFooterData(array(0,64,0), array(0,64,128));

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(10, 80, 8);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		$pdf->AddPage();
		$html = '';

        
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);


		//--------watermark--------------------//
		/*if($model->cer_status==3)
		{
				$width = $pdf->GetStringWidth(trim("ยกเลิก"), "angsanaupc", "B", 90, false );
				$factor = round(($width * sin(deg2rad(45))) / 2 ,0);
				// Get the page width/height
				$myPageWidth = $pdf->getPageWidth();
				$myPageHeight = $pdf->getPageHeight();
				// Find the middle of the page and adjust.
				$myX = ( $myPageWidth / 2 ) - $factor;
				$myY = ( $myPageHeight / 2 ) + $factor;
				// Set the transparency of the text to really light
				$pdf->SetAlpha(0.09);
				// Rotate 45 degrees and write the watermarking text
				$pdf->StartTransform();
				$pdf->Rotate(45, $myX-20, $myY);
				$pdf->SetFont("angsanaupc", "B", 90);
				$pdf->Text($myX, $myY ,trim("ยกเลิก"));
				$pdf->StopTransform();
				// Reset the transparency to default
				$pdf->SetAlpha(1); 
		}*/

		//---------end--------------------------//

        //$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/engstd/print/'.$filename,'F');
        //$pdf->Output('result.pdf', 'I');
        //ob_end_clean() ;


       

?>
