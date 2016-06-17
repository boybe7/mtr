<?php

/**
 * This is the model class for table "request_standards".
 *
 * The followings are the available columns in table 'request_standards':
 * @property integer $id
 * @property string $material_detail
 * @property string $lot_no
 * @property integer $lot_num
 * @property integer $sampling_num
 * @property string $cost
 * @property integer $labtype_id
 * @property integer $request_id
 * @property integer $standard_id
 * @property string $conclude
 * @property string $note
 */
class RequestStandard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'request_standards';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lot_no, lot_num, sampling_num, cost, labtype_id, request_id, standard_id,sampling_no', 'required'),
			array('lot_num, sampling_num, labtype_id, request_id, standard_id', 'numerical', 'integerOnly'=>true),
			array('material_detail', 'length', 'max'=>200),
			array('lot_no, conclude', 'length', 'max'=>500),
			array('cost', 'length', 'max'=>10),
			array('note', 'length', 'max'=>400),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, material_detail, lot_no, lot_num, sampling_num, cost, labtype_id, request_id, standard_id, conclude, note,sampling_no', 'safe', 'on'=>'search'),
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
			'labtype'=>array(self::BELONGS_TO, 'Labtype', 'labtype_id'),
			'temp_retest'=>array(self::HAS_MANY, 'TempRequest', 'request_standard_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'material_detail' => 'รายละเอียดวัสดุ',
			'lot_no' => 'เลข lot (ใส่ "," คั่นระหว่าง lot)',
			'lot_num' => 'จำนวน lot',
			'sampling_num' => 'จำนวนตัวอย่าง',
			'cost' => 'ค่าธรรมเนียมทดสอบ',
			'labtype_id' => 'วิธีการทดสอบ',
			'request_id' => 'Request',
			'standard_id' => 'มาตรฐานการทดสอบ',
			'conclude' => 'สรุปผลการทดสอบ',
			'note' => 'หมายเหตุ',
			'sampling_no'=>'หมายเลขตัวอย่าง'
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
		//$criteria->with = array("labtype");
		//$criteria->together = true;


		$criteria->compare('id',$this->id);
		$criteria->compare('material_detail',$this->material_detail,true);
		$criteria->compare('lot_no',$this->lot_no,true);
		$criteria->compare('lot_num',$this->lot_num);
		$criteria->compare('sampling_num',$this->sampling_num);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('labtype_id',$this->labtype_id);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('standard_id',$this->standard_id);
		$criteria->compare('conclude',$this->conclude,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('sampling_no',$this->sampling_no,true);

		//return new CActiveDataProvider($this, array(
		//	'criteria'=>$criteria,
		//));

		return $this->relatedsearch(
		        $criteria,
		        array()
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RequestStandard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
