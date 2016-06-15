<?php

/**
 * This is the model class for table "test_results_values".
 *
 * The followings are the available columns in table 'test_results_values':
 * @property integer $id
 * @property string $value
 * @property string $sampling_no
 * @property string $lot_no
 * @property string $sampling_no_fix
 * @property integer $labtype_input_id
 * @property integer $request_standard_id
 */
class TestResultsValue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'test_results_values';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('value, sampling_no, lot_no, sampling_no_fix, labtype_input_id, request_standard_id', 'required'),
			array('labtype_input_id, request_standard_id', 'numerical', 'integerOnly'=>true),
			array('value', 'length', 'max'=>300),
			array('sampling_no, lot_no, sampling_no_fix', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, value, sampling_no, lot_no, sampling_no_fix, labtype_input_id, request_standard_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'value' => 'Value',
			'sampling_no' => 'หมายเลขตัวอย่าง',
			'lot_no' => 'หมายเลข lot',
			'sampling_no_fix' => 'หมายเลขตัวอย่าง',
			'labtype_input_id' => 'Labtype Input',
			'request_standard_id' => 'Request Standard',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('sampling_no',$this->sampling_no,true);
		$criteria->compare('lot_no',$this->lot_no,true);
		$criteria->compare('sampling_no_fix',$this->sampling_no_fix,true);
		$criteria->compare('labtype_input_id',$this->labtype_input_id);
		$criteria->compare('request_standard_id',$this->request_standard_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TestResultsValue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
