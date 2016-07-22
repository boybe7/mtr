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
			private $owner;
			private $job;
			private $tester;
			private $register_date;
			private $test_date;

			public function setHeaderInfo($cer_no, $contract_no,$owner,$job,$tester,$test_date) {
		        $this->cer_no = $cer_no;
		        $this->contract_no = $contract_no;
		        $this->owner = $owner;
		        $this->job = $job;
		        $this->tester = $tester;
		       //$this->register_date = $register_date;
		        $this->test_date = $test_date;
		      
		        
		    }
			private $author1;
			private $author2;
			private $author3;
			private $pos_author1;
			private $pos_author2;
			private $pos_author3;

			public function setFooterInfo($author1, $author2,$author3,$pos_author1,$pos_author2,$pos_author3){
				$this->author1 = $author1;
		        $this->author2 = $author2;
		        $this->author3 = $author3;
		        $this->pos_author1 = $pos_author1;
		        $this->pos_author2 = $pos_author2;
		        $this->pos_author3 = $pos_author3;
	
			}
		    //Page header
		    public function Header() {
		        
		        // Set font
		        //$this->SetFont('thsarabun', '', 18);
		        $this->SetFont('angsanaupc', '', 14);
		        $this->writeHTMLCell(145, 20, 15, 39, '<p style="font-weight:bold;">อันดับการทดสอบที่   <font size="18">   '.$this->cer_no.'</font></p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 15, 47, '<p style="font-weight:bold;">เจ้าของตัวอย่าง </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 43, 47, '<p style="font-weight:bold;">'.$this->contract_no.'</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 15, 53, '<p style="font-weight:bold;">งานสัญญา </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 35, 53, '<p style="font-weight:bold;">'.$this->owner.'</p>', 0, 1, false, true, 'L', false);
		        //$this->writeHTMLCell(145, 20, 40, 53, '<p style="font-weight:bold;">แนบท้ายหนังสือกมว.ที่..................</p>', 0, 1, false, true, 'C', false);
		   
                $this->writeHTMLCell(145, 20, 110, 40, '<p style="font-weight:bold;">งาน</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 122, 40, '<p style="font-weight:bold;">'.$this->job.'</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 110, 47, '<p style="font-weight:bold;">เจ้าหน้าที่ทดสอบ</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 140, 47, '<p style="font-weight:bold;">'.$this->tester.'</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 110, 53, '<p style="font-weight:bold;">วันที่ทดสอบ </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 140, 53, '<p style="font-weight:bold;">'.$this->test_date.'</p>', 0, 1, false, true, 'L', false);
				
		    
		        // Title
		        //\\$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		    }
		    // Page footer
		    public function Footer() {
		        // Position at 15 mm from bottom
		        $this->SetY(-10);
		        $this->SetFont('angsanaupc', '', 14);
		        $this->writeHTMLCell(50, 150, 12, 260,'...........................................................' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(50, 150, 12, 265,'<p style="font-weight:bold;">('.$this->author1.')</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(50, 150, 12, 270,'<p style="font-weight:bold;">'.$this->pos_author1.'</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(50, 150, 12, 275,'<p style="font-weight:bold;">ผู้รายงานผล</p>' , 0, 1, false, true, 'C', false);
		      
		        $this->writeHTMLCell(50, 150, 80, 260,'............................................................' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(50, 150, 80, 265,'<p style="font-weight:bold;">('.$this->author2.')</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(50, 150, 80, 270,'<p style="font-weight:bold;">'.$this->pos_author2.'</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell(50, 150, 80, 275,'<p style="font-weight:bold;">ผู้ตรวจ</p>' , 0, 1, false, true, 'C', false);
		      
			    $this->writeHTMLCell(50, 150, 147, 260,'............................................................' , 0, 1, false, true, 'C', false);
			    $this->writeHTMLCell(50, 150, 147, 265,'<p style="font-weight:bold;">('.$this->author3.')</p>' , 0, 1, false, true, 'C', false);
			    $this->writeHTMLCell(50, 150, 147, 270,'<p style="font-weight:bold;">'.$this->pos_author3.'</p>' , 0, 1, false, true, 'C', false);
			    $this->writeHTMLCell(50, 150, 147, 275,'<p style="font-weight:bold;">ผู้รับรอง</p>' , 0, 1, false, true, 'C', false);
			  			    
		       
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
					
	    $result_headers = TestResultsHeaders::model()->findAll('request_id=:id', array(':id' => $model->id));
	    //print_r($result_headers);
		$date_oper = renderDate($result_headers[0]->test_date);	
		
		$tester = $result_headers[0]->tester_1!="" ? $result_headers[0]->tester_1 : "";
		if($tester=="" && $result_headers[0]->tester_2!="")
			$tester = $result_headers[0]->tester_2;
		else if($tester!="" && $result_headers[0]->tester_2!="")
			$tester .= ", ".$result_headers[0]->tester_2;
			
		$pdf->setHeaderInfo($model->request_no, $model->contract->name,$model->owner->name,$model->job->name,$tester,$result_headers[0]->test_date);

	
		//set info footer   
		$user = User::model()->findAll('name=:id', array(':id' => $result_headers[0]->reporter));
		//print_r($user[0]->positionsId1);
		$pos_reporter = $user[0]->positionsId1->name;
		$user = User::model()->findAll('name=:id', array(':id' => $result_headers[0]->approver));
		$pos_approver = $user[0]->positionsId1->name;
		$user = User::model()->findAll('name=:id', array(':id' => $result_headers[0]->signer));
		$pos_signer = $user[0]->positionsId1->name;


		$pdf->setFooterInfo($result_headers[0]->reporter,$result_headers[0]->approver,$result_headers[0]->signer,$pos_reporter,$pos_approver,$pos_signer);

	
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

		$requestStandards = RequestStandard::model()->findAll('request_id=:id', array(':id' => $model->id));


        
		$pdf->writeHTML($html, false, false, false, false, '');
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
       $pdf->Output('result.pdf', 'I');
        //ob_end_clean() ;
       
?>