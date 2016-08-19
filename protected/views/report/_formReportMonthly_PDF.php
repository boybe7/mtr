<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/mtr/protected/tcpdf/tcpdf.php');


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

        //-----------------------------------//
        $mm = (int)$month>9 ? $month : '0'.$month;
        $date_start = $year."-".$month."-01"; 
        $date_end = $year."-".$month."-".cal_days_in_month(CAL_GREGORIAN,$month,$year);
        //-----------งานภายใน------------------//
        $sql = "SELECT sum(sampling_num) as sum,sum(cost) as cost FROM request_standards rs LEFT JOIN requests r ON r.id=rs.request_id LEFT JOIN jobs j ON j.id=r.job_id WHERE job_group='งานภายใน กปน.' AND date BETWEEN '".$date_start."' AND '".$date_end."' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $num_request = $result[0]['sum'];
        $cost_request = $result[0]['cost'];

        $sql = "SELECT sum(rt.sampling_num) as sum,sum(rt.cost) as cost FROM retests rt LEFT JOIN request_standards rs ON rs.id=rt.request_standard_id LEFT JOIN requests r ON r.id = rs.request_id LEFT JOIN jobs j ON j.id=r.job_id WHERE job_group='งานภายใน กปน.' AND date BETWEEN '".$date_start."' AND '".$date_end."' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $num_retest = $result[0]['sum'];
        $cost_retest = $result[0]['cost'];

        $internal_num = $num_retest + $num_request;
        $internal_cost = $cost_retest + $cost_request;

        $html .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ส่วนทดสอบคุณสมบัติวัสดุได้ดำเนินการตรวจสอบ ทดสอบวัสดุต่างๆ ที่ใช้ในงานกรองน้ำ
                งานก่อสร้างวางท่อที่ใช้ในขบวนการผลิตน้ำประปาของการประปานครหลวงได้จำนวน '.number_format($internal_num,0).' ตัวอย่าง เก็บเงินค่าทดสอบได้ '.number_format($internal_cost,0).' บาท
                </span>';

        //-----------งานภายนอก------------------//
        $sql = "SELECT sum(sampling_num) as sum,sum(cost) as cost FROM request_standards rs LEFT JOIN requests r ON r.id=rs.request_id LEFT JOIN jobs j ON j.id=r.job_id WHERE job_group='งานบริการ' AND date BETWEEN '".$date_start."' AND '".$date_end."' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $num_request = $result[0]['sum'];
        $cost_request = $result[0]['cost'];

        $sql = "SELECT sum(rt.sampling_num) as sum,sum(rt.cost) as cost FROM retests rt LEFT JOIN request_standards rs ON rs.id=rt.request_standard_id LEFT JOIN requests r ON r.id = rs.request_id LEFT JOIN jobs j ON j.id=r.job_id WHERE job_group='งานบริการ' AND date BETWEEN '".$date_start."' AND '".$date_end."' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $num_retest = $result[0]['sum'];
        $cost_retest = $result[0]['cost'];

        $external_num = $num_retest + $num_request;
        $external_cost = $cost_retest + $cost_request;
        
        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; นอกจากนี้ส่วนทดสอบคุณสมบัติวัสดุ ยังให้บริการการทดสอบหน่วยงานภายนอก ได้แก่ การประปาส่วนภูมิภาค และบริษัท ห้างฯ ร้านเอกชนต่างๆ เป็นจำนวน '.number_format($external_num,0).' ตัวอย่าง เก็บเงินค่าทดสอบได้ '.number_format($external_cost,0).' บาท
                </span>';   


        //--------------All-----------------//        
        $num_overall  = $internal_num + $external_num; 
        $cost_overall  = $internal_cost + $external_cost;        


        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; คิดเป็นจำนวนตัวอย่างที่ทดสอบรวมทั้งสิ้น '.number_format($num_overall,0).' ตัวอย่าง
                </span>';    
        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เก็บค่าทดสอบในเดือนนี้ได้ทั้งสิ้น '.number_format($cost_overall,0).' บาท ('.bahtTranslate($cost_overall).')
                </span>';   


        $html .= '<br><div style="text-indent: 12.7mm;font-size:16;font-weight: bold;text-decoration: underline;">2.    เป้าหมายของงานที่จะดำเนินการในเดือน  '.$next_month.' '.($year+543).'</div>';

        $html .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เนื่องจากปริมาณงานของส่วนทดสอบคุณสมบัติวัสดุ ขึ้นอยู่กับฝ่ายก่อสร้างระบบจ่ายน้ำ
