<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property integer $user_group_id
 * @property integer $positions_id_1
 * @property integer $positions_id_2
 *
 * The followings are the available model relations:
 * @property Positions $positionsId1
 * @property UserGroups $userGroup
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, user_group_id, positions_id_1', 'required'),
			array('user_group_id, positions_id_1, positions_id_2', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>100),
			array('password, name', 'length', 'max'=>200),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, name, user_group_id, positions_id_1, positions_id_2', 'safe', 'on'=>'search'),
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
			'positionsId1' => array(self::BELONGS_TO, 'Positions', 'positions_id_1'),
			'userGroup' => array(self::BELONGS_TO, 'UserGroups', 'user_group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'ชื่อเข้าใช้งาน',
			'password' => 'รหัสผ่าน',
			'name' => 'ชื่อ-นามสกุล',
			'user_group_id' => 'กลุ่มผู้ใช้งาน',
			'positions_id_1' => 'ตำแหน่ง',
			'positions_id_2' => 'ตำแหน่งรักษาการ',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('user_group_id',$this->user_group_id);
		$criteria->compare('positions_id_1',$this->positions_id_1);
		$criteria->compare('positions_id_2',$this->positions_id_2);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getGroupName($gid)
    {
        switch ($gid) {
        	case 1:
        		$name = "admin";
        		break;
        	case 2:
        		$name = "superuser";
        		break;
        	case 3:
        		$name = "user";
        		break;
        	case 4:
        		$name = "executive";
        		break;		
        	default:
        		$name = "";
        		break;
        }
        return $name;
    }

    public function getGroup($m)
    {
        
        $model = UserGroup::model()->findByPk($m->user_group_id);
         // header('Content-type: text/plain');
         // print_r($model);                    
         // exit;
        $group = !empty($model) ? $model->name: "";
        return $group;
    }

     public function getPosition($m)
    {
        
        $model = Position::model()->findByPk($m->positions_id_1);
         // header('Content-type: text/plain');
         // print_r($model);                    
         // exit;
        $position = !empty($model) ? $model->posi_name: "";
        return $position;
    }

     public function getPosition2($m)
    {
        
        $model = Position::model()->findByPk($m->positions_id_2);
         // header('Content-type: text/plain');
         // print_r($model);                    
         // exit;
        $position = !empty($model) ? $model->posi_name: "";
        return $position;
    }

	public function validatePassword($password)
    {
        return sha1($password)===$this->password;
    }
    
    public function beforeSave()
    {
        
            $this->password= sha1($this->password);
             
            return parent::beforeSave();
    }

    protected function afterFind(){

		parent::afterFind();
		
	}
}
