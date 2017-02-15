<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $Id
 * @property string $Yandex_login
 * @property string $Password
 * @property string $Email_for_notifications
 * @property string $Phone_for_notifications
 * @property string $Company_name
 * @property string $Name_marketer
 *
 * The followings are the available model relations:
 * @property Api[] $apis
 * @property Balance[] $balances
 * @property Marketer $nameMarketer
 * @property Users[] $users
 */
class Client extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $login;
	public $name;
	public $surname;
	public $currency;
	public $sendMsg;
	
	
	public function tableName ()
	{
		return 'client';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules ()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array( 'Email_for_notifications, Phone_for_notifications, Name_marketer,login,name,surname,currency', 'required', 'on' => 'create' ),
			array( 'Yandex_login, Password, Email_for_notifications, Phone_for_notifications, Name_marketer', 'required', 'on' => 'add/update' ),
			array( 'Yandex_login, Password, Email_for_notifications, Phone_for_notifications, Company_name, Name_marketer', 'length', 'max' => 255 ),
			//	array('//*Yandex_login,*/  Email_for_notifications', 'email'),
			array( ' Email_for_notifications', 'email' ),
			array( 'Yandex_login', 'unique' ),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array( 'Id, Yandex_login, Password, Email_for_notifications, Phone_for_notifications, Company_name, Name_marketer, Send_msg', 'safe', 'on' => 'search' ),
			array( 'Id, Yandex_login, Password, Email_for_notifications, Phone_for_notifications, Company_name, Name_marketer, Send_msg', 'safe' ),
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations ()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'apis' => array( self::HAS_MANY, 'Api', 'Yandex_login' ),
			'balances' => array( self::HAS_MANY, 'Balance', 'Yandex_login' ),
			'nameMarketer' => array( self::BELONGS_TO, 'Marketer', 'Name_marketer' ),
			'users' => array( self::HAS_MANY, 'Users', 'username' ),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels ()
	{
		return array(
			'Id' => 'ID',
			'Yandex_login' => 'Логин',
			'Password' => 'Пароль',
			'Email_for_notifications' => 'Почта для уведомлений',
			'Phone_for_notifications' => 'Тел. для уведомлений',
			'Company_name' => 'Название компании',
			'Name_marketer' => 'Маркетолог',
			'Send_msg' => 'Отправлять сообщения',
			////добавление начато
			'login' => 'Логин',
			'name' => 'Имя',
			'surname' => 'Фамилия',
			'currency' => 'Валюта',
			////добавление окончено
		);
	}
////добавление начато
//	protected function afterSave() {
//		parent::afterSave();
//		if(isset($this->name)){
//			$yandex_account = new NewYandexAccount;
//			$yandex_account->login =     $this->login;
//			$yandex_account->name =        $this->name;
//			$yandex_account->surname =  $this->surname;
//			$yandex_account->currency = $this->currency;
//			$yandex_account->save();
//		}
//	}
////добавление окончено
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
	public function search ()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		
		$criteria = new CDbCriteria;
		
		$criteria->compare( 'Yandex_login', $this->Yandex_login, true );
		$criteria->compare( 'Password', $this->Password, true );
		$criteria->compare( 'Email_for_notifications', $this->Email_for_notifications, true );
		$criteria->compare( 'Phone_for_notifications', $this->Phone_for_notifications, true );
		$criteria->compare( 'Company_name', $this->Company_name, true );
		$criteria->compare( 'Name_marketer', $this->Name_marketer, true );
		
		return new CActiveDataProvider( $this, array(
			'criteria' => $criteria,
			'pagination' => array(
				'pageSize' => 20,
			),
		) );
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Client the static model class
	 */
	public static function model ($className = __CLASS__)
	{
		return parent::model( $className );
	}
}
