
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




$thai_mm=array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");

$m_month=$thai_mm[(int)$month-1];
//.$thai_mm[(int)$m_m]

//echo"<h4>สรุปผลการดำเนินการประจำเดือน&nbsp;".$m_month."&nbsp;".($year+543)."</h4>";
//echo"<h4>ผลการดำเนินงานรายบุคคล"."</h4><br>";

$date_m = $year."-".$month;

//$models=CerDoc::model()->findAll(array("condition"=>"cer_date BETWEEN '$date_start' AND '$date_end'  "));
// $models = Yii::app()->db->createCommand()
//                     ->select("count(cer_no) as sum,cer_name,SUM(workDay(TOTAL_WEEKDAYS(CONCAT( DATE_FORMAT( cer_date,  '%Y' ),  '-', DATE_FORMAT( cer_date,  '%m-%d' ) ) , CONCAT( DATE_FORMAT( cer_oper_date,  '%Y' ),  '-', DATE_FORMAT( cer_oper_date,  '%m-%d' ) ) ))) as date_oper")
//                     ->from('c_cer_doc cd')
//                     //->join('c_cer_detail ct', 'cd.cer_id=ct.cer_id')
//                     ->where('cer_date like "'.$date_m.'%"')
//           ->group('cer_name')
//                     ->queryAll();
//print_r($models);

?>

  <table class="table" border=1>
     <thead>
      <tr>
        <th style="text-align:center;width:5%">ลำดับ</th>
        <th style="text-align:center;width:15%">เลขที่อันดับการทดสอบ</th>
        <th style="text-align:center;width:35%">เจ้าของตัวอย่าง</th>
        <th style="text-align:center;width:15%">วันที่รับตัวอย่าง</th>
        <th style="text-align:center">จำนวนเงิน</th>
        <?php  //echo '<th style="text-align:center">จำนวนเงิน</th>'; ?>
      </tr>
    </thead>
    <tbody>
          <?php
                  // $sumAll=0;
                  // $dateAll = 0;
                  // foreach ($models as $key => $model) {
                  //     echo "<tr>";
                  //       echo '<td style="">'.$model["cer_name"].'</td><td style="text-align:center;">'.$model["sum"].'</td><td style="text-align:center;">'.$model["date_oper"].'</td><td style="text-align:center;">'.number_format($model["date_oper"]/$model["sum"],2).'</td>';
                  //     echo "</tr>";
                  //     $sumAll=$sumAll+$model["sum"];
                  //     $dateAll=$dateAll+$model["date_oper"];
                  // }
                  // echo "<tr style='font-weight:bold'>";
                  //       echo '<td style="text-align:center;">รวม</td><td style="text-align:center;">'.$sumAll.'</td><td style="text-align:center;">'.$dateAll.'</td><td style="text-align:center;">'.number_format($dateAll/$sumAll,2).'</td>';
                  // echo "</tr>";

            ?>


    </tbody>
  </table>



