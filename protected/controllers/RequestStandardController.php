<?php

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
				'actions'=>array('admin','delete','index'),
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
		if(isset($_POST['result'])){
			$output['result'] = $_POST['result'];
			foreach ($_POST['result'] as $result_id => $result_value) {
				$rv = TestResultsValue::model()->findByPk($result_id);
				$rv->value = $result_value;
				$rv->save(); // save the change to database
			}
		}

		// Request query
		$request = Request::model()->findByPk($id);
		$output['request'] = $request->attributes;

		// RequestStandard query
		$request_standard = $request->req_std;
		$output['request_standard'] = array();
		foreach ($request_standard as $row) {
			$id = $row->id;
			$labtype_id = $row->labtype_id;
			$material_name = $row->labtype->material->name;
			$labtype_name = $row->labtype->name;

			// Header list			
			$sql = "SELECT id, name FROM labtype_inputs WHERE labtype_id='$labtype_id' AND type='header' ORDER BY col_index";
			$header_list = $connection->createCommand($sql)->queryAll();

			// Sample list
			$sql = "SELECT sampling_no FROM test_results_values WHERE request_standard_id='$id' GROUP BY sampling_no ORDER BY sampling_no_fix, sampling_no";
			$sample_list = $connection->createCommand($sql)->queryAll();

			// Result list
			$sql = "SELECT * FROM test_results_values WHERE request_standard_id='$id'";
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
			$output['request_standard'][] = array(
				'id' => $id,
				'material_name' => $material_name,
				'labtype_name' => $labtype_name,
				'header_list' => $header_list,
				'sample_list' => $sample_list,
				'result_list' => $result_list
			);
		}

		// Render view
		$this->render('index', array('output' => $output));
	}
}
