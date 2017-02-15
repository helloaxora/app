<?php
if ( $_POST )
{
	require_once Yii::app()->basePath . '/../../app.axora_configuration.php';
	require_once "SendMailSmtpClass.php"; // подключаем класс
	
	$mailSMTP = new SendMailSmtpClass( EMAIL_LOGIN, EMAIL_PASSWORD, 'ssl://smtp.yandex.ru', 'Axora', 465 );
	
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
	$headers .= "From: Axora <" . EMAIL_LOGIN . ">\r\n"; // от кого письмо
	$result = $mailSMTP->send( $_POST['email'], Yii::app()->user->name . ' - личный кабинет', $_POST['message'], $headers ); // отправляем письмо
}

?>