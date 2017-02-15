<?php

/**
 * This is the model class for table "marketer".
 *
 * The followings are the available columns in table 'marketer':
 * @property integer $Id
 * @property string $Name
 * @property string $Phone
 * @property string $Email
 * @property string $Photo
 *
 * The followings are the available model relations:
 * @property Client[] $clients
 */
class Marketer extends CActiveRecord
{
	public $name;
	public $phone;
	public $email;
	public $photo;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'marketer';
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Name, Phone, Email', 'required'),
			array('Name, Phone, Email', 'length', 'max'=>255),
			array('Email', 'email'),
			array('Name', 'unique'),
			array('Photo', 'file', 'types' => 'jpg,jpeg,png,gif', 'allowEmpty' => false, 'except'=>'update'),
//			array('Photo', 'file','types'=>'jpg,jpeg,png,gif','allowEmpty'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array(' Name, Phone, Email', 'safe', 'on'=>'search'),
			array(' Name, Phone, Email, Photo', 'safe')
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
			'clients' => array(self::HAS_MANY, 'Client', 'Name_marketer'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Name' => 'Name',
			'Phone' => 'Phone',
			'Email' => 'Email',
			'Photo' => 'Photo',
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
		$criteria->compare('Name',$this->Name,true);
		$criteria->compare('Phone',$this->Phone,true);
		$criteria->compare('Email',$this->Email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Marketer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
