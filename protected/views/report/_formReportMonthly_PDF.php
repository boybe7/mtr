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

       
        /*$models = Yii::app()->db->createCommand()
                    ->select("count(cer_no) as sum,cer_name,SUM(workDay(TOTAL_WEEKDAYS(CONCAT( DATE_FORMAT( cer_date,  '%Y' ),  '-', DATE_FORMAT( cer_date,  '%m-%d' ) ) , CONCAT( DATE_FORMAT( cer_oper_date,  '%Y' ),  '-', DATE_FORMAT( cer_oper_date,  '%m-%d' ) ) ))) as date_oper")
                    ->from('c_cer_doc cd')
                    //->join('c_cer_detail ct', 'cd.cer_id=ct.cer_id')
                    ->where('cer_date like "'.$date_m.'%"')
          ->group('cer_name')
                    ->queryAll();*/

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

        $thai_mm=array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
        $m_month=$thai_mm[(int)$month-1];
        $next_month = (int)$month==12 ? $thai_mm[0] : $thai_mm[(int)$month];
        $fiscal_year = (int)$month>9 ? $year+543+1 : $year+543;

        $html .= '<div style="text-align:center;font-size:16;font-weight: bold;text-decoration: underline;">ส่วนทดสอบคุณสมบัติวัสดุ</div>';

        $html .= '<div style="text-indent: 12.7mm;font-size:16;font-weight: bold;text-decoration: underline;">1.  ผลงานในเดือน  '.$m_month.' '.($year+543).'</div>';

        $html .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ส่วนทดสอบคุณสมบัติวัสดุได้ดำเนินการตรวจสอบ ทดสอบวัสดุต่างๆ ที่ใช้ในงานกรองน้ำ
                งานก่อสร้างวางท่อที่ใช้ในขบวนการผลิตน้ำประปาของการประปานครหลวงได้จำนวน 1,849 ตัวอย่าง เก็บเงินค่าทดสอบได้ 495,450 บาท
                </span>';

        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; นอกจากนี้ส่วนทดสอบคุณสมบัติวัสดุ ยังให้บริการการทดสอบหน่วยงานภายนอก ได้แก่ การประปาส่วนภูมิภาค และบริษัท ห้างฯ ร้านเอกชนต่างๆ เป็นจำนวน 252 ตัวอย่าง เก็บเงินค่าทดสอบได้ 66,400 บาท
                </span>';        
        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; คิดเป็นจำนวนตัวอย่างที่ทดสอบรวมทั้งสิ้น 2,101 ตัวอย่าง
                </span>';    
        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เก็บค่าทดสอบในเดือนนี้ได้ทั้งสิ้น 561,850บาท (ห้าแสนหกหมื่นหนึ่งพันแปดร้อยห้าสิบบาทถ้วน)
                </span>';   


        $html .= '<br><div style="text-indent: 12.7mm;font-size:16;font-weight: bold;text-decoration: underline;">2.    เป้าหมายของงานที่จะดำเนินการในเดือน  '.$next_month.' '.($year+543).'</div>';

        $html .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เนื่องจากปริมาณงานของส่วนทดสอบคุณสมบัติวัสดุ ขึ้นอยู่กับฝ่ายก่อสร้างระบบจ่ายน้ำ
ส่วนควบคุมคุณภาพท่อและอุปกรณ์ และหน่วยงานอื่นๆภายนอกเป็นผู้ส่งตัวอย่างต่าง ๆ มาให้ทดสอบจึงเป็นอุปสรรค ในการระบุเป้าหมายที่จะดำเนินการที่แน่นอนได้ แต่คาดว่าปริมาณงานที่จะทดสอบในเดือน
'.$next_month.' '.($year+543).' จะใกล้เคียงกับที่ทดสอบในเดือน '.$m_month.' '.($year+543).'

                </span>';

        $html .= '<br><div style="text-indent: 12.7mm;font-size:16;font-weight: bold;text-decoration: underline;">3.    สรุปผลงานการดำเนินงานในปีงบประมาณ  '.($fiscal_year).'</div>';

        $html .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เป้าหมาย/ปริมาณงานระหว่าง 1 ตุลาคม '.($fiscal_year-1).' ถึง 30 กันยายน '.($fiscal_year).' ที่ส่วนทดสอบคุณสมบัติวัสดุได้ตั้งเป้าปริมาณงานทดสอบวัสดุต่างๆ ไว้รวมทั้งสิ้น 12,100 ตัวอย่าง และคาดว่าจะเก็บค่าให้บริการทดสอบวัสดุได้ประมาณ 5.0 ล้านบาท
                </span>'; 
        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สรุปผลงานตั้งแต่วันที่ 1 ตุลาคม '.($fiscal_year-1).'  ถึง '.cal_days_in_month(CAL_GREGORIAN,$month,$year).' '.$m_month.' '.($year+543).' ส่วนทดสอบคุณสมบัติวัสดุได้ดำเนินการทดสอบวัสดุต่างๆ เป็นปริมาณรวมทั้งสิ้น 18,165 ตัวอย่าง เก็บเงินค่าทดสอบได้ทั้งสิ้น 5,406,490บาท (ห้าล้านสี่แสนหกพันสี่ร้อยเก้าสิบบาทถ้วน)
                </span>';                 
        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; แบ่งตามประเภทงานได้ดังนี้
                </span>';                  
        $html .= '<br><table style="width:100%">
                      <tr>
                        <td style="width:10%">&nbsp;</td>
                        <td style="width:80%">
                          <table border="1" style="width:100%">
                            <thead>
                              <tr>
                                <td style="width:40%;text-align:center;"><b>ประเภทงาน</b></td>
                                <td style="width:30%;text-align:center;"><b>จำนวนตัวอย่าง</b></td>
                                <td style="width:30%;text-align:center;"><b>ค่าทดสอบ<br>(บาท)</b></td>
                              </tr>
                            </thead>
                             <tbody>
                              <tr>
                                <td style="width:40%;text-align:center;">งานภายใน กปน.</td>
                                <td style="width:30%;text-align:right;"></td>
                                <td style="width:30%;text-align:right;"></td>
                              </tr>
                              <tr>
                                <td style="width:40%;text-align:center;">งานบริการ</td>
                                <td style="width:30%;text-align:right;"></td>
                                <td style="width:30%;text-align:right;"></td>
                              </tr>
                              <tr>
                                <td style="width:40%;text-align:center;">รวม</td>
                                <td style="width:30%;text-align:right;"></td>
                                <td style="width:30%;text-align:right;"></td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td style="width:10%">&nbsp;</td>
                      </tr>
                    </table>';

        $html .='<br pagebreak="true" />';  
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
