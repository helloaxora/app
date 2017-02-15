<?php

if ( isset( $_POST['email'] ) )
{
	require_once( __DIR__. '/../../../../app.axora_configuration.php' );
	$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE );
	if ( $conn->connect_error )
	{
		exit ( 'Connection error.' );
	}
	$sql = "USE ".DB_DATABASE;
	$conn->query( $sql );
	$sql = "SET CHARACTER SET 'utf8'";
	$res = $conn->query( $sql );
	
	$sql = "SELECT * FROM client WHERE Email_for_notifications='" . $_POST['email'] . "'";
	$res = $conn->query( $sql );
	
	if ( $res->num_rows != 0 )
	{
		require_once "../../../cron/SendMailSmtpClass.php";
		$subject = 'Восстановление пароля';
		$message = "Добрый день!<br><br>";
		while ( $data = $res->fetch_assoc() )
		{
			$message .= "Логин: " . $data['Yandex_login'] . '<br>';
			$message .= "пароль: " . $data['Password'] . '<br><br>';
			
		}
		$body = $message;
		
		$mailSMTP = new SendMailSmtpClass( EMAIL_LOGIN, EMAIL_PASSWORD, 'ssl://smtp.yandex.ru', 'Axora', 465 );

// заголовок письма
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
		$headers .= "From: Axora <".EMAIL_LOGIN.">\r\n"; // от кого письмо
		
		$result = $mailSMTP->send( $_POST['email'], $subject, $body, $headers ); // отправляем письмо
		$client = 1;
		
		echo json_encode( $client );
		
	}
	else
	{
		$client = 2;
		echo json_encode( $client );
	}
	
}

?>