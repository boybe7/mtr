
<style type="text/css">
.table-fixed thead {
  width: 100%;

}

.table-fixed tbody {
  height: 600px;
  overflow-y: auto;
  width: 100%;
}
.table-fixed thead, .table-fixed tbody, .table-fixed tr, .table-fixed td, .table-fixed th {
  display: block;
}
.table-fixed tbody td {
  float: left;
  border-bottom-width: 0;
  border-style: solid;
  border-width: thin;
  border-color: #e3e3e3;
  }

.table-fixed thead > tr> th {
  float: left;
  text-align: center;

  background-color: #f5f5f5;

}

</style>

<?php

function displayDate($date)
{
  $str = explode("-", $date);
  return $str[2]."/".$str[1]."/".$str[0];
}


$thai_mm=array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

$m_month=$thai_mm[(int)$month-1];
//.$thai_mm[(int)$m_m]

//echo"<h4>สรุปผลการดำเนินการประจำเดือน&nbsp;".$m_month."&nbsp;".($year+543)."</h4>";
//echo"<h4>ผลการดำเนินงานรายบุคคล"."</h4><br>";

 $date_start = $year."-".$month."-01"; 
 $date_end = $year."-".$month."-".cal_days_in_month(CAL_GREGORIAN,$month,$year);

$condition = "";
if($cat=="overdue")
{
    $condition = "  AND  bill_date IS NULL  ";
    echo"<center><h4>รายงานสรุปค้างชำระเงินค่าทดสอบประจำเดือน&nbsp;".$m_month."&nbsp;".($year+543)."</h4></center>";
}elseif ($cat=="paid") {
     $condition = "  AND  bill_date IS NOT NULL  ";
    echo"<center><h4>รายงานสรุปชำระเงินค่าทดสอบประจำเดือน&nbsp;".$m_month."&nbsp;".($year+543)."</h4></center>";
}  
else{
    echo"<center><h4>รายงานสรุปสถานะการชำระเงินค่าทดสอบประจำเดือน&nbsp;".$m_month."&nbsp;".($year+543)."</h4></center>";
}
$sql = "SELECT * FROM requests rq LEFT JOIN invoices i ON rq.id=i.request_id  WHERE  rq.date BETWEEN '".$date_start."' AND '".$date_end."' ".$condition;
$result = Yii::app()->db->createCommand($sql)->queryAll();

?>

  <table class="table  table-bordered table-condensed" >
     <thead>
      <tr>
        <th style="text-align:center;width:5%">ลำดับ</th>
        <th style="text-align:center;width:15%">เลขที่ใบแจ้งชำระเงิน</th>
        <th style="text-align:center;width:30%">เจ้าของตัวอย่าง</th>
        <th style="text-align:center;width:15%">วันที่รับตัวอย่าง</th>
        <th style="text-align:center;width:15%">จำนวนเงิน</th>
        <th style="text-align:center;width:25%">เลขที่ชำระ/วันที่ชำระ</th>
       
      </tr>
    </thead>
    <tbody>
          <?php
                 $i = 1;
                 $sum_cost = 0;
                 foreach ($result as $key => $value) {
                   echo '<tr>';
                      echo '<td style="text-align:center;">'.$i.'</td>';
                      echo '<td style="text-align:center;">'.$value['invoice_no'].'</td>';
                      echo '<td>'.Vendor::model()->findByPk($value['owner_id'])->name.'</td>';
                      echo '<td style="text-align:center;">'.displayDate($value['date']).'</td>';
                      echo '<td style="text-align:right;">'.number_format($value['cost'],2).'</td>';
                      $sum_cost += $value['cost'];
                      if(empty($value['bill_date']))
                         echo '<td style="text-align:center;">-</td>';
                      else
                         echo '<td style="text-align:center;">'.$value['bill_no'].'<br>'.displayDate($value['bill_date']).'</td>';
                   echo '</tr>';

                   $i++;
                 }

                echo '<tr>';
                      echo '<td colspan="4" style="text-align:center;font-weight:bold"> รวม </td>';
                      echo '<td style="text-align:right;font-weight:bold">'.number_format($sum_cost,2).'</td>';
                      echo '<td style="text-align:center;"></td>';
                 echo '</tr>';


            ?>


    </tbody>
  </table>



