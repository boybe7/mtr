<?php

/**
 * This is the model class for table "labtypes".
 *
 * The followings are the available columns in table 'labtypes':
 * @property integer $id
 * @property string $name
 * @property string $cost
 * @property integer $is_chemical_test
 * @property integer $material_id
 */
class Labtype extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'labtypes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, cost, is_chemical_test, material_id,name_report', 'required'),
			array('is_chemical_test, material_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>200),
			array('cost', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, cost, is_chemical_test, material_id,matname', 'safe', 'on'=>'search'),
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
			'material'=>array(self::BELONGS_TO, 'Material', 'material_id'),
			'req_std'=>array(self::HAS_MANY, 'RequestStandard', 'labtype_id'),
		);
	}

	public function behaviors() {
	    return array(
	            // Add RelatedSearchBehavior
	            'relatedsearch'=>array(
	                    'class'=>'RelatedSearchBehavior',
	                    'relations'=>array(
	                            'matname'=>'material.name',
	                    ),
	            ),
	    );
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'ชื่อวิธีการทดสอบ',
			'cost' => 'อัตราค่าทดสอบ',
			'is_chemical_test' => 'ทดสอบด้านเคมี', //(0=No, 1=Yes)
			'material_id' => 'ชนิดวัสดุ',
			'name_report'=>'ชื่อปรากฎในรายงาน',
		
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('is_chemical_test',$this->is_chemical_test);
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('name_report',$this->name_report,true);


		// return new CActiveDataProvider($this, array(
		// 	'criteria'=>$criteria,
		// ));

		return $this->relatedsearch(
		        $criteria,
		        array()
		);
	}

	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Labtype the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
