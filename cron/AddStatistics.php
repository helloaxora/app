<?php
if ( !defined( 'DIRECT' ) )
{
	exit();
}
$_SESSION['token'] = YANDEX_TOKEN;

$allId = array();
$array = array();

$currentLogin = $_POST['currentLogin'];
$sql = "SELECT date FROM campaigns WHERE Yandex_login ='" . $currentLogin . "' ORDER BY date DESC LIMIT 1";
$lastDate = $conn->query( $sql );

if ( $lastDate->num_rows == 0 )
{//если у данного аккаунта нет кампаний в бд
	$params = array( 'Timestamp' => '2005-02-02T10:08:22Z' );
	$campaigns = getNewCampaigns( $params, $currentLogin );
	if ( isset ( $campaigns ) )
	{
		foreach ( $campaigns as $obj )
		{
			$sql = "INSERT  INTO campaigns (Yandex_login ,Id_campaign, Campaign_name) values
 ('" . $currentLogin . "', '" . $obj['Id'] . "', '" . $obj['Name'] . "');";
			$conn->query( $sql );
		}
	}
}
else
{
	$Date = $lastDate->fetch_assoc();
	$d = date( "Y-m-d\\TH:i:s\\Z", strtotime( $Date['date'] ) );
	$params = array( 'Timestamp' => $d );
	$campaigns = getNewCampaigns( $params, $currentLogin );
	if ( isset ( $campaigns ) )
	{
		foreach ( $campaigns as $obj )
		{
			$sql = "INSERT  INTO campaigns (Yandex_login ,Id_campaign, Campaign_name) values
 ('" . $row['Yandex_login'] . "', '" . $obj['Id'] . "', '" . $obj['Name'] . "');";
			$conn->query( $sql );
		}
	}
}
//записываем данные в таблицу api и удаляем старые записи
$sql = "SELECT Id_campaign FROM campaigns WHERE Yandex_login='" . $currentLogin . "'";
$allCampaignsIds = $conn->query( $sql );
if ( $allCampaignsIds->num_rows > 0 )
{
	$allId = array();
	while ( $Id = $allCampaignsIds->fetch_assoc() )
	{
		$currentId = $Id['Id_campaign'];
		
		$sql = "SELECT Date FROM api WHERE Id_campaign='" . $currentId . "' ORDER BY Date DESC LIMIT 1";
		$lastRecordDate = $conn->query( $sql );
		if ( $lastRecordDate->num_rows == 0 )
		{//если для джанной кампании нет записей в бд в таблице db
			$allId[] = intval( $currentId );
		}
		else
		{//смотрим последнюю дату и от нее записываем статистику
			$today = date( "Y-m-d", time() - 24*60*60 );
			$last = $lastRecordDate->fetch_assoc();
			if ( date( "Y-m-d", strtotime( $last['Date'] ) ) < date( "Y-m-d", time() - 24*60*60 ) )
			{
				addStatistics( $currentLogin, $currentId, date( "Y-m-d", strtotime( $last['Date'] ) + 24*60*60 ), $today );
			}
					
			//удаление старых записей{
			$sql = "SELECT Date,Id FROM api WHERE Id_campaign='" . $currentId . "' ORDER BY Date ASC";
			$dates = $conn->query( $sql );
			if ( $dates->num_rows > 0 )
			{
				while ( $d = $dates->fetch_assoc() )
				{
					if ( date( "Y-m-d", strtotime( $d['Date'] ) ) < date( "Y-m-d", time() - 150*24*60*60 ) )
					{
						pre( $d );
						$sql = "DELETE FROM api WHERE Id='" . $d['Id'] . "'";
						$conn->query( $sql );
					}
				}
			}
			//}удаление старых записей
		}
		
	}
	if ( count( $allId ) > 0 )
	{
		$createDates = getCreateDate( $allId, $currentLogin );
		if ( isset( $createDates ) )
		{
			foreach ( $createDates as $obj )
			{
				if ( $obj['StartDate'] > date( "Y-m-d", time() - 100*24*60*60 ) )
				{//если кампания создана в последние 30 дней:
					$today = date( "Y-m-d", time() - 24*60*60 );
					addStatistics( $currentLogin, $obj['Id'], date( "Y-m-d", strtotime( $obj['StartDate'] ) ), $today );
				}
				else//компания создана раньше чем месяц*2 назад
				{
					$today = date( "Y-m-d", time() - 24*60*60 );
					$firstDate = date( "Y-m-d", time() - 100*24*60*60 );
					addStatistics( $currentLogin, $obj['Id'], $firstDate, $today );
				}
			}
		}
	}
}

