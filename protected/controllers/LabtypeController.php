<?php

class LabtypeController extends Controller
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
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','template','getLabtypeByMaterial','getLabtypeInput','createHeader','createRaw','updateInput'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','deleteInput','deleteSelected'),
				'expression'=>'Yii::app()->user->isSuperUser()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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

	public function actionGetLabtypeByMaterial()
	{

		$material = isset($_POST['material']) ? $_POST['material'] : '';
 
        $data = Labtype::model()->findAll('material_id=:id', array(':id' => $material));        
               
        $data = CHtml::listData($data, 'id', 'name');
        
        echo CHtml::tag('option', array('value' => ''), CHtml::encode("กรุณาเลือกวิธีการทดสอบ"), true);
  
        foreach ($data as $value => $name) {            
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
	}

	public function actionGetLabtypeInput()
	{

		$labtype = isset($_POST['labtype']) ? $_POST['labtype'] : '';
 
        $data = LabtypeInput::model()->findAll('labtype_id=:id', array(':id' => $labtype));        
               
        $data = CHtml::listData($data, 'id', 'name');
        
       
  		echo CHtml::tag('option', array('value' => ''), CHtml::encode("กรุณาเลือกพารามิเตอร์"), true);
        foreach ($data as $value => $name) {            
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Labtype;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Labtype']))
		{
			$model->attributes=$_POST['Labtype'];
			if($model->save())
				 $this->redirect(array('index'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionCreateHeader()
	{
		$model = new LabtypeInput;


		if(isset($_POST['labtype']) && isset($_POST['name']) && isset($_POST['column']))
		{
			
			$formula = isset($_POST['formula'])? $_POST['formula'] : ''; 
			$model->type = 'header';
			$model->name = $_POST['name'];
			$model->col_index = $_POST['column'];
			$model->formula = $formula;
			$model->labtype_id = $_POST['labtype'];
			$model->self_header = $_POST['selfheader']=="true" ?1 : 0;
			$model->decimal_display = isset($_POST['decimal']) && !empty($_POST['decimal'])?$_POST['decimal'] : 0;

			

			$model->save();

			echo CActiveForm::validate($model);
		}

	
	}

	public function actionCreateRaw()
	{
		$model = new LabtypeInput;


		if(isset($_POST['labtype']) && isset($_POST['name']) && isset($_POST['column']))
		{
			
			$formula = isset($_POST['formula'])? $_POST['formula'] : ''; 
			$model->type = 'raw';
			$model->name = $_POST['name'];
			$model->col_index = $_POST['column'];
			$model->formula = $formula;
			$model->labtype_id = $_POST['labtype'];
			$model->self_header = $_POST['selfheader']=="true" ?1 : 0;
			$model->decimal_display = isset($_POST['decimal']) && !empty($_POST['decimal'])?$_POST['decimal'] : 0;

			$model->save();
			echo CActiveForm::validate($model);
		}

	
	}



	public function actionUpdateInput()
	{
		$es = new EditableSaver('LabtypeInput');
	
	    try {

	    	$es->update();
	  
	    } catch(CException $e) {
	    	echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
	    	return;
	    }
	    echo CJSON::encode(array('success' => true));
	}


	/*public function actionTemplate()
	{
		$model = new LabtypeInput;

		
		$this->render('template',array(
			'model'=>$model,
		));
	}*/

	public function actionTemplate($id)
	{
		$model = new LabtypeInput;

		
		$this->render('template',array(
			'model'=>$model,'id'=>$id
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

		if(isset($_POST['Labtype']))
		{
			$model->attributes=$_POST['Labtype'];
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
			$model=LabtypeInput::model()->findByPk($id);
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('template'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteInput($id)
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
		$model=new Labtype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Labtype']))
			$model->attributes=$_GET['Labtype'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Labtype('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Labtype']))
			$model->attributes=$_GET['Labtype'];

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
		$model=Labtype::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='labtype-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
