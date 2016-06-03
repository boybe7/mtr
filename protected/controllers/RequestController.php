<?php

class RequestController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','deleteSelected'),
				'expression'=>'Yii::app()->user->isSuperUser()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function gentRequstNo()
	{
			//auto gen running_no
			 $fiscalyear = date("Y")+543;//date("n")<10 ? date("Y")+543 : date("Y")+544;
			 $m = Yii::app()->db->createCommand()
	                    ->select('max(strSplit(request_no,"/", 1)) as max')
	                    ->from('requests') 
	                    ->where('strSplit(request_no,"/", 2)='.$fiscalyear)                                    
	                    ->queryAll();

			

			if(empty($m[0]['max']))
            {
                
                $runNo = "1/".$fiscalyear;  
            }
            else
            {
               
                $num = intval($m[0]['max'])+1;
               /* if(strlen($num)==4)
                    $num = "0".$num;
                else if(strlen($num)==3)
                    $num = "00".$num;
                else if(strlen($num)==2)
                    $num = "000".$num;
                else if(strlen($num)==1)
                    $num = "0000".$num;*/

                $runNo = $num."/".$fiscalyear;
            }


            return $runNo;               
            				
	}


	public function getMaterial($data,$row)
	{
		
				$models=RequestStandard::model()->findAll('request_id=:id', array(':id' => $data->id));   
                
                $mat = "";
                foreach ($models as $key => $m) {
                	$labtype = Labtype::model()->findByPk($m->labtype_id);
                	
                	if(!empty($labtype))
                		$mat .= Material::model()->findByPk($labtype->material_id)->name."<hr>";
                }

                $mat = substr($mat, 0,strlen($mat)-4);
			   

				return $mat;
	}

	

	public function getLot($data,$row)
	{
		
				$models=RequestStandard::model()->findAll('request_id=:id', array(':id' => $data->id));   
                
                $lot = "";
                foreach ($models as $key => $m) {
                	
                	$lot .= $m->lot_no."<hr>";
                }

                $lot = substr($lot, 0,strlen($lot)-4);
			   

				return $lot;
	}

	public function getSampling($data,$row)
	{
		
				$models=RequestStandard::model()->findAll('request_id=:id', array(':id' => $data->id));   
                
                $lot = "";
                foreach ($models as $key => $m) {
                	
                	$lot .= $m->sampling_no."<hr>";
                }

                $lot = substr($lot, 0,strlen($lot)-4);
			   

				return $lot;
	}




	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Request;
		$modelReqSD = new RequestStandard;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->request_no = $this->gentRequstNo();

		$model->date = date("d")."/".date("m")."/".(date("Y")+543);//"11/07/2526";
      

		if(isset($_POST['Request']))
		{
			$model->attributes=$_POST['Request'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,'modelReqSD'=>$modelReqSD
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Request']))
		{
			$model->attributes=$_POST['Request'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteSelected()
    {
    	$autoIdAll = $_POST['selectedID'];
        if(count($autoIdAll)>0)
        {
            foreach($autoIdAll as $autoId)
            {
                $this->loadModel($autoId)->delete();
            }
        }    
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Request('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Request']))
			$model->attributes=$_GET['Request'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Request('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Request']))
			$model->attributes=$_GET['Request'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Request::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='request-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
