<?php
require_once Yii::app()->basePath . '/../../app.axora_configuration.php';
$client_id = CLIENT_ID;
$client_secret = CLIENT_SECRET;
$strRedirectUrl = 'https://oauth.yandex.ru/authorize?response_type=code&client_id=' . $client_id;

if ( isset( $_SESSION['code'] ) )
{
	$query = array(
		'grant_type' => 'authorization_code',
		'code' => $_SESSION['code'],
		'client_id' => $client_id,
		'client_secret' => $client_secret
	);
	$query = http_build_query( $query );
	
	$header = "Content-type: application/x-www-form-urlencoded";
	
	$opts = array( 'http' =>
		               array(
			               'method' => 'POST',
			               'header' => $header,
			               'content' => $query
		               )
	);
	$context = stream_context_create( $opts );
	$result = file_get_contents( 'https://oauth.yandex.ru/token', false, $context );
	$result = json_decode( $result );
	
	$_SESSION['token'] = $result->access_token;
}
else
{
	header( 'Location: ' . $strRedirectUrl );
	exit();
}
?>

