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
    public $material,$sampling_no;


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
			array('detail,note', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request_no, date, vendor_id, owner_id, job_id, contract_id, detail, status,material,sampling_no,note', 'safe', 'on'=>'search'),
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
			'req_std'=>array(self::HAS_MANY, 'RequestStandard', 'request_id'),
			'vendor'=>array(self::BELONGS_TO, 'Vendor', 'vendor_id'),
			'owner'=>array(self::BELONGS_TO, 'Vendor', 'owner_id'),
			'job'=>array(self::BELONGS_TO, 'Job', 'job_id'),
			'contract'=>array(self::BELONGS_TO, 'Contract', 'contract_id'),
			'result_headers'=>array(self::HAS_MANY, 'TestResultsHeaders', 'request_id'),
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
			'status' => 'สถานะ',
			'material'=>'ชนิดวัสดุ',
			'sampling_no'=>'หมายเลขตัวอย่าง',
			'note'=>'หมายเหตุ'

		);
	}

	function behaviors() {
	    return array(
	        'relatedsearch'=>array(
	             'class'=>'RelatedSearchBehavior',
	             'relations'=>array(
	                  'material'=>'req_std.labtype.material.name',
	                  'owner_id'=>'owner.name',
	                  'sampling_no'=>'req_std.sampling_no',
	                  'contract_id' => 'contract.name'

	             ),
	         ),
	    );
	}

	/**
	 * Not used in this example, but the next code allows autoscopes provided
	 * by RelatedSearchBehavior.
	 */
	public function __call($name,$parameters) {
	    try {
	        return parent::__call($name,$parameters);
	    } catch (CException $e) {
	        if(preg_match('/'.Yii::t('yii',quotemeta(Yii::t('yii','{class} and its behaviors do not have a method or closure named "{name}".')),array('{class}'=>'.*','{name}'=>'.*')).'/',$e->getMessage())) {
	            return $this->autoScope($name, $parameters);
	        } else {
	            throw $e;
	        }
	    }
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
		$alias=$this->getTableAlias(true,false).".";
		//$criteria->with = array("req_std");
		//$criteria->together = true;

		//$criteria->compare($alias.'id',$this->id);
		$criteria->compare($alias.'request_no',$this->request_no,true);
		$criteria->compare($alias.'date',$this->date,true);
		$criteria->compare($alias.'vendor_id',$this->vendor_id);
		$criteria->compare($alias.'owner_id',$this->owner_id);
		$criteria->compare($alias.'job_id',$this->job_id);
		//$criteria->compare($alias.'contract_id',$this->contract_id);
		$criteria->compare($alias.'detail',$this->detail,true);
		$criteria->compare($alias.'status',$this->status);


		//$criteria->compare( 'req_std.labtype_id.', $this->material, true );

		

		/*return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
			    'defaultOrder'=>'date ASC',
			  )
		));*/

		return $this->relatedSearch(
	            $criteria,
	            array(
	                    'pagination'=>array('pageSize'=>10),
	            	
	            )
	
	    );
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

	public function beforeSave()
    {
      

        $str_date = explode("/", $this->date);
        if(count($str_date)>1)
        	$this->date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
        
     
        
        return parent::beforeSave();
   }

	protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->date);
            if(count($str_date)>1)
            	$this->date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
         
    }

	public function beforeFind()
    {
          

        $str_date = explode("/", $this->date);
        if(count($str_date)>1)
        	$this->date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
        
    
        return parent::beforeSave();
   }

	protected function afterFind(){
            parent::afterFind();
    

            $str_date = explode("-", $this->date);
            if($this->date=='0000-00-00')
            	$this->date = '';
            else if(count($str_date)>1)
            	$this->date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
      
           
     }
}
