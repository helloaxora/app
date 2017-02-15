<?php

echo "wedfrghjkl/";

if ( $_POST )
{
	
	$subject = Yii::app()->user->name . ' - личный кабинет';
	
	$message = !empty( $_POST['message'] ) ? $_POST['message'] : '';
	
	$body = $message ? "<b>Сообщение:</b><br> " . $message . "<br>" : '';
	
	$body .= "<hr>";
	$body .= "<b>Browser:</b> " . $_SERVER['HTTP_USER_AGENT'] . "<br>";
	$body .= "<b>Ip - Местоположение:</b> " . '<a href="http://www.ip-adress.com/ip_tracer/' . $_SERVER['REMOTE_ADDR'] . '">' . $_SERVER['REMOTE_ADDR'] . '</a>';
	
	$to = $_POST['mail'];
	
	$headers = "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: " . Yii::app()->user->name . " <no-reply>\r\n";
	$success = mail( $to, $subject, $body, $headers );
	
	if ( $success )
	{
		Yii::app()->user->setFlash( 'success', "The message was successfully sent" );
	}
	else
	{
		Yii::app()->user->setFlash( 'error', "The message wasn't sent" );
	}
	
}
?>