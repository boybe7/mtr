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

			public function setHeaderInfo($cer_no, $contract_no,$owner,$job,$tester,$test_date,$register_date) {
		        $this->cer_no = $cer_no;
		        $this->contract_no = $contract_no!="" ? $contract_no:"-" ;
		        $this->owner = $owner;
		        $this->job = $job;
		        $this->tester = $tester;
		        $this->register_date = $register_date;
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
		        $this->SetFont('angsanaupc', '', 15);
		          $this->writeHTMLCell(145, 20, 30, 32, '<p style="font-szie:18px;font-weight:bold;"><font size="18"> ใบรายงานผลการทดสอบ</font></p>', 0, 1, false, true, 'C', false);

		        $this->writeHTMLCell(145, 20, 1, 52, '<p style="font-weight:bold;">อันดับการทดสอบที่   <font size="18">   '.$this->cer_no.'</font></p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 1, 59, '<p style="font-weight:bold;">เจ้าของตัวอย่าง </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 28, 59, '<p style="font-weight:bold;">'.$this->contract_no.'</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 1, 65, '<p style="font-weight:bold;">งานสัญญา </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 22, 65, '<p style="font-weight:bold;">'.$this->owner.'</p>', 0, 1, false, true, 'L', false);
		        //$this->writeHTMLCell(145, 20, 40, 53, '<p style="font-weight:bold;">แนบท้ายหนังสือกมว.ที่..................</p>', 0, 1, false, true, 'C', false);
		   
                $this->writeHTMLCell(145, 20, 110, 53, '<p style="font-weight:bold;">งาน</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 122, 53, '<p style="font-weight:bold;">'.$this->job.'</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 110, 59, '<p style="font-weight:bold;">เจ้าหน้าที่ทดสอบ</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 140, 59, '<p style="font-weight:bold;">'.$this->tester.'</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 110, 65, '<p style="font-weight:bold;">วันที่รับตัวอย่าง </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 135, 65, '<p style="font-weight:bold;">'.$this->register_date.'</p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 155, 65, '<p style="font-weight:bold;">วันที่ทดสอบ </p>', 0, 1, false, true, 'L', false);
		        $this->writeHTMLCell(145, 20, 175, 65, '<p style="font-weight:bold;">'.$this->test_date.'</p>', 0, 1, false, true, 'L', false);
				
		    	 $this->writeHTMLCell(145, 20, 180, 44, '<p style=""> SHEET '.$this->getAliasNumPage() .' OF '.$this->getAliasNbPages().'</p>', 0, 1, false, true, 'L', false);
				
		        // Title
		        //\\$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		    }
		    // Page footer
		    public function Footer() {
		        // Position at 15 mm from bottom
		        $width = 60;
		        $this->SetY(-10);
		        $this->SetFont('angsanaupc', '', 15);
		        $this->writeHTMLCell($width, 20, 5, 265,'...................................................' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell($width, 20, 5, 270,'<p style="font-weight:bold;">('.$this->author1.')</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell($width, 20, 5, 275,'<p style="font-weight:bold;">'.$this->pos_author1.'</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell($width, 20, 5, 283,'<p style="font-weight:bold;">ผู้รายงานผล</p>' , 0, 1, false, true, 'C', false);
		      
		        $this->writeHTMLCell($width, 20, 75, 265,'...................................................' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell($width, 20, 75, 270,'<p style="font-weight:bold;">('.$this->author2.')</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell($width, 20, 75, 275,'<p style="font-weight:bold;">'.$this->pos_author2.'</p>' , 0, 1, false, true, 'C', false);
		        $this->writeHTMLCell($width, 20, 75, 283,'<p style="font-weight:bold;">ผู้ตรวจ</p>' , 0, 1, false, true, 'C', false);
		      
			    $this->writeHTMLCell($width, 20, 147, 265,'...................................................' , 0, 1, false, true, 'C', false);
			    $this->writeHTMLCell($width, 20, 147, 270,'<p style="font-weight:bold;">('.$this->author3.')</p>' , 0, 1, false, true, 'C', false);
			    $this->writeHTMLCell($width, 20, 147, 275,'<p style="font-weight:bold;">'.$this->pos_author3.'</p>' , 0, 1, false, true, 'C', false);
			    $this->writeHTMLCell($width, 20, 147, 283,'<p style="font-weight:bold;">ผู้รับรอง</p>' , 0, 1, false, true, 'C', false);
			  			    
			  			    
		       
		    }
		}
		// create new PDF document
		//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$width = 250;
		$height = 305 ;
		$pagelayout = array($width, $height); //  or array($height, $width) 
        //new TCPDF('p', 'pt', $pageLayout, true, 'UTF-8', false);
		$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		//$pdf = new MYPDF('P', PDF_UNIT, $pagelayout, true, 'UTF-8', false);	
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

		$contract = empty($model->contract) ? "-" : $model->contract->name;
			
		$pdf->setHeaderInfo($model->request_no,$model->owner->name,$contract,$model->job->name,$tester,$result_headers[0]->test_date,$model->date);

	
		//set info footer   
		$user = User::model()->findAll('name=:id', array(':id' => $result_headers[0]->reporter));
		//print_r($user[0]->positionsId1);
		$pos_reporter = empty($user) ? "" : $user[0]->positionsId1->name;
		$user = User::model()->findAll('name=:id', array(':id' => $result_headers[0]->approver));
		$pos_approver = empty($user) ? "" : $user[0]->positionsId1->name;
		$user = User::model()->findAll('name=:id', array(':id' => $result_headers[0]->signer));
		$pos_signer = empty($user) ? "" : $user[0]->positionsId1->name;


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
		$pdf->SetMargins(1, 72, 1);
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
		$pdf->SetFont('angsanaupc', '', 15);
		// ---------------------------------------------------------
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);
		$pdf->AddPage();

		$html = '';

		$requestStandards = RequestStandard::model()->findAll('request_id=:id', array(':id' => $model->id));


		$nrequest = count($requestStandards);
		$irequest = 0;
		$show_invoice = 0;
		$row_per_page = 16;
		foreach ($requestStandards as $key => $request) {
				$irequest++;

				$requestValue = TestResultsValue::model()->findAll('request_standard_id=:id  group by sampling_no', array(':id' => $request->id));
				$nsampling = count($requestValue);

				$npages = ceil($nsampling/$row_per_page);	
				$i_lot = 1;
				$lot = "";
				$num_lot = 0;
				for ($page=0; $page < $npages ; $page++) { 
				


					$html .= '<div style="text-align:center;font-weight:bold;font-size:20px">'.$request->labtype->name_report."</div>";

					$html .= '<table widht="100%" border=0>';
					$html .= 	'<tr>';
					$html .=		'<td width="50%">TYPE &nbsp;&nbsp;&nbsp;&nbsp;'. Material::model()->findByPk($request->labtype->material_id)->name.'&nbsp;&nbsp;&nbsp;&nbsp;'.$request->material_detail.'</td>';
					//$html .=		'<td width="50%" style="text-align:right">SHEET '.($page+1).'  OF '.$npages.'</td>';
					$html .= 	'</tr>';
					$html .= '</table>';


					/*$html .= '<table border="1"><thead>
						<tr>
						<th rowspan="2">Left column</th>
						<th colspan="2">Heading Column Span 5</th>
						<th rowspan="2" >X</th>
						<th rowspan="2" >C</th>
						</tr>
						<tr>
						
						<th >span 2</th>
						<th >span 2</th>
						
						</tr></thead><tbody>
						<tr>
							<td>1</td><td>2</td><td>3</td><td>4</td><td>5</td>
						</tr></tbody>
						</table>';*/

					//----------------Result-------------//
					$html .= '<table widht="100%" border="1">';
					//----------------Header--------------//
					// Header list			
					$sql = "SELECT id, name,decimal_display,width,group_header FROM labtype_inputs WHERE labtype_id='".$request->labtype_id."' AND type='header' ORDER BY col_index";
					$header_list = Yii::app()->db->createCommand($sql)->queryAll();

					$sql = "SELECT id, name,decimal_display,width,group_header FROM labtype_inputs WHERE labtype_id='".$request->labtype_id."' AND type='header' AND group_header!='' ";
					$header_group = Yii::app()->db->createCommand($sql)->queryAll();

					

					$html .=   '<thead>';
					$html .= 	'<tr>';
							// $headers = LabtypeInput::model()->findAll(array("condition"=>"labtype_id=:lab AND type='header'", "params"=>array(":lab"=>$request->labtype_id)));
							// foreach ($headers as $key => $header) {
							// 	$html .= 	'<th style="text-align:center">'.$header->name.'</th>';
							// }
						if(count($header_group)==0)
						{
							foreach ($header_list as $header) {

								if($header["width"]!=0)
								    $html .= 	'<th style="text-align:center;width:'.$header["width"].'%">'.$header["name"].'</th>';
								else
									$html .= 	'<th style="text-align:center">'.$header["name"].'</th>';
							}
						}
						else{
							$i = 0;
							$start = 0;
							$stop = 0;

							foreach ($header_list as $header) {
								if($header['group_header']=='')
								{
									if($header["width"]!=0)
									    $html .= 	'<th rowspan="2" style="text-align:center;width:'.$header["width"].'%">'.$header["name"].'</th>';
									else
										$html .= 	'<th  rowspan="2" style="text-align:center">'.$header["name"].'</th>';
								}
								else if($i>$stop || $i==0)
								{
									$sql = "SELECT count(*) as num, sum(width) as sum FROM labtype_inputs WHERE labtype_id='".$request->labtype_id."' AND type='header' AND group_header='".$header['group_header']."' ";
									$mtest = Yii::app()->db->createCommand($sql)->queryAll();
									$span = $mtest[0]['num'];

									$width = $mtest[0]['sum'];


									if($width!=0)
									    $html .= 	'<th colspan="'.$span.'" style="text-align:center;width:'.$width.'%">'.$header["group_header"].'</th>';
									else
										$html .= 	'<th colspan="'.$span.'" style="text-align:center">'.$header["group_header"].'</th>';


									$start = $i;
									$stop = $i + $span - 1;
									
								}

								$i++;
							}

							 $html .= '</tr><tr>';

							foreach ($header_group as $header) {

									if($header["width"]!=0)
									    $html .= 	'<th  style="text-align:center;width:'.$header["width"].'%">'.$header["name"].'</th>';
									else
										$html .= 	'<th  style="text-align:center">'.$header["name"].'</th>';
							}
						}	
				
					$html .= 	'</tr>';
					$html .=   '</thead>';

					

					//--------------------value----------------------------//
					$html .=   '<tbody>';
					// Sample list
					$sql = "SELECT sampling_no FROM test_results_values WHERE request_standard_id='".$request->id."' GROUP BY sampling_no ORDER BY concat(strSplit(sampling_no_fix,'-', 2)*1,id)";
					$sample_list = Yii::app()->db->createCommand($sql)->queryAll();

					// Result list
					$sql = "SELECT sampling_no, labtype_input_id, test_results_values.id, value,decimal_display  FROM test_results_values JOIN labtype_inputs ON test_results_values.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '".$request->id."' AND type='header'";
					$result = Yii::app()->db->createCommand($sql)->queryAll();
					$result_list = array();
						foreach ($result as $v) {
							$sampling_no = $v['sampling_no'];
							$labtype_input_id = $v['labtype_input_id'];
							$result_list[$sampling_no][$labtype_input_id] = array(
								'id' => $v['id'], 
								'value' => $v['value'],
								'decimal'=>$v['decimal_display']
							);
						}

						
						
						
						$row = 1;
						foreach ($sample_list as $sample) {

						  if($row < $row_per_page*($page+1) && $row >= $row_per_page*$page )
						  {	
							$sampling_no = $sample['sampling_no'];
							$html .= "<tr>";
							//echo "<td>$sampling_no</td>";
							$i = 1;
							$num_i = count($header_list);
						
							foreach ($header_list as $header) {
								$labtype_input_id = $header['id'];
								//$header_name = $header['name'];

								$result_id = $result_list[$sampling_no][$labtype_input_id]['id'];
								$result_value = $result_list[$sampling_no][$labtype_input_id]['value'];
								$decimal = $result_list[$sampling_no][$labtype_input_id]['decimal'];
								//$html .= '<td style="text-align:center;">';

								if($header["width"]!=0)
								    $html .= 	'<td style="text-align:center;width:'.$header["width"].'%">';
								else
									$html .= 	'<td style="text-align:center;">';

							    $result_value = str_replace(",", "", $result_value);

								if($decimal==0 && !is_numeric($result_value))
									$html .= $result_value;
								else
									$html .= number_format($result_value,$decimal);

								if($i==$num_i)
								{

									if($lot != $result_value)
									{
										$sql = "SELECT count(id) as num  FROM test_results_values  WHERE value = '".$result_value."' AND request_standard_id='".$request->id."' ";
										$result = Yii::app()->db->createCommand($sql)->queryAll();
										$lot = $result_value;

										$num_lot = $result[0]['num'];
										
										$i_lot = 1;
									}
									else{
										$i_lot++;

										
									}

									$html .= " (".$i_lot."/".$num_lot.")";

								}

								$i++;	

								$html .= "</td>";
							}
							$html .= "</tr>";
						  }	
 							if($row==$row_per_page*($page+1))
							   break 1; 

							$row++;
						}

					//--------------standard value---------------//
					$modelSTDParam = Yii::app()->db->createCommand()
									->select('value,labtype_input_id')
									->from('standard_parameters') 
									->where('standard_id='.$request->standard_id)                             
									->queryAll();
				

					$modelLabtype = LabtypeInput::model()->findAll(array("condition"=>"labtype_id=:lab AND type='header'", "params"=>array(":lab"=>$request->labtype_id)));
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

					if(count($std_col)>0)
					{
						$html .= "<tr>";
							$html .= '<td colspan="'.($std_col[0]-1).'">  '. $request->standard->name."</td>";

							
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
											$html .=  '<td style="text-align:center">'.$value.'</td>'; 
			   							}
										else
										    $html .=  "<td></td>";	 
									}

									for ($i=$std_col[count($std_col)-1]; $i < count($header_list); $i++) { 
										 $html .=  '<td style="border-bottom-color:white;border-right-color:white;"></td>';	
									}


						$html .=  "</tr>";
					}
					//---------------------------end standard value -------------------------//


					$html .=   '</tbody>';

					$html .= '</table><br>';

					if(!empty($result_headers[0]->comment))
					{
						$html .= '<br>หมายเหตุ  &nbsp;&nbsp;&nbsp;&nbsp;'.$result_headers[0]->comment.'<br>';
					}

					$html .= 'สรุปผลการทดสอบ  &nbsp;&nbsp;&nbsp;&nbsp;'.$request->conclude;

					$html .= '<br><br>ผลการทดสอบนี้รับรองเฉพาะตัวอย่างที่กองมาตรฐานวิศวกรรมได้รับเท่านั้น';


					if($page!=$npages-1)
						$html .='<br pagebreak="true" />';	

				}//end for npage


				if($irequest!= $nrequest)
					$html .='<br pagebreak="true" />';	
		}

				

				
						$invoices = Invoices::model()->findAll('request_id=:id', array(':id' => $model->id));
						$sum_cost = 0;
						foreach ($invoices as $key => $invoice) {
							$sum_cost += $invoice->cost;
						}
						$html .= '<br>ค่าธรรมเนียมการทดสอบ  เป็นเงิน &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.number_format($sum_cost,0).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   บาท';

						foreach ($invoices as $key => $invoice) {
							 if(!empty($invoice->bill_date))
							 {	
								$str_date = explode("-", $invoice->bill_date);
								$date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
								$html .= '<br>เลขที่ใบเสร็จ    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$invoice->bill_no.' &nbsp;&nbsp;&nbsp;   วันที่ '.$date;
							 }	
						}
				
		
        
		$pdf->writeHTML($html, false, false, false, false, '');
		//debug
		

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
       //echo $html;
        //ob_end_clean() ;
       
?>