<?php
define( "DIRECT", 'dirdir' );

require_once 'Functions.php';

$sql = "SELECT Yandex_login FROM client ";
$res = $conn->query( $sql );


if ( $res->num_rows > 0 )
{
	while ( $row = $res->fetch_assoc() ) //для каждого клиента делаем опред. действия
	{
		$currentLogin = $row['Yandex_login'];
		$_POST['currentLogin'] = $currentLogin;
		require 'AddStatistics.php';
	}
}
