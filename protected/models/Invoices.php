<?php

/**
 * This is the model class for table "invoices".
 *
 * The followings are the available columns in table 'invoices':
 * @property integer $id
 * @property string $invoice_no
 * @property string $cost
 * @property string $bill_no
 * @property string $bill_date
 * @property integer $request_id
 */
class Invoices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('invoice_no, cost, request_id', 'required'),
			array('request_id', 'numerical', 'integerOnly'=>true),
			array('invoice_no, bill_no', 'length', 'max'=>200),
			array('cost', 'length', 'max'=>10),
			array('invoice_no', 'unique'),
			array('bill_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invoice_no, cost, bill_no, bill_date, request_id,sampling_no', 'safe', 'on'=>'search'),
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
			'request'=>array(self::BELONGS_TO, 'Request', 'request_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice_no' => 'เลขที่ใบแจ้งชำระเงิน',
			'cost' => 'ค่าธรรมเนียมทดสอบ',
			'bill_no' => 'เลขที่ใบเสร็จรับเงิน',
			'bill_date' => 'วันที่ชำระเงิน',
			'request_id' => 'Request',
			'sampling_no'=>'sampling_no'
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
		$criteria->compare('invoice_no',$this->invoice_no,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('bill_no',$this->bill_no,true);
		$criteria->compare('bill_date',$this->bill_date,true);
		$criteria->compare('request_id',$this->request_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByRequest($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('invoice_no',$this->invoice_no,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('bill_no',$this->bill_no,true);
		$criteria->compare('bill_date',$this->bill_date,true);
		$criteria->compare('request_id',$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function canDelete($no)
	{

		$can = strpos($no, "-");
		return $can;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Invoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
