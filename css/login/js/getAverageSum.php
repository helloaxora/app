<?php
$servername = "localhost";
$dbname = "radionov_direct";

$db = require '../../../protected/config/database.php';
$conn = new mysqli( $servername, $db['username'], $db['password'], $dbname );
if ( $conn->connect_error )
{
	exit ( 'Connection error.' );
}
$sql = "USE radionov_direct";
$conn->query( $sql );
$sql = "SET CHARACTER SET 'utf8'";
$res = $conn->query( $sql );

//$sql = "SELECT * FROM client WHERE Email_for_notifications='" . $_POST['email'] . "'";
//$res = $conn->query( $sql );
//if ( $res->num_rows != 0 )
//{
//	while ( $data = $res->fetch_assoc() )
//	{
$subject = Yii::app()->user->name;;
$message = "Добрый день!<br>";
$message .= "Ваш логин: " . $data['Yandex_login'] . '<br>';
$message .= "пароль: " . $data['Password'] . '<br>';

$body = $message;

$headers = "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: Axora.by <no-reply>\r\n";
$success = mail( $_POST['email'], $subject, $body, $headers );
//	}
//	$client = 1;
echo json_encode( $client );
//}
//else
//{
//	$client = 2;
//	echo json_encode( $client );
//}