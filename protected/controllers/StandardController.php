<?php

class StandardController extends Controller
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
				'actions'=>array('index','view','GetStandardByLabtype','getCost'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','createParameter'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','deleteStandard','deleteSelected'),
				'expression'=>'Yii::app()->user->isSuperUser()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	
	public function actionGetCost()
	{
		$labtype = isset($_POST['labtype']) ? $_POST['labtype'] : '';
		$sampling = isset($_POST['sampling']) ? $_POST['sampling'] : 0;
		$modelLabtype = Labtype::model()->findByPk($labtype);
		$cost = !empty($modelLabtype) ? $modelLabtype->cost * $sampling : 0;

		echo number_format($cost,0);
	}


	public function actionGetStandardByLabtype()
	{

		$labtype = isset($_POST['labtype']) ? $_POST['labtype'] : '';

		$modelLabtype = Labtype::model()->findByPk($labtype);

		$material = !empty($modelLabtype) ? $modelLabtype->material_id : 0;
     

	    $sql = 'SELECT s.id,s.name FROM standards s LEFT JOIN standard_parameters sp ON sp.standard_id=s.id LEFT JOIN labtype_inputs lb ON lb.id=sp.labtype_input_id WHERE labtype_id='.$labtype.' AND material_id='.$material;	
	    $data = Yii::app()->db->createCommand($sql)->queryAll();

        $data = CHtml::listData($data, 'id', 'name');
        
        echo CHtml::tag('option', array('value' => ''), CHtml::encode("กรุณาเลือกมาตรฐานการทดสอบ"), true);
  
        foreach ($data as $value => $name) {            
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
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
		$model=new Standard;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Standard']))
		{
			$model->attributes=$_POST['Standard'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCreateParameter()
	{
		$model = new StandardParameter;


		if(isset($_POST['parameter']) && isset($_POST['standard']))
		{
			
			//get type
			$modelParam = LabtypeInput::model()->findByPk($_POST['parameter']);

			if($modelParam->type == 'header' &&  $_POST['value']=='')
			{
				echo ("ค่าพารามิเตอร์ไม่ควรว่าง");	
			}
			else{
				$value = isset($_POST['value']) ? $_POST['value'] : '';
			
				$model->value = $value;
				$model->labtype_input_id = $_POST['parameter'];
				$model->standard_id = $_POST['standard'];

				//echo CActiveForm::validate($model);
				//var_dump($model);

				$model->save();
			}

		
		}

	
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

		if(isset($_POST['Standard']))
		{
			$model->attributes=$_POST['Standard'];
			if($model->save())
				$this->redirect(array('index'));
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
			//$this->loadModel($id)->delete();

			$model=StandardParameter::model()->findByPk($id);
			$model->delete();


			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('update'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteStandard($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();


			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
                
                $models=StandardParameter::model()->findAll('standard_id=:id', array(':id' => $autoId));   
                foreach ($models as $key => $m) {
                	 $m->delete();
                }
			   

                $this->loadModel($autoId)->delete();
            }
        }    
    }


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Standard('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Standard']))
			$model->attributes=$_GET['Standard'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Standard('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Standard']))
			$model->attributes=$_GET['Standard'];

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
		$model=Standard::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='standard-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