ส่วนควบคุมคุณภาพท่อและอุปกรณ์ และหน่วยงานอื่นๆภายนอกเป็นผู้ส่งตัวอย่างต่าง ๆ มาให้ทดสอบจึงเป็นอุปสรรค ในการระบุเป้าหมายที่จะดำเนินการที่แน่นอนได้ แต่คาดว่าปริมาณงานที่จะทดสอบในเดือน
'.$next_month.' '.($year+543).' จะใกล้เคียงกับที่ทดสอบในเดือน '.$m_month.' '.($year+543).'

                </span>';

        $html .= '<br><div style="text-indent: 12.7mm;font-size:16;font-weight: bold;text-decoration: underline;">3.    สรุปผลงานการดำเนินงานในปีงบประมาณ  '.($fiscal_year).'</div>';


        //----------------plan------------------------//
        $modelPlan = Plan::model()->findAll(array("condition"=>"year=:year", "params"=>array(":year"=>"2559")));
        $plan_sample = !empty($modelPlan[0]) ? $modelPlan[0]->sample : 0;
        $plan_income = !empty($modelPlan[0]) ? $modelPlan[0]->income : 0;

        $html .= '<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เป้าหมาย/ปริมาณงานระหว่าง 1 ตุลาคม '.($fiscal_year-1).' ถึง 30 กันยายน '.($fiscal_year).' ที่ส่วนทดสอบคุณสมบัติวัสดุ<br>ได้ตั้งเป้าปริมาณงานทดสอบวัสดุต่างๆ ไว้รวมทั้งสิ้น '.number_format($plan_sample).' ตัวอย่าง และคาดว่าจะเก็บค่าให้บริการทดสอบวัสดุได้ประมาณ '.$plan_income.' ล้านบาท
                </span>'; 

        //---------Overall until present----------------//      
        $date_start =  ($fiscal_year-1-543)."-10-01";       
        //-----------งานภายใน------------------//
        $sql = "SELECT sum(sampling_num) as sum,sum(cost) as cost FROM request_standards rs LEFT JOIN requests r ON r.id=rs.request_id LEFT JOIN jobs j ON j.id=r.job_id WHERE job_group='งานภายใน กปน.' AND date BETWEEN '".$date_start."' AND '".$date_end."' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $num_request = $result[0]['sum'];
        $cost_request = $result[0]['cost'];

        $sql = "SELECT sum(rt.sampling_num) as sum,sum(rt.cost) as cost FROM retests rt LEFT JOIN request_standards rs ON rs.id=rt.request_standard_id LEFT JOIN requests r ON r.id = rs.request_id LEFT JOIN jobs j ON j.id=r.job_id WHERE job_group='งานภายใน กปน.' AND date BETWEEN '".$date_start."' AND '".$date_end."' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $num_retest = $result[0]['sum'];
        $cost_retest = $result[0]['cost'];

        $internal_num_sum = $num_retest + $num_request;
        $internal_cost_sum = $cost_retest + $cost_request;
         //-----------งานภายนอก------------------//
        $sql = "SELECT sum(sampling_num) as sum,sum(cost) as cost FROM request_standards rs LEFT JOIN requests r ON r.id=rs.request_id LEFT JOIN jobs j ON j.id=r.job_id WHERE job_group='งานบริการ' AND date BETWEEN '".$date_start."' AND '".$date_end."' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $num_request = $result[0]['sum'];
        $cost_request = $result[0]['cost'];

        $sql = "SELECT sum(rt.sampling_num) as sum,sum(rt.cost) as cost FROM retests rt LEFT JOIN request_standards rs ON rs.id=rt.request_standard_id LEFT JOIN requests r ON r.id = rs.request_id LEFT JOIN jobs j ON j.id=r.job_id WHERE job_group='งานบริการ' AND date BETWEEN '".$date_start."' AND '".$date_end."' ";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        $num_retest = $result[0]['sum'];
        $cost_retest = $result[0]['cost'];

        $external_num_sum = $num_retest + $num_request;
        $external_cost_sum = $cost_retest + $cost_request;
                
        $html .= '<br><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; สรุปผลงานตั้งแต่วันที่ 1 ตุลาคม '.($fiscal_year-1).'  ถึง '.cal_days_in_month(CAL_GREGORIAN,$month,$year).' '.$m_month.' '.($year+543).' ส่วนทดสอบคุณสมบัติวัสดุ<br>ได้ดำเนินการทดสอบวัสดุต่างๆ เป็นปริมาณรวมทั้งสิ้น '.number_format($internal_num_sum+$external_num_sum).' ตัวอย่าง เก็บเงินค่าทดสอบได้ทั้งสิ้น '.number_format($internal_cost_sum+$external_cost_sum).' บาท ('.bahtTranslate($internal_cost_sum+$external_cost_sum).')
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
                                <td style="width:40%;text-align:center;">ประเภทงาน</td>
                                <td style="width:30%;text-align:center;">จำนวนตัวอย่าง</td>
                                <td style="width:30%;text-align:center;">ค่าทดสอบ<br>(บาท)</td>
                              </tr>
                            </thead>
                             <tbody>
                              <tr>
                                <td style="width:40%;text-align:center;">งานภายใน กปน.</td>
                                <td style="width:30%;text-align:right;">'.number_format($internal_num_sum).'</td>
                                <td style="width:30%;text-align:right;">'.number_format($internal_cost_sum).'</td>
                              </tr>
                              <tr>
                                <td style="width:40%;text-align:center;">งานบริการ</td>
                                <td style="width:30%;text-align:right;">'.number_format($external_num_sum).'</td>
                                <td style="width:30%;text-align:right;">'.number_format($external_cost_sum).'</td>
                              </tr>
                              <tr>
                                <td style="width:40%;text-align:center;">รวม</td>
                                <td style="width:30%;text-align:right;">'.number_format($internal_num_sum+$external_num_sum).'</td>
                                <td style="width:30%;text-align:right;">'.number_format($internal_cost_sum+$external_cost_sum).'</td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td style="width:10%">&nbsp;</td>
                      </tr>
                    </table>';

        $html .='<br pagebreak="true" />';  

        $html .= '<br><table style="width:100%">
                      <tr>
                        <td style="width:70%">&nbsp;</td>
                        <td style="width:30%">
                          <table border="1" style="width:100%">
                           
                              <tr>
                                <td style="width:100%;text-align:center;">ภาคผนวกหมายเลข 5</td>                              
                              </tr>
                           
                          </table>
                        </td>
                       
                      </tr>
                    </table>';

        $html .= '<br><div style="text-align:center;font-size:16;font-weight: bold;">ตารางที่ 1. ค่าทดสอบประจำเดือน '.$m_month.' '.($year+543).'</div>';

        $html .= '<br><table style="width:100%">
                      <tr>
                        <td style="width:10%">&nbsp;</td>
                        <td style="width:80%">
                          <table border="1" style="width:100%">
                            <thead>
                              <tr>
                                <td style="width:50%;text-align:center;font-weight:bold;">ประเภทงาน</td>
                                <td style="width:50%;text-align:center;font-weight:bold;">ค่าทดสอบ</td>
                                
                              </tr>
                            </thead>
                             <tbody>
                              <tr>
                                <td style="width:50%;text-align:center;">งานภายใน กปน.</td>
                                <td style="width:50%;text-align:right;">'.number_format($internal_cost).'</td>
                                
                              </tr>
                              <tr>
                                <td style="width:50%;text-align:center;">งานบริการ</td>
                                <td style="width:50%;text-align:right;">'.number_format($external_cost).'</td>
                               
                              </tr>
                              <tr>
                                <td style="width:50%;text-align:center;font-weight:bold;">รวม</td>
                                <td style="width:50%;text-align:right;font-weight:bold;">'.number_format($cost_overall).'</td>
                               
                              </tr>
                            </tbody>
                          </table>
                        </td>
                        <td style="width:10%">&nbsp;</td>
                      </tr>
                    </table>';

            $html .= '<br><div style="text-align:center;font-size:16;font-weight: bold;">ตารางที่ 2. จำแนกจำนวนการตรวจสอบ  ทดสอบ  วัสดุที่ใช้ในงานก่อสร้างและวางท่อของ กปน. <br>และงานบริการทดสอบแก่ภายนอก (ประจำเดือน '.$m_month.' '.($year+543).')</div>';


            $materials =  array
                            (
                              array("name"=>"คอนกรีต","id"=>"1,15"),
                              array("name"=>"ทราย,กรวด","id"=>"2,16"),
                              array("name"=>"ทองแดงเจือ","id"=>"3"),
                              array("name"=>"พี วี ซี","id"=>"4,14"),
                              array("name"=>"ยาง","id"=>"5"),
                              array("name"=>"เหล็กกล้าไร้สนิม","id"=>"9"),
                              array("name"=>"เหล็กหล่อ","id"=>"10"),
                              array("name"=>"เหล็กหล่อเหนียว","id"=>"11"),
                              array("name"=>"เหล็กเหนียว","id"=>"12"),
                              array("name"=>"เหล็กอาบสังกะสี","id"=>"13")                
                            );

          

            $html .= '<br><table style="width:100%">
                      <tr>
                        <td style="width:5%">&nbsp;</td>
                        <td style="width:90%">
                          <table border="1" style="width:100%">
                            <thead>
                              <tr>
                                <td style="width:70%;text-align:center;font-weight:bold;">ประเภทงาน</td>
                                <td style="width:15%;text-align:center;font-weight:bold;">ภายใน กปน.</td>
                                <td style="width:15%;text-align:center;font-weight:bold;">งานบริการ</td>
                              </tr>
                            </thead>
                             <tbody>';
                            
                            $date_start = $year."-".$month."-01"; 
                            $sum_int = 0;
                            $sum_ext = 0;   
                            foreach ($materials as $key => $mat) {
                         
                                $id = explode(",", $mat["id"]);
                               
                                if(count($id)==2)
                                  $condition = " AND (l.material_id=".$id[0]." OR l.material_id=".$id[1].")";  
                                else    
                                  $condition = " AND l.material_id=".$id[0];

                                
                                 //-----------งานภายใน------------------//
                                $sql = "SELECT l.material_id as id, sum(sampling_num) as sum,sum(rs.cost) as cost FROM request_standards rs LEFT JOIN requests r ON r.id=rs.request_id LEFT JOIN jobs j ON j.id=r.job_id LEFT JOIN labtypes l ON l.id=rs.labtype_id  WHERE job_group='งานภายใน กปน.' AND date BETWEEN '".$date_start."' AND '".$date_end."' ".$condition;
                                $result_req_in1 = Yii::app()->db->createCommand($sql)->queryAll();
                               

                                $sql = "SELECT l.material_id as id, sum(rt.sampling_num) as sum,sum(rt.cost) as cost FROM retests rt LEFT JOIN request_standards rs ON rs.id=rt.request_standard_id LEFT JOIN requests r ON r.id = rs.request_id LEFT JOIN jobs j ON j.id=r.job_id LEFT JOIN labtypes l ON l.id=rs.labtype_id WHERE job_group='งานภายใน กปน.' AND date BETWEEN '".$date_start."' AND '".$date_end."' ".$condition;
                                $result_req_in2 = Yii::app()->db->createCommand($sql)->queryAll();

                                //-----------งานภายนอก------------------//
                                $sql = "SELECT l.material_id as id, sum(sampling_num) as sum,sum(rs.cost) as cost FROM request_standards rs LEFT JOIN requests r ON r.id=rs.request_id LEFT JOIN jobs j ON j.id=r.job_id LEFT JOIN labtypes l ON l.id=rs.labtype_id  WHERE job_group='งานบริการ' AND date BETWEEN '".$date_start."' AND '".$date_end."' ".$condition;
                                $result_req_ex1 = Yii::app()->db->createCommand($sql)->queryAll();
                               

                                $sql = "SELECT l.material_id as id, sum(rt.sampling_num) as sum,sum(rt.cost) as cost FROM retests rt LEFT JOIN request_standards rs ON rs.id=rt.request_standard_id LEFT JOIN requests r ON r.id = rs.request_id LEFT JOIN jobs j ON j.id=r.job_id LEFT JOIN labtypes l ON l.id=rs.labtype_id WHERE job_group='งานบริการ' AND date BETWEEN '".$date_start."' AND '".$date_end."' ".$condition;
                                $result_req_ex2 = Yii::app()->db->createCommand($sql)->queryAll();

                                $sum_int +=  $result_req_in1[0]['sum']+$result_req_in2[0]['sum'];
                                $sum_ext +=  $result_req_ex1[0]['sum']+$result_req_ex2[0]['sum'];
                                 
                                  $html .= ' <tr>
                                                <td style="width:70%;text-align:left;">'.$mat["name"].'</td>
                                                <td style="width:15%;text-align:right;">'.number_format($result_req_in1[0]['sum']+$result_req_in2[0]['sum']).'</td>
                                                <td style="width:15%;text-align:right;">'.number_format($result_req_ex1[0]['sum']+$result_req_ex2[0]['sum']).'</td>
                                              </tr> ';          
                            }

                             
                            $html .= ' <tr>
                                                <td style="width:70%;text-align:center;">รวม</td>
                                                <td style="width:15%;text-align:right;">'.number_format($sum_int).'</td>
                                                <td style="width:15%;text-align:right;">'.number_format($sum_ext).'</td>
                                        </tr> ';       
                              
            $html .= '     </tbody>
                          </table>
                        </td>
                        <td style="width:5%">&nbsp;</td>
                      </tr>
                    </table>'; 
            $html .= '<div style="text-align:left;font-size:16;font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>หมายเหตุ</u>  จำนวนตัวอย่างรวมทั้งสิ้น  '.number_format($num_overall).'  ตัวอย่าง</div>';              

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
