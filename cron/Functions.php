<?php

if ( !defined( 'DIRECT' ) )
{
	exit();
}
if ( !defined( 'YII' ) )
{
	require_once '../../app.axora_configuration.php';
}
else
{
	require_once Yii::app()->basePath . '/../../app.axora_configuration.php';
}
$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE );

if ( $conn->connect_error )
{
	exit ( 'Connection error.' );
}
$sql = "USE " . DB_DATABASE;
$conn->query( $sql );


$sql = "SET CHARACTER SET 'utf8'";
$res = $conn->query( $sql );

function getNewCampaigns ($params, $Login)
{
	$request = array(
		'method' => 'checkCampaigns',
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
	$result = file_get_contents( 'https://api.direct.yandex.com/json/v5/changes', 0, $context );
	$result = json_decode( $result, true );
	
	if ( isset ( $result['result']['Campaigns'] ) )
	{
		
		$ids = $result['result']['Campaigns'];
		$arr = array();
		foreach ( $ids as $id )
		{
			$arr[] = $id['CampaignId'];
		}
		return getCampaignsNames( $arr, $Login );
	}
}

function getCampaignsNames ($ids, $Login)
{
	$params = array( 'SelectionCriteria' => array( 'States' => array( 'ON' , 'OFF', 'SUSPENDED'), 'Ids' => $ids ),
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
		return $result['result']['Campaigns'];
	}
	
}

function getCreateDate ($id, $Login)
{
	$params = array( 'SelectionCriteria' => array( 'States' => array( 'ON' , 'OFF', 'SUSPENDED'), 'Ids' => $id ),
	                 'FieldNames' => array( 'Name', 'Id', 'Statistics', 'State', 'StatusPayment', 'Status', 'StartDate' ) );
	
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
		return $result['result']['Campaigns'];
	}
}

function addStatistics ($Login, $Id, $StartDate, $EndDate)
{
	
	$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE );
	if ( $conn->connect_error )
	{
		exit ( 'Connection error.' );
	}
	$sql = "USE " . DB_DATABASE;
	$conn->query( $sql );
	$stat = @getStat( $Login, $Id, $StartDate, $EndDate );
	$lastDay = date( "Y-m-d", strtotime( $StartDate ) - 24*60*60 );
	$row = array();
	if ( count( $stat ) > 0 )
	{
		for ( $i = 0; $i < count( $stat ); ++$i )
		{
			$row = $stat[$i];
			
			if ( date( "Y-m-d", strtotime( $row['StatDate'] ) ) !== date( "Y-m-d", strtotime( $lastDay ) + 24*60*60 ) )
			{
				$zeroDays = strtotime( $row['StatDate'] ) - 24*60*60 - strtotime( $lastDay );
				$zeroDays = $zeroDays/( 24*60*60 );
				while ( $zeroDays != '0' )
				{
					$currentZeroDay = date( "Y-m-d", strtotime( $row['StatDate'] ) - 24*60*60*$zeroDays );
					
					$sql = "INSERT  INTO api (Id_campaign ,Date,Sum_search, Sum_context, Shows_search,
 Shows_context, Clicks_search,  	Clicks_context) values
('" . $row['CampaignID'] . "','" . $currentZeroDay . "', '0', '0', '0', '0', '0', '0');";
					$conn->query( $sql );
					
					$zeroDays -= 1;
				}
			}
			$sql = "INSERT  INTO api (Id_campaign ,Date,Sum_search, Sum_context, Shows_search,
 Shows_context, Clicks_search,  	Clicks_context) values
('" . $row['CampaignID'] . "','" . $row['StatDate'] . "', '" . $row['SumSearch'] . "', '" . $row['SumContext'] . "', '" . $row['ShowsSearch'] .
				"', '" . $row['ShowsContext'] . "', '" . $row['ClicksSearch'] . "', '" .
				$row['ClicksContext'] . "');";
			$conn->query( $sql );
			
			$lastDay = $row['StatDate'];
		}
	}
	if ( isset( $row['StatDate'] ) )
	{
		$StartDate = $row['StatDate'];
	}
	if ( date( "Y-m-d", strtotime( $StartDate ) ) !== date( "Y-m-d", strtotime( $EndDate ) ) )
	{
		$zeroDays = strtotime( $EndDate ) - strtotime( $StartDate );
		$zeroDays = $zeroDays/( 24*60*60 );
		while ( $zeroDays != '0' )
		{
			$currentZeroDay = date( "Y-m-d", strtotime( $EndDate ) - 24*60*60*$zeroDays + 24*60*60 );
			
			$sql = "INSERT  INTO api (Id_campaign ,Date,Sum_search, Sum_context, Shows_search,
 Shows_context, Clicks_search, Clicks_context) values
('" . $Id . "','" . $currentZeroDay . "', '0', '0', '0', '0', '0', '0');";
			$conn->query( $sql );
			$zeroDays -= 1;
		}
		
	}
	elseif ( count( $stat ) == 0 )
	{
		$sql = "INSERT  INTO api (Id_campaign ,Date,Sum_search, Sum_context, Shows_search,
 Shows_context, Clicks_search, Clicks_context) values
('" . $Id . "','" . $EndDate . "', '0', '0', '0', '0', '0', '0');";
		$conn->query( $sql );
	}
	
}

function getStat ($Login, $id, $StartDate, $EndDate)
{
	$params = array(
		'CampaignIDS' => array( $id ),
		'StartDate' => $StartDate,
		'EndDate' => $EndDate,
	);
	$request = array(
		'token' => $_SESSION['token'],
		'method' => 'GetSummaryStat',
		'param' => $params,
		'locale' => 'ru'
	);
	$request = json_encode( $request );
	
	$opts = array(
		'http' => array(
			'method' => 'POST',
			'Client-Login: ' . $Login,
			'content' => $request,
		)
	);
	$context = stream_context_create( $opts );
	$result = file_get_contents( 'https://api.direct.yandex.ru/live/v4/json', false, $context );
	$result = json_decode( $result, true );
	
	if ( isset( $result['data'] ) )
	{
		return $result['data'];
	}
}