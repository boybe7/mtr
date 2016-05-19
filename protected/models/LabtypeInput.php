<?php

/**
 * This is the model class for table "labtype_inputs".
 *
 * The followings are the available columns in table 'labtype_inputs':
 * @property integer $id
 * @property string $name
 * @property string $col_index
 * @property string $formula
 * @property string $type
 * @property integer $labtype_id
 */
class LabtypeInput extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'labtype_inputs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, col_index, type, labtype_id', 'required'),
			array('labtype_id', 'numerical', 'integerOnly'=>true),
			array('name, formula', 'length', 'max'=>200),
			array('col_index', 'length', 'max'=>2),
			array('type', 'length', 'max'=>10),
			array('col_index+labtype_id', 'application.extensions.uniqueMultiColumnValidator'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, col_index, formula, type, labtype_id', 'safe', 'on'=>'search'),
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
			'name' => 'ชื่อ input',
			'col_index' => 'คอลัมภ์',
			'formula' => 'สูตรคำนวณ',
			'type' => 'ประเภท (header,raw)',
			'labtype_id' => 'วิธีการทดสอบ',
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
		$criteria->compare('col_index',$this->col_index,true);
		$criteria->compare('formula',$this->formula,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('labtype_id',$this->labtype_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByType($typeID,$id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('col_index',$this->col_index,true);
		$criteria->compare('formula',$this->formula,true);
		$criteria->compare('type',$typeID,true);
		$criteria->compare('labtype_id',$id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LabtypeInput the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
