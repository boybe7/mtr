<?php

/**
 * This is the model class for table "requests".
 *
 * The followings are the available columns in table 'requests':
 * @property integer $id
 * @property string $request_no
 * @property string $date
 * @property integer $vendor_id
 * @property integer $owner_id
 * @property integer $job_id
 * @property integer $contract_id
 * @property string $detail
 * @property integer $status
 */
class Request extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
    public $material;


	public function tableName()
	{
		return 'requests';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_no, date, owner_id, job_id, status', 'required'),
			array('vendor_id, owner_id, job_id, contract_id, status', 'numerical', 'integerOnly'=>true),
			array('request_no', 'length', 'max'=>15),
			array('detail', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request_no, date, vendor_id, owner_id, job_id, contract_id, detail, status,material', 'safe', 'on'=>'search'),
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
			'request_no' => 'เลขที่ลำดับการทดสอบ',
			'date' => 'วันที่รับตัวอย่าง',
			'vendor_id' => 'ผู้ผลิต',
			'owner_id' => 'เจ้าของตัวอย่าง',
			'job_id' => 'ประเภทงาน',
			'contract_id' => 'สัญญา',
			'detail' => 'เรื่อง/งาน',
			'status' => 'Status',
			'material'=>'ชนิดวัสดุ'

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
		$criteria->compare('request_no',$this->request_no,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('owner_id',$this->owner_id);
		$criteria->compare('job_id',$this->job_id);
		$criteria->compare('contract_id',$this->contract_id);
		$criteria->compare('detail',$this->detail,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Request the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
