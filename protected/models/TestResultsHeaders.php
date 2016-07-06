<?php

/**
 * This is the model class for table "test_results_headers".
 *
 * The followings are the available columns in table 'test_results_headers':
 * @property integer $id
 * @property string $test_date
 * @property string $tester_1
 * @property string $tester_2
 * @property string $approver
 * @property string $reporter
 * @property string $signer
 * @property string $signed_date
 * @property string $comment
 * @property integer $request_id
 */
class TestResultsHeaders extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'test_results_headers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id', 'required'),
			array('request_id', 'numerical', 'integerOnly'=>true),
			array('tester_1, tester_2, approver, reporter, signer', 'length', 'max'=>200),
			array('comment', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, test_date, tester_1, tester_2, approver, reporter, signer, signed_date, comment, request_id', 'safe', 'on'=>'search'),
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
			'test_date' => 'วันที่ทดสอบ',
			'tester_1' => 'เจ้าหน้าที่ทดสอบ 1 ',
			'tester_2' => 'เจ้าหน้าที่ทดสอบ 2',
			'approver' => 'ผู้ตรวจ',
			'reporter' => 'ผู้รายงานผล',
			'signer' => 'ผู้รับรอง',
			'signed_date' => 'วันที่รับรอง',
			'comment' => 'หมายเหตุ',
			'request_id' => 'Request',
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
		$criteria->compare('test_date',$this->test_date,true);
		$criteria->compare('tester_1',$this->tester_1,true);
		$criteria->compare('tester_2',$this->tester_2,true);
		$criteria->compare('approver',$this->approver,true);
		$criteria->compare('reporter',$this->reporter,true);
		$criteria->compare('signer',$this->signer,true);
		$criteria->compare('signed_date',$this->signed_date,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('request_id',$this->request_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
    {
      

        $str_date = explode("/", $this->test_date);
        if(count($str_date)>1)
        	$this->test_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
        
        $str_date = explode("/", $this->signed_date);
        if(count($str_date)>1)
        	$this->signed_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

        
        return parent::beforeSave();
   }

	protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->test_date);
            if(count($str_date)>1)
            	$this->test_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
            
            $str_date = explode("-", $this->signed_date);
            if(count($str_date)>1)
            	$this->signed_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);

       
    }

	public function beforeFind()
    {
          

        $str_date = explode("/", $this->test_date);
        if(count($str_date)>1)
        	$this->test_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
        
        $str_date = explode("/", $this->signed_date);
        if(count($str_date)>1)
        	$this->signed_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
        
      

        return parent::beforeSave();
   }

	protected function afterFind(){
            parent::afterFind();
    

            $str_date = explode("-", $this->test_date);
            if($this->test_date=='0000-00-00')
            	$this->test_date = '';
            else if(count($str_date)>1)
            	$this->test_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
            
            $str_date = explode("-", $this->signed_date);
            if($this->signed_date=='0000-00-00')
            	$this->signed_date = '';
            else if(count($str_date)>1)
            	$this->signed_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);

           

           
     }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TestResultsHeaders the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
