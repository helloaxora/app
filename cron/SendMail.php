<?php

require_once "SendMailSmtpClass.php";
function pre ($arr)
{
	ini_set( 'xdebug.var_display_max_depth', 7 );
	ini_set( 'xdebug.var_display_max_children', 256 );
	ini_set( 'xdebug.var_display_max_data', 1024 );
	
	echo '<pre>';
	var_dump( $arr );
	
}
require_once '../../app.axora_configuration.php';
$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE );
if ( $conn->connect_error )
{
	exit ( 'Connection error.' );
}
$sql = "USE ".DB_DATABASE;
$conn->query( $sql );


$sql = "SET CHARACTER SET 'utf8'";
$res = $conn->query( $sql );

$sql = "SELECT Yandex_login FROM client WHERE Send_msg='Да'";
$res = $conn->query( $sql );

$logins = array();
$lastMsg = array();
if ( $res->num_rows > 0 )
{
	while ( $row = $res->fetch_assoc() )
	{
		$currentLogin = $row['Yandex_login'];
		
		$_SESSION['token'] = YANDEX_TOKEN;
		$sql = "SELECT * FROM msg WHERE Yandex_login='" . $currentLogin . "'ORDER BY Date DESC LIMIT 1";
		$lDate = $conn->query( $sql );
		
		if ( $lDate->num_rows > 0 )
		{
			$date = $lDate->fetch_assoc();
			if ( date( "Y-m-d", strtotime( ( $date['Date'] ) ) ) != date( "Y-m-d", time() ) )//если сегодня не отправляли письмо
			{
				$logins[] = $currentLogin;
				$lastMsg[$currentLogin]['Days_left'] = $date['Days_left'];
				$lastMsg[$currentLogin]['Date'] = $date['Date'];
				$lastMsg[$currentLogin]['Sum'] = $date['Balance'];
			}
		}
		else
		{
			$logins[] = $currentLogin;
		}
	}
}
$allSums = getSum( $logins );//получаем остаток на балансе каждого клиента
foreach ( $allSums as $currentClientBalance )
{
	$sql = "INSERT INTO balance ( Yandex_login, Balance)  VALUES ('" . $currentClientBalance['Login'] . "','" . $currentClientBalance['Amount'] . "')";
	$conn->query( $sql );
	
	$currentLogin = $currentClientBalance['Login'];
	if ( $currentClientBalance['Amount'] != 0 )
	{
		$averageSumClient = 0;
		$sql = "SELECT Id_campaign FROM campaigns WHERE Yandex_login='" . $currentClientBalance['Login'] . "'";
		$ids = $conn->query( $sql );
		
		if ( $ids->num_rows > 0 )//считаем средний расход клиента в день
		{
			while ( $id = $ids->fetch_assoc() )
			{
				if ( isCampaignOn( $currentClientBalance['Login'], $id['Id_campaign'] ) )
				{
					$averageSumCamp = 0;
					$sql = "SELECT * FROM api WHERE Id_campaign='" . $id['Id_campaign'] . "'  ORDER BY Date DESC LIMIT 30 ";
					$data = $conn->query( $sql );
					$numDays = 0;
					if ( $data->num_rows > 0 )
					{
						while ( $row = $data->fetch_assoc() )
						{
							if ( $row['Sum_search'] != 0 || $row['Sum_context'] != 0 )
							{
								$averageSumCamp += $row['Sum_search'];
								$averageSumCamp += $row['Sum_context'];
								$numDays++;
							}
						}
					}
					if ( $numDays != 0 )
					{
						$averageSumCamp = $averageSumCamp/$numDays;
					}
					$averageSumClient += $averageSumCamp;
				}
			}
		}
		if ( $averageSumClient != 0 )
		{
			$daysLeft = round( $currentClientBalance['Amount']/$averageSumClient );
			if ( $daysLeft == '3' || $daysLeft == '0' )
			{
				if ( isset( $lastMsg[$currentLogin]['Days_left'] ) && $lastMsg[$currentLogin]['Days_left'] == $daysLeft )
				{
					if ( date( "Y-m-d", strtotime( ( $lastMsg[$currentLogin]['Date'] ) ) ) != date( "Y-m-d", time() - 60*60*24 )
						&&
						date( "Y-m-d", strtotime( ( $lastMsg[$currentLogin]['Date'] ) ) ) != date( "Y-m-d", time() - 60*60*24*2 )
					)
					{
						if ( $currentClientBalance['Amount'] > $lastMsg[$currentLogin]['Sum'] )
						{
							msgAndDB( $currentLogin, $daysLeft, $currentClientBalance['Amount'] );
						}
						else
						{
							$sql = "SELECT MAX(Balance) FROM balance WHERE Yandex_login='" . $currentClientBalance['Login'] .
								"' AND Date_time > '" . $lastMsg[$currentLogin]['Date'] . "'";
							$data = $conn->query( $sql );
							if ( $data->num_rows > 0 )
							{
								$row = $data->fetch_assoc();
								if ( $row['MAX(Balance)'] > $lastMsg[$currentLogin]['Sum'] )
								{
									msgAndDB( $currentLogin, $daysLeft, $currentClientBalance['Amount'] );
								}
							}
						}
					}
				}
				else
				{
					msgAndDB( $currentLogin, $daysLeft, $currentClientBalance['Amount'] );
				}
			}
		}
	}
}

