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
				'actions'=>array('create','update','gentSamplingNo'),
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

	public function actionGentSamplingNo()
	{
		   
		   if(isset($_POST["material"]))
		   {
		   	    $modelMaterial = Material::model()->findByPk($_POST["material"]); 

		   	    $mLabtype = Labtype::model()->findByPk($_POST["labtype"]);
		   	    $sampling_code = (!empty($mLabtype) && $mLabtype->is_chemical_test==1) ? 'C' : $modelMaterial->code;


		   	    if(!empty($modelMaterial))
		   	    {
		   	    	
		   	    	$no = $_POST["index"];
		   	    	$amount = $_POST["sampling_num"];

		   	    	$m2 = Yii::app()->db->createCommand()
	                    ->select('max(sampling_no) as max')
	                    ->from('temp_sampling_no') 
	                    ->where('sampling_no LIKE "%'.$sampling_code.'%" AND id<'.$no)                                    
	                    ->queryAll();

	                $return = array();    

	                if($m2[0]["max"]!=null)
	                {
	               		
	               		$mm = TempSamplingNo::model()->findByPk($no);
	               		$r = explode("-", $m2[0]["max"]);
			            $codemax = $r[1];
			            $max_no = intval($codemax) + $amount;
	               		
	               		if(empty($mm))
	               		{
	               						
			                    		$mm2 = new TempSamplingNo;
			                    		$mm2->id = $no;
			                    		$mm2->num = $amount;
			                    		$mm2->sampling_no = $sampling_code."-".($max_no);
				                    	$mm2->save();

				                    	if($amount==1)
				                    		 $output = array('index' =>$no,'value'=>$sampling_code.($codemax+1));
				                    	else	
				                    	    $output = array('index' =>$no,'value'=>$sampling_code.($codemax+1)."-".$sampling_code.($max_no));
				                    	$return[] = $output; 
	               		}
	               		else{

	               			$mm->sampling_no = 	$sampling_code."-".($max_no);
	               			$mm->num = $amount;
	               			$mm->save();
	               			if($amount==1)
				                $output = array('index' =>$no,'value'=>$sampling_code.($codemax+1));
				            else
	               				$output = array('index' =>$no,'value'=>$sampling_code.($codemax+1)."-".$sampling_code.($max_no));
				            
				            $return[] = $output;

	               		}




	                }    
	                else //empty
	                {

	                	$m = Yii::app()->db->createCommand()
		                    ->select('max(sampling_no_fix) as max')
		                    ->from('test_results_values') 
		                    ->where('sampling_no LIKE "%'.$sampling_code.'%"')                                    
		                    ->queryAll();

		                $num =  explode("-", $m[0]["max"]);     
		                $max_no = ($m[0]["max"]==null) ? 0 : intval($num[1]) ;

		                $model = TempSamplingNo::model()->findByPk($no);
		                if(empty($model))
		                {
		                	$model = new TempSamplingNo;
	                        $model->sampling_no = $sampling_code."-".($max_no+$_POST["sampling_num"]);
	                        $model->id = $no;
	                        $model->num = $amount;
	                        $model->save();
		                }
		                else{
		                	$model->sampling_no = $sampling_code."-".($max_no+$_POST["sampling_num"]);
	                        $model->id = $no;
	                        $model->num = $amount;
	                        $model->save();
		                }
			               
	              		if($amount==1)
				            $output = array('index' =>$no,'value'=>$sampling_code.($max_no+1));
				        else
	                		$output = array('index' =>$no , 'value'=>$sampling_code.($max_no+1)."-".$sampling_code.($max_no+$_POST["sampling_num"]));
			            $return[] = $output; 

			            
					
	                }


	                //update temp
	                $models =  TempSamplingNo::model()->findAll(array("condition"=>"id > ".$no,"order"=>"id"));
			                 //print_r($models);
			                 foreach ($models as $key => $m) {
			                 	
			                 		  $mcode = explode("-", $m->sampling_no);
			                 		  $mcode[0] = (!empty($mLabtype) && $mLabtype->is_chemical_test==1) ? 'C' : $mcode[0];
			                 		  //if($mcode[0]!=$code)
			                 		  //{
			                 		  	$m3 = Yii::app()->db->createCommand()
							                    ->select('max(sampling_no) as max')
							                    ->from('temp_sampling_no') 
							                    ->where('sampling_no LIKE "%'.$mcode[0].'%" AND id<'.$m->id)                                    
							                    ->queryAll();
										$str = explode("-", $m3[0]["max"]);        
							            $max = empty($str) ? 0 : intval($str[1]);

			                    		$m->sampling_no = $mcode[0]."-".($max+ $m->num);
				                    	$m->save();
				                    	if($m->num==1)
								            $output = array('index' =>$no,'value'=>$sampling_code.(intval($max)+1));
								        else
				                    		$output = array('index' =>$m->id ,'value'=>$mcode[0].(intval($max)+1)."-".$mcode[0].($max + $m->num));
			                 			$return[] = $output;    
 	
			                 }
					//end update temp	                

	                echo json_encode($return);
			
		   	    }
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

	public function get_numerics ($str) {
	    $matches = preg_replace("/[^0-9]/", '', $str);
	    return $matches;
	}

	public function get_string($str)
	{
		 $matches = preg_replace("/[^A-Z]/", '', $str);
    	 return ($matches);
	}


	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Request;
		$modelReqSD1 = new RequestStandard;
		$modelReqSD2 = new RequestStandard;
		$modelReqSD3 = new RequestStandard;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$model->request_no = $this->gentRequstNo();

		$model->date = date("d")."/".date("m")."/".(date("Y")+543);//"11/07/2526";
      

		if(isset($_POST['Request']))
		{
			$model->attributes=$_POST['Request'];
			$num_sample = $_POST["num_sample"];

			$i=1;
			foreach ($_POST['RequestStandard'] as $key => $mr) 
			{
				switch ($i) {
					case 1:
						$modelReqSD1->attributes = $mr;
						break;
					case 2:
						$modelReqSD2->attributes = $mr;
						break;
					case 3:
						$modelReqSD3->attributes = $mr;
						break;		
					
					default:
						$modelReqSD1->attributes = $mr;
						break;
				}
				   
				$i++;
			}	

			//header('Content-type: text/plain');
			//print_r($modelReqSD1);
			//exit;

			$saveOK = true;
            $transaction=Yii::app()->db->beginTransaction();
		    try {

		    	if($model->save())
				{
					$modelRequests = $_POST['RequestStandard'];    


					
					//header('Content-type: text/plain');
					$i = 0;
					foreach ($modelRequests as $key => $attributes) {
						
              		  if($i<$num_sample)	
              		  {
              		  	  $mr = new RequestStandard;
              		  	  $mr->attributes = $attributes;
              		  	  $mr->request_id = $model->id;
              		  	  if($mr->save())
              		  	  {
              		  	  	  //get lot_no
              		  	  	  $modelInputs = LabtypeInput::model()->findAll( array("condition"=>"labtype_id=".$mr->labtype_id));
              		  	  	  $lots = explode(",", $mr->lot_no);
              		  	  	  $sample_per_lot = $mr->sampling_num / $mr->lot_num;

              		  	  	  //get id of specimen mark
              		  	  	  $m3 = Yii::app()->db->createCommand()
							                    ->select('min(id) as min')
							                    ->from('labtype_inputs') 
							                    ->where('type="header" AND labtype_id='.$mr->labtype_id)                             
							                    ->queryAll();
							   $minID = $m3[0]["min"];        

							  //get id of remark
							   $m3 = Yii::app()->db->createCommand()
							                    ->select('max(id) as max')
							                    ->from('labtype_inputs') 
							                    ->where('type="header" AND labtype_id='.$mr->labtype_id)                             
							                    ->queryAll();
							   $maxID = $m3[0]["max"];  


              		  	  	  $samplings = explode("-", $mr->sampling_no);
              		  	  	  $no_start = $this->get_numerics($samplings[0]);
              		  	  	  $code = $this->get_string($samplings[0]);
            

              		  	  	  foreach ($lots as $key => $lot) {
              		  	  	  	  if($lot!="")
              		  	  	  	  {
              		  	  	  	  	  for ($j=0; $j < $sample_per_lot ; $j++) { 
              		  	  	  	  	  	

              		  	  	  	  	  	 foreach ($modelInputs as $key => $input) {
              		  	  	  	  	  	 	 $modelResult = new TestResultsValue;
	              		  	  	  	  	  	 $modelResult->lot_no = $lot;
	              		  	  	  	  	  	 $modelResult->sampling_no = $code."-".($no_start);
	              		  	  	  	  	  	 $modelResult->sampling_no_fix = $code."-".($no_start);
	              		  	  	  	  	  	 $modelResult->request_standard_id = $mr->id;
	              		  	  	  	  	  	 $modelResult->labtype_input_id = $input->id;
	              		  	  	  	  	  	 $modelResult->value = "0";

	              		  	  	  	  	  	 if($input->id==$minID)
	              		  	  	  	  	  	 	$modelResult->value = $code."-".($no_start);

	              		  	  	  	  	  	 if($input->id==$maxID)
	              		  	  	  	  	  	 	$modelResult->value = $lot;

	              		  	  	  	  	  	 


	              		  	  	  	  	  	 if(!$modelResult->save())
	              		  	  	  	  	  	 	$saveOK = false;

	  //             		  	  	  	  	  	   		          	  	  header('Content-type: text/plain');
			// print_r($modelResult);
			// exit;


              		  	  	  	  	  	 }

              		  	  	  	  	  	  $no_start++;

              		  	  	  	  	  }
              		  	  	  	  }

              		  	  	  }



              		  	  }
              		  	  else{
              		  	  	$saveOK = false;
              		  	  }
              		  }
					   $i++;	
					}


					//exit;
					if($saveOK)
					{	
				     	$transaction->commit();
				     	$this->redirect(array('index'));	

				    } 	
				}

				 


		    }
		    catch(Exception $e)
	 		{
	 				$transaction->rollBack();	
	 				$model->addError('request', 'Error occured while saving requests.');
	 				Yii::trace(CVarDumper::dumpAsString($e->getMessage()));
	 	        	//you should do sth with this exception (at least log it or show on page)
	 	        	Yii::log( 'Exception when saving data: ' . $e->getMessage(), CLogger::LEVEL_ERROR );
	 
	 		}                         


			
		}


		//clear temp table
		Yii::app()->db->createCommand('DELETE FROM temp_sampling_no')->execute();

		$this->render('create',array(
			'model'=>$model,'modelReqSD1'=>$modelReqSD1,'modelReqSD2'=>$modelReqSD2,'modelReqSD3'=>$modelReqSD3
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

                //delete related in request_standards and test_result_values
                $modelRequestSDs = RequestStandard::model()->findAll( array("condition"=>"request_id=".$autoId));
                foreach ($modelRequestSDs as $key => $m) {

                	Yii::app()->db->createCommand('DELETE FROM test_results_values WHERE request_standard_id='.$m->id)->execute();
                	$m->delete();
                }
                 
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
