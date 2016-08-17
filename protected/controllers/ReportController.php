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

   


}

?>