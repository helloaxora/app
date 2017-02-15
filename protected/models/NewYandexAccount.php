<?php

/**
 * Created by PhpStorm.
 * User: Axora
 * Date: 07.10.2016
 * Time: 15:26
 */
class NewYandexAccount extends CFormModel
{
	public $login;
	public $name;
	public $surname;
	public $currency;
	
	public function rules ()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array( 'login, name, surname, currency', 'required' ),
			array( 'login, name, surname, currency', 'length', 'min' => 1 )
		);
	}
	
	public function save ()
	{
		$params['Login'] = $this->login;
		$params['Name'] = $this->name;
		$params['Surname'] = $this->surname;
		$params['Currency'] = $this->currency;
		$request = array(
			'token' => $_SESSION['token'],
			'method' => 'CreateNewSubclient',
			'param' => utf8($params),
			'locale' => 'ru',
		);
		$request = json_encode( $request );
		
		$opts = array(
			'http' => array(
				'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
				'Content-Type: application/json; charset=utf-8',
				'method' => 'POST',
				'content' => $request,
			)
		);
		$context = stream_context_create( $opts );
		$result = file_get_contents( 'https://api-sandbox.direct.yandex.ru/live/v4/json', false, $context );
		$result = json_decode( $result, true );
		return $result;
	}
}
function utf8($struct) {
	foreach ($struct as $key => $value) {
		if (is_array($value)) {
			$struct[$key] = utf8($value);
		}
		elseif (is_string($value)) {
			$struct[$key] = utf8_encode($value);
		}
	}
	return $struct;
}