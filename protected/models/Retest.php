<?php

/**
 * This is the model class for table "retests".
 *
 * The followings are the available columns in table 'retests':
 * @property integer $id
 * @property string $lot_no
 * @property string $sampling_no
 * @property integer $sampling_num
 * @property string $cost
 * @property string $invoice_no
 * @property integer $request_standard_id
 */
class Retest extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'retests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lot_no, sampling_no, sampling_num, cost, request_standard_id', 'required'),
			array('sampling_num, request_standard_id', 'numerical', 'integerOnly'=>true),
			array('lot_no, sampling_no, invoice_no', 'length', 'max'=>200),
			array('cost', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lot_no, sampling_no, sampling_num, cost, invoice_no, request_standard_id', 'safe', 'on'=>'search'),
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
			'lot_no' => 'เลข lot',
			'sampling_no' => 'เลขตัวอย่าง',
			'sampling_num' => 'จำนวนตัวอย่าง',
			'cost' => 'ค่าธรรมเนียมทดสอบ',
			'invoice_no' => 'เลขที่ใบแจ้งชำระเงิน',
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
		$criteria->compare('lot_no',$this->lot_no,true);
		$criteria->compare('sampling_no',$this->sampling_no,true);
		$criteria->compare('sampling_num',$this->sampling_num);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('invoice_no',$this->invoice_no,true);
		$criteria->compare('request_standard_id',$this->request_standard_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Retest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