function msgAndDB ($login, $days, $sum)
{
	$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE );
	if ( $conn->connect_error )
	{
		exit ( 'Connection error.' );
	}
	$sql = "USE ".DB_DATABASE;
	$conn->query( $sql );
	
	
	$sql = "SET CHARACTER SET 'utf8'";
	$res = $conn->query( $sql );
	
	$sql = "SELECT * FROM client WHERE Yandex_login='" . $login . "'";
	$data = $conn->query( $sql );
	
	$sql = "SELECT * FROM users WHERE username='" . $login . "'";
	$hash = $conn->query( $sql );
	$hash = $hash->fetch_assoc();
	if ( $data->num_rows > 0 )
	{
		$data = $data->fetch_assoc();
		send_msg( $data['Email_for_notifications'], $days, $data['Yandex_login'], $data['Password'], $hash['hash'] );
		
		$sql = "INSERT INTO msg ( Yandex_login, Days_left, Balance)  VALUES
('" . $login . "','" . $days . "' ,'" . $sum . "')";
		$conn->query( $sql );
	}
	
}

function send_msg ($mail, $days_left, $login, $pass, $hash)
{
	$mailSMTP = new SendMailSmtpClass( EMAIL_LOGIN, EMAIL_PASSWORD, 'ssl://smtp.yandex.ru', 'Axora', 465 );

// заголовок письма
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
	$headers .= "From: Axora <".EMAIL_LOGIN.">\r\n"; // от кого письмо

//
	if ( $days_left == 0 )
	{
		$subject = getStr( "title0", $login, $pass, $hash );
		$message = getStr( "msg0", $login, $pass, $hash );
	}
	else
	{
		$subject = getStr( "title3", $login, $pass, $hash );
		$message = getStr( "msg3", $login, $pass, $hash );
	}
	
	$result = $mailSMTP->send( $mail, $subject, $message, $headers ); // отправляем письмо
	
}

function getSum ($Logins)
{
	$params = array(
		"Action" => 'Get',
		'SelectionCriteria' => array( 'Logins' => $Logins )
	);
	$request = array(
		'token' => $_SESSION['token'],
		'method' => 'AccountManagement',
		'param' => $params,
		'locale' => 'ru'
	);
	$request = json_encode( $request );
	
	$opts = array(
		'http' => array(
			'method' => 'POST',
			'content' => $request,
		)
	);
	$context = stream_context_create( $opts );
	$result = @file_get_contents( 'https://api.direct.yandex.ru/live/v4/json', false, $context );
	$result = json_decode( $result, true );
	
	if ( isset( $result['data']['Accounts'] ) )
	{
		return $result['data']['Accounts'];
	}
}

function getStr ($s, $login, $pass, $hash)
{
	$bill = URL_PATH.'/index.php/site/login?l=' . $login . '&p=' . $hash . '&redirect=bill';
	$stat = URL_PATH.'/index.php/site/login?l=' . $login . '&p=' . $hash . '&redirect=statistics';
	
	$arr = array(
		
		'title0' => "Контекстная реклама сегодня остановится",
		
		'title3' => "Контекстная реклама " . html_entity_decode( '&#8212;', ENT_COMPAT, 'UTF-8' ) . " осталось 3 дня",
		
		
		'msg0' => "Здравствуйте!<br><br>
На вашем счёте в Яндекс.Директ почти закончились средства. Контекстная реклама сегодня остановится.<br><br>
<a href='" . $bill . "'>Пополните ваш счет</a>, чтобы не терять клиентов.<br><br>
Посмотреть статистику , задать вопросы интернет-маркетологу вы можете в <a href='" . $stat . "'>личном кабинете</a>.
<br>Ваш логин:  $login<br>
Пароль: $pass<br><br><br>
 С уважением,<br>
 команда Axora",
		
		'msg3' => "Здравствуйте!<br><br>
На вашем счёте в Яндекс.Директ заканчиваются средства. Их хватит примерно на 3 дня.<br><br>
Чтобы не было простоя рекламы и вы не теряли клиентов, не забудьте 
<a href='" . $bill . "'>пополнить ваш счёт</a>.<br><br>
Посмотреть статистику контекстной рекламы, задать вопросы интернет-маркетологу вы можете в <a href='" . $stat . "'>личном кабинете</a>.
<br>Ваш логин:  $login<br>
Пароль: $pass<br><br><br>
 С уважением,<br>
 команда Axora"
	
	);
	return $arr[$s];
	
}

function isCampaignOn ($Login, $Id)
{
	$params = array( 'SelectionCriteria' => array( 'States' => array( 'ON' ) ),
	                 'FieldNames' => array( 'Name', 'Id', 'Statistics', 'State', 'StatusPayment', 'Status' ) );
	
	$request = array(
		'method' => 'get',
		'params' => $params,
	);
	$request = json_encode( $request );
	$opts = array(
		'http' => array(
			'method' => 'POST',
			'header' => array(
				'Authorization: Bearer ' . $_SESSION['token'],
				'Accept-Language: ru',
				'Client-Login: ' . $Login,
				'Content-Type: application/json; charset=utf-8' ),
			'content' => $request,
		)
	);
	$context = stream_context_create( $opts );
	$result = file_get_contents( 'https://api.direct.yandex.com/json/v5/campaigns', 0, $context );
	$result = json_decode( $result, true );
	
	if ( isset ( $result['result']['Campaigns'] ) )
	{
		$campaigns = $result['result']['Campaigns'];
		foreach ( $campaigns as $oneC )
		{
			if ( $oneC['Id'] == $Id )
			{
				return true;
			}
		}
	}
	return false;
	
}
