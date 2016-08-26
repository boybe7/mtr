<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/mtr/protected/tcpdf/tcpdf.php');


    


    class MYPDF extends TCPDF {

            //Page header
            private $date_start;
            private $date_end;


//          public function setDate($start, $end) {
//              $this->date_start = $start;
//              $this->date_end = $end;
//          }

            public function Header() {
                
                // Set font
                $this->SetFont('thsarabun', 'B', 20);
                // Title
                //$this->Cell(0, 5, 'รายงานสรุปยอดรับรองท่อ/อุปกรณ์', 0, false, 'C', 0, '', 0, false, 'M', 'M');
               // $this->writeHTMLCell(145, 20, 40, 10, 'การประปานครหลวง<br>', 0, 1, false, true, 'C', false);
                //$image_file = $_SERVER['DOCUMENT_ROOT'].'/engstd/images/mwa_logo.png';
                //$this->Image($image_file, 180, 10, 15, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            }   

            // Page footer
            public function Footer() {
                // Position at 15 mm from bottom
                $this->SetY(-10);
                // Set font
                $this->SetFont('thsarabun', '', 11);
                // Page number
                //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                // Logo
                //$image_file = 'bank/image/mwa2.jpg';
                //$this->Image($image_file, 170, 270, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
                $this->Cell(0, 5, date("d/m/Y"), 0, false, 'R', 0, '', 0, false, 'T', 'M');

                //$this->writeHTMLCell(145, 550, 40, 287, '-'.$this->getAliasNumPage().'/'.$this->getAliasNbPages().'-', 0, 1, false, true, 'C', false);
                //writeHTMLCell ($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=false, $reseth=true, $align='', $autopadding=true)
            }
        }

  
        //$pdf->setDate($date_start,$date_end);
        $pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Boybe');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
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
        $pdf->SetMargins(PDF_MARGIN_LEFT, 15, 10);
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

        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        
        $pdf->AddPage();


        
        $html = "";
        $pdf->SetFont('thsarabun', '', 16, '', true);

        function displayDate($date)
        {
          $str = explode("-", $date);
          return $str[2]."/".$str[1]."/".$str[0];
        }


        $thai_mm=array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

        $m_month=$thai_mm[(int)$month-1];


         $date_start = $year."-".$month."-01"; 
         $date_end = $year."-".$month."-".cal_days_in_month(CAL_GREGORIAN,$month,$year);

         $condition = "";
        if($cat=="overdue")
        {
            $condition = "  AND  bill_date IS NULL  ";
            $html .="<center><h4>รายงานสรุปค้างชำระเงินค่าทดสอบประจำเดือน&nbsp;".$m_month."&nbsp;".($year+543)."</h4></center>";
        }elseif ($cat=="paid") {
             $condition = "  AND  bill_date IS NOT NULL  ";
            $html .="<center><h4>รายงานสรุปชำระเงินค่าทดสอบประจำเดือน&nbsp;".$m_month."&nbsp;".($year+543)."</h4></center>";
        }  
        else{
            $html .="<center><h4>รายงานสรุปสถานะการชำระเงินค่าทดสอบประจำเดือน&nbsp;".$m_month."&nbsp;".($year+543)."</h4></center>";
        }
        $sql = "SELECT * FROM requests rq LEFT JOIN invoices i ON rq.id=i.request_id  WHERE  rq.date BETWEEN '".$date_start."' AND '".$date_end."' ".$condition;
        $result = Yii::app()->db->createCommand($sql)->queryAll();


          $html .= '<table border="1" >
             <thead>
              <tr>
                <th style="text-align:center;width:5%">ลำดับ</th>
                <th style="text-align:center;width:15%">เลขที่ใบแจ้ง<br>ชำระเงิน</th>
                <th style="text-align:center;width:30%">เจ้าของตัวอย่าง</th>
                <th style="text-align:center;width:15%">วันที่รับตัวอย่าง</th>
                <th style="text-align:center;width:15%">จำนวนเงิน</th>
                <th style="text-align:center;width:25%">เลขที่ชำระ/วันที่ชำระ</th>
               
              </tr>
            </thead>
            <tbody>';
       
                         $i = 1;
                         $sum_cost = 0;
                         foreach ($result as $key => $value) {
                           $html .= '<tr>';
                              $html .= '<td style="text-align:center;width:5%">'.$i.'</td>';
                              $html .= '<td style="text-align:center;width:15%">'.$value['invoice_no'].'</td>';
                              $html .= '<td style="width:30%">'.Vendor::model()->findByPk($value['owner_id'])->name.'</td>';
                              $html .= '<td style="text-align:center;width:15%">'.displayDate($value['date']).'</td>';
                              $html .= '<td style="text-align:right;width:15%">'.number_format($value['cost'],2).'</td>';
                              $sum_cost += $value['cost'];
                              if(empty($value['bill_date']))
                                 $html .= '<td style="text-align:center;width:25%">-</td>';
                              else
                                 $html .= '<td style="text-align:center;width:25%">'.$value['bill_no'].'<br>'.displayDate($value['bill_date']).'</td>';
                           $html .= '</tr>';

                           $i++;
                         }

                        $html .= '<tr>';
                              $html .= '<td colspan="4" style="text-align:center;font-weight:bold"> รวม </td>';
                              $html .= '<td style="text-align:right;font-weight:bold">'.number_format($sum_cost,2).'</td>';
                              $html .= '<td style="text-align:center;"></td>';
                         $html .= '</tr>';



          $html .= '  </tbody>';
          $html .= '</table>';


        

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

       

        if(file_exists($_SERVER['DOCUMENT_ROOT'].'/mtr/print/'.'tempReport.pdf'))
        {    
            if(unlink($_SERVER['DOCUMENT_ROOT'].'/mtr/print/'.'tempReport.pdf'))
                $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/mtr/print/'.'tempReport.pdf','F');
        }else{
           $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/mtr/print/'.'tempReport.pdf','F');
        }

        
        ob_end_clean() ;

        exit;


       

?>
