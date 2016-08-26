<?php


class ReportController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $layout='//layouts/column2';

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
  
    public function actionMonthlyReport()
	{
		

		$this->render('_reportMonthly');
	}

	public function actionGenMonthlyReport()
	{
        $month = $_GET["monthEnd"];
        $year = $_GET["yearEnd"]-543;
       
		$this->renderPartial('_formReportMonthly', array(
           
            'month'=>$month,
            'year'=>$year,
           
            'display' => 'block',
        ), false, true);
	}
        
    public function actionPrintMonthlyReport()
    {
	    $month = $_GET["monthEnd"];
        $year  = $_GET["yearEnd"]-543;

		$this->renderPartial('_formReportMonthly_PDF', array(

            'month'=>$month,
            'year'=>$year,

            'display' => 'block',
        ), false, true);


   }

    public function actionPaymentReport()
	{
		

		$this->render('_reportPayment');
	}

	public function actionGenPaymentReport()
	{
        $month = $_GET["monthEnd"];
        $year = $_GET["yearEnd"]-543;
         $cat = "all";
        if(isset($_GET["cat1"]) && !isset($_GET["cat2"]))
           $cat = $_GET["cat1"];
        elseif (isset($_GET["cat2"]) && !isset($_GET["cat1"]))
            $cat = $_GET["cat2"];


		
		$this->renderPartial('_formReportPayment', array(
           
            'month'=>$month,
            'year'=>$year,
             'cat'=>$cat,
            'display' => 'block',
        ), false, true);
	}
        
    public function actionPrintPaymentReport()
    {
	    $month = $_GET["monthEnd"];
        $year  = $_GET["yearEnd"]-543;
          $cat = "all";
        if(isset($_GET["cat1"]) && !isset($_GET["cat2"]))
           $cat = $_GET["cat1"];
        elseif (isset($_GET["cat2"]) && !isset($_GET["cat1"]))
            $cat = $_GET["cat2"];



		$this->renderPartial('_formReportPayment_PDF', array(

            'month'=>$month,
            'year'=>$year,
            'cat'=>$cat,
            'display' => 'block',
        ), false, true);


   }

   


}

?>