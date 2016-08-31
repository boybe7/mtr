<?php
function avg()
	{
		return $result = array_sum(func_get_args())/count(func_get_args());
	}
	
class RequestStandardController extends Controller
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
				'actions'=>array('admin','delete','index', 'addRaw'),
				'expression'=>'Yii::app()->user->isSuperUser()',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex($id){
		$connection = Yii::app()->db;
		$output = array();

		// Save Data
		if(isset($_POST['result_header'])){
			$result_header = $_POST['result_header'];
			$result_header_id = $result_header['result_header_id'];
			$model = TestResultsHeaders::model()->findByPk($result_header_id);
			if($model){
				$model->test_date = $result_header['test_date'];
				$model->tester_1 = $result_header['tester_1'];
				$model->tester_2 = $result_header['tester_2'];
				$model->approver = $result_header['approver'];
				$model->reporter = $result_header['reporter'];
				$model->signer = $result_header['signer'];
				$model->signed_date = $result_header['signed_date'];
				$model->comment = $result_header['comment'];
				$model->save(); // save the change to database
			}
		}

		$upload = false; // manual input ok
		if(isset($_FILES['rawupload'])){
			//echo "<br/><br/><br/><br/>";
			foreach ($_FILES['rawupload']['size'] as $reqstd_id => $size) {
				if($size > 0){
					$upload = true; // prevent manual input
					$name = $_FILES['rawupload']['name'][$reqstd_id];
					$type = $_FILES['rawupload']['type'][$reqstd_id];
					$tmp_name = $_FILES['rawupload']['tmp_name'][$reqstd_id];
					
					// CSV mimetypes
					$csv_mimetypes = array(
						'text/csv',
						'application/csv',
						'text/comma-separated-values',
						'application/excel',
						'application/vnd.ms-excel',
						'application/vnd.msexcel',
						//'text/plain',
						//'text/anytext',
						//'application/octet-stream',
						//'application/txt',
					);

					// CSV type checking
					if(in_array($type, $csv_mimetypes)){
						$row = 1;
						if (($handle = fopen($tmp_name, "r")) !== FALSE) {
							while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
								if($row >= 4){ // Begin extracting at row 4
									$rowno = $data[0];
									if($rowno){
										$sampling_no = $data[1];
										
										// Values to update!
										$values = array();
										$values['C'] = $data[2];
										$values['D'] = $data[3];
										$values['E'] = $data[4];
										$values['F'] = $data[5];
										$values['G'] = $data[6];
										$values['H'] = $data[7];
										$values['I'] = $data[8];
										$values['J'] = $data[9];

										foreach($values as $col_index => $value){
											//echo "$reqstd_id | $sampling_no | $col_index | $value<br/>";
											$sql = "SELECT test_results_values.id as id FROM test_results_values JOIN labtype_inputs ON test_results_values.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$reqstd_id' AND sampling_no='$sampling_no' AND labtype_inputs.col_index='$col_index'";
											//echo $sql . "<br/>";
											$result = $connection->createCommand($sql)->queryRow();
											if($result > 0){
												$result_id = $result['id'];
												$model = TestResultsValue::model()->findByPk($result_id);
												$model->value = str_replace(",", "", $value) ;
												$model->save(); // save the change to database
											}
										}
									}
								}
								$row++;
							}
							fclose($handle);
						}
					}
				}
			}
			//exit;
		} 
		
		if(isset($_POST['result']) && $upload == false){
			foreach ($_POST['result'] as $result_id => $value) {
				$model = TestResultsValue::model()->findByPk($result_id);
				$model->value = $value;
				$model->save(); // save the change to database
			}
		}

		if(isset($_POST['reqstd'])){
			foreach ($_POST['reqstd'] as $reqstd_id => $conclude) {
				$model = RequestStandard::model()->findByPk($reqstd_id);
				$model->conclude = $conclude;
				$model->save(); // save the change to database

				$this->calculate($reqstd_id);
			}

			//if (Yii::app()->request->isAjaxRequest)	
			//	$this->redirect(array('requestStandard/index/'.$id));
			//else	
			$this->redirect(array('request/index'));	
		}

		// Request query
		$request = Request::model()->findByPk($id);
		$output['request'] = array(
			'request_id' => $request->id,
			'request_no' => $request->request_no,
			'job_name' => $request->job? $request->job->name: '-',
			'owner_name' => $request->owner? $request->owner->name: '-',
			'vendor_name' => $request->vendor? $request->vendor->name: '-',
		);

		// ResultHeader relates
		$result_headers = $request->result_headers;
		if(count($result_headers) > 0){
			$result_header = $result_headers[0]; // Fetch 1 record
			$output['result_header'] = array(
				'result_header_id' => $result_header->id,
				'test_date' => $result_header->test_date!='0000-00-00'? $result_header->test_date: date('d/m/') . (date('Y') + 543),
				'tester_1' => $result_header->tester_1,
				'tester_2' => $result_header->tester_2,
				'approver' => $result_header->approver,
				'reporter' => $result_header->reporter,
				'signer' => $result_header->signer,
				'signed_date' => $result_header->signed_date!='0000-00-00'? $result_header->signed_date: date('d/m/') . (date('Y') + 543),
				'comment' => $result_header->comment
			);
		}else{
			$output['result_header'] = array(
				'result_header_id' => '',
				'test_date' => date('d/m/') . (date('Y') + 543),
				'tester_1' => '',
				'tester_2' => '',
				'approver' => '',
				'reporter' => '',
				'signer' => '',
				'signed_date' => date('d/m/') . (date('Y') + 543),
				'comment' => ''
			);
		}

		// RequestStandard query
		$request_standard = $request->req_std;
		$output['request_standard'] = array();
		foreach ($request_standard as $row) {
			$reqstd_id = $row->id;
			$labtype_id = $row->labtype_id;
			$labtype_name = $row->labtype->name;
			$material_name = $row->labtype->material->name;
			$standard_name = $row->standard->name;
			$standard_id = $row->standard->id;
			$conclude = $row->conclude;

			// Header list			
			$sql = "SELECT id, name,decimal_display FROM labtype_inputs WHERE labtype_id='$labtype_id' AND type='header' ORDER BY col_index";
			$header_list = $connection->createCommand($sql)->queryAll();

			// Sample list
			$sql = "SELECT sampling_no FROM test_results_values WHERE request_standard_id='$reqstd_id' GROUP BY sampling_no ORDER BY lot_no,strSplit(sampling_no_fix,'-', 2)*1,id";
			$sample_list = $connection->createCommand($sql)->queryAll();

			// Result list
			$sql = "SELECT sampling_no, labtype_input_id, test_results_values.id, value,decimal_display  FROM test_results_values JOIN labtype_inputs ON test_results_values.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$reqstd_id' AND type='header'";
			$result = $connection->createCommand($sql)->queryAll();
			$result_list = array();
			foreach ($result as $row) {
				$sampling_no = $row['sampling_no'];
				$labtype_input_id = $row['labtype_input_id'];
				$result_list[$sampling_no][$labtype_input_id] = array(
					'id' => $row['id'], 
					'value' => $row['value'],
					'decimal'=>$row['decimal_display']
				);
			}

			// Set view data
			$output['request_standard'][] = array(
				'reqstd_id' => $reqstd_id,
				'labtype_id' => $labtype_id,
				'labtype_name' => $labtype_name,
				'material_name' => $material_name,
				'standard_name' => $standard_name,
				'standard_id' => $standard_id,
				'conclude' => $conclude,
				'header_list' => $header_list,
				'sample_list' => $sample_list,
				'result_list' => $result_list
			);
		}

		// Render view
		$this->render('index', array('output' => $output,'id'=>$id));
	}

	public function calculate($id)
	{
		    $connection = Yii::app()->db;

		 

			//----update result with formula cal------------------//
			//1.get sampling_no
			$sampling_no = Yii::app()->db->createCommand()
			                    ->select('sampling_no')
			                    ->from('test_results_values') 
			                    ->where('request_standard_id="'.$id.'"') 
			                    ->group('sampling_no')                                   
			                    ->queryAll();

			//print_r($sampling_no);    
			foreach ($sampling_no as $key => $no) {
				$sample = $no["sampling_no"];

				//raw
				/*$sql = "SELECT test_results_values.id as id, formula, value,col_index,sampling_no  FROM test_results_values JOIN labtype_inputs ON test_results_values	.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$id' AND type='raw' AND sampling_no='$sample' ";
					
				$results = $connection->createCommand($sql)->queryAll();
				foreach ($results as $key => $rs) {
					$col = $rs["col_index"];
					eval('$'.$col.' = '.$rs["value"].';');
				}*/


				//header
				$sql = "SELECT test_results_values.id as id, formula,type, value,col_index,sampling_no  FROM test_results_values JOIN labtype_inputs ON test_results_values	.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$id' AND sampling_no='$sample' AND self_header	=0 ORDER BY type DESC, col_index DESC";
				$results = $connection->createCommand($sql)->queryAll();
				foreach ($results as $key => $rs) {
					$col = $rs["col_index"];

					//print_r($rs);
					if($rs['formula']!="")
					{
						$value = 0;
						try{
							eval('$value = @('.$rs['formula'].');');	
						}catch(Exception $e){

						}
						
					
						$model = TestResultsValue::model()->findByPk($rs['id']);
						$model->value = $value;
						$model->save(); // save the change to database

						//print_r($model);

					}
					else{
					
						if(is_numeric($rs['value']))
						{
						
						  eval('$'.$col.' = '.$rs['value'].';');
						}
						
					}
				}

				
				//calculate self header
				$sql = "SELECT test_results_values.id as id, formula,type, value,col_index,sampling_no,self_header  FROM test_results_values JOIN labtype_inputs ON test_results_values	.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$id' AND sampling_no='$sample'  ORDER BY type DESC,id ASC";
				$results = $connection->createCommand($sql)->queryAll();
				foreach ($results as $key => $rs) {
					$col = $rs["col_index"];

					//print_r($rs);
					if($rs['formula']!="" && $rs['self_header']==1)
					{
					    $value = 0;
						try{
							eval('$value = @('.$rs['formula'].');');	
						}catch(Exception $e){

						}
						eval('$'.$col.' = '.$value .';');

						$model = TestResultsValue::model()->findByPk($rs['id']);
						$model->value = $value;
						$model->save(); // save the change to database

						//print_r($model);

					}
					else{
					
						if(is_numeric($rs['value']))
						{
						
						  eval('$'.$col.' = '.$rs['value'].';');
						  //echo $col;
						}
						
					}
				}

			   //print_r($results);
			   //echo $no["sampling_no"];    
			}                
	}

	public function actionAddRaw($id){
		$connection = Yii::app()->db;
		$output = array();

		// Ajax Post
		header('Content-type: text/plain');
		if(isset($_POST['result'])){
			$result = $_POST['result'];


			foreach($result as $result_id => $value) {
				$model = TestResultsValue::model()->findByPk($result_id);
				$model->value = $value;
				$model->save(); // save the change to database

			

			}

			//echo $N;
		
			// function avg()
			// {
			//     return $result = array_sum(func_get_args())/count(func_get_args());
			// }
		

			//----update result with formula cal------------------//
			//1.get sampling_no
			$sampling_no = Yii::app()->db->createCommand()
			                    ->select('sampling_no')
			                    ->from('test_results_values') 
			                    ->where('request_standard_id="'.$id.'"') 
			                    ->group('sampling_no')                                   
			                    ->queryAll();

			//print_r($sampling_no);    
			foreach ($sampling_no as $key => $no) {
				$sample = $no["sampling_no"];

				//raw
				/*$sql = "SELECT test_results_values.id as id, formula, value,col_index,sampling_no  FROM test_results_values JOIN labtype_inputs ON test_results_values	.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$id' AND type='raw' AND sampling_no='$sample' ";
					
				$results = $connection->createCommand($sql)->queryAll();
				foreach ($results as $key => $rs) {
					$col = $rs["col_index"];
					eval('$'.$col.' = '.$rs["value"].';');
				}*/


				//header
				$sql = "SELECT test_results_values.id as id, formula,type, value,col_index,sampling_no  FROM test_results_values JOIN labtype_inputs ON test_results_values	.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$id' AND sampling_no='$sample' AND self_header	=0 ORDER BY type DESC, col_index DESC";
				$results = $connection->createCommand($sql)->queryAll();
				foreach ($results as $key => $rs) {
					$col = $rs["col_index"];

					//print_r($rs);
					if($rs['formula']!="")
					{
						eval('$value = '.$rs['formula'].';');

					
						$model = TestResultsValue::model()->findByPk($rs['id']);
						$model->value = $value;
						$model->save(); // save the change to database

						//print_r($model);

					}
					else{
					
						if(is_numeric($rs['value']))
						{
						
						  eval('$'.$col.' = '.$rs['value'].';');
						}
						
					}
				}

				
				//calculate self header
				$sql = "SELECT test_results_values.id as id, formula,type, value,col_index,sampling_no,self_header  FROM test_results_values JOIN labtype_inputs ON test_results_values	.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$id' AND sampling_no='$sample'  ORDER BY type DESC,id ASC";
				$results = $connection->createCommand($sql)->queryAll();
				foreach ($results as $key => $rs) {
					$col = $rs["col_index"];

					//print_r($rs);
					if($rs['formula']!="" && $rs['self_header']==1)
					{
						eval('$value = '.$rs['formula'].';');
						eval('$'.$col.' = '.$value .';');

						$model = TestResultsValue::model()->findByPk($rs['id']);
						$model->value = $value;
						$model->save(); // save the change to database

						//print_r($model);

					}
					else{
					
						if(is_numeric($rs['value']))
						{
						
						  eval('$'.$col.' = '.$rs['value'].';');
						  //echo $col;
						}
						
					}
				}

			   //print_r($results);
			   //echo $no["sampling_no"];    
			}                


			/*$reqstd = RequestStandard::model()->findByPk($id);
			$reqstd_id = $reqstd->id;
			$labtype_id = $reqstd->labtype_id;
			$sql = "SELECT test_results_values.id as id, formula, value,col_index  FROM test_results_values JOIN labtype_inputs ON test_results_values.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$reqstd_id' AND type='header' AND self_header=0 ";
			$result = $connection->createCommand($sql)->queryAll();
			foreach ($result as $key => $rs) {
				if($rs['formula']!="")
				{
					echo $rs['col_index']."=";
					echo $rs['formula']."----";
					eval('$value = '.$rs['formula'].';');
					
					//eval('$'.$rs['col_index'].' = '.$value.';');
					//echo $rs['col_index'];

					$model = TestResultsValue::model()->findByPk($rs['id']);
					$model->value = $value;
					$model->save(); // save the change to database

					
				}
			}*/

		






			echo CJSON::encode(array(
                'status'=>'success'
            ));
            exit;
		}

		// Display Table
		$reqstd = RequestStandard::model()->findByPk($id);
		$reqstd_id = $reqstd->id;
		$labtype_id = $reqstd->labtype_id;

		// Header list			
		$sql = "SELECT id, name FROM labtype_inputs WHERE labtype_id='$labtype_id' AND type='raw' ORDER BY col_index";
		$header_list = $connection->createCommand($sql)->queryAll();

		// Sample list
		$sql = "SELECT sampling_no FROM test_results_values WHERE request_standard_id='$reqstd_id' GROUP BY sampling_no ORDER BY sampling_no_fix, sampling_no";
		$sample_list = $connection->createCommand($sql)->queryAll();

		// Result list
		$sql = "SELECT sampling_no, labtype_input_id, test_results_values.id, value  FROM test_results_values JOIN labtype_inputs ON test_results_values.labtype_input_id=labtype_inputs.id WHERE request_standard_id = '$reqstd_id' AND type='raw'";
		$result = $connection->createCommand($sql)->queryAll();
		$result_list = array();
		foreach ($result as $row) {
			$sampling_no = $row['sampling_no'];
			$labtype_input_id = $row['labtype_input_id'];
			$result_list[$sampling_no][$labtype_input_id] = array(
				'id' => $row['id'], 
				'value' => $row['value']
			);
		}

		// Set view data
		$output['request_standard'] = array(
			'reqstd_id' => $reqstd_id,
			'header_list' => $header_list,
			'sample_list' => $sample_list,
			'result_list' => $result_list
		);

		$this->renderPartial('addRaw', array('output'=>$output), false);
	}
}