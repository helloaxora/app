<?php

function month ($i)
{
	switch ( $i )
	{
		case 1:
			return "января";
			break;
		case 2:
			return "февраля";
			break;
		case 3:
			return "марта";
			break;
		case 4:
			return "апреля";
			break;
		case 5:
			return "мая";
			break;
		case 6:
			return "июня";
			break;
		case 7:
			return "июля";
			break;
		case 8:
			return "августа";
			break;
		case 9:
			return "сентября";
			break;
		case 10:
			return "октября";
			break;
		case 11:
			return "ноября";
			break;
		case 12:
			return "декабря";
			break;
	}
}


function statisticsPerPeriod ($info)
{
	if ( $_GET['period'] == 'day' )
	{
		return statPerDay( $info );
	}
	else if ( $_GET['period'] == 'week' )
	{
		
		return statPerWeek( $info );
	}
	else if ( $_GET['period'] == 'month' )
	{
		
		return statPerMonth( $info );
	}
}

function statPerDay ($info)
{
	$data[] = array();
	if ( isset( $info[0]['Shows_search'] ) )
	{
		$data['shows'] = $info[0]['Shows_search'];
	}
	else
	{
		$data['shows'] = 0;
	}
	if ( isset( $info[0]['Clicks_search'] ) )
	{
		$data['clicks'] = $info[0]['Clicks_search'];
	}
	else
	{
		$data['clicks'] = 0;
	}
	if ( isset( $info[0]['Sum_search'] ) )
	{
		$data['sum'] = $info[0]['Sum_search'];
	}
	else
	{
		$data['sum'] = 0;
	}
	if ( $data['clicks'] == 0 )
	{
		$data['ctr'] = 0;
	}
	else
	{
		$data['ctr'] = $data['clicks']*100/$data['shows'];
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = $data['sum']/$data['clicks'];
	}
	return $data;
	
}

function statPerWeek ($info)
{
	$data[] = array();
	$data['shows'] = 0;
	$data['clicks'] = 0;
	$data['sum'] = 0;
	if ( count( $info ) != 0 )
	{
		for ( $i = 0; $i < 7; $i++ )
		{
			$data['shows'] += $info[$i]['Shows_search'];
			$data['clicks'] += $info[$i]['Clicks_search'];
			$data['sum'] += $info[$i]['Sum_search'];
		}
	}
	else
	{
		$data['shows'] += 0;
		$data['clicks'] += 0;
		$data['sum'] = 0;
	}
	if ( $data['clicks'] == 0 )
	{
		$data['ctr'] = 0;
	}
	else
	{
		$data['ctr'] = $data['clicks']*100/$data['shows'];
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = $data['sum']/$data['clicks'];
	}
	return $data;
	
}

function statPerMonth ($info)
{
	$data[] = array();
	$data['shows'] = 0;
	$data['clicks'] = 0;
	$data['sum'] = 0;
	if ( count( $info ) != 0 )
	{
		for ( $i = 0; $i < 30; $i++ )
		{
			$data['shows'] += $info[$i]['Shows_search'];
			$data['clicks'] += $info[$i]['Clicks_search'];
			$data['sum'] += $info[$i]['Sum_search'];
		}
	}
	else
	{
		$data['shows'] += 0;
		$data['clicks'] += 0;
		$data['sum'] = 0;
	}
	if ( $data['clicks'] == 0 )
	{
		$data['ctr'] = 0;
	}
	else
	{
		$data['ctr'] = $data['clicks']*100/$data['shows'];
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = $data['sum']/$data['clicks'];
	}
	return $data;
	
}

function getBalance ()
{
	require_once Yii::app()->basePath . '/../../app.axora_configuration.php';
	$resultArray = array();
	$_SESSION['token'] = YANDEX_TOKEN;
	$currentClient = Yii::app()->user->name;
	
	$params = array(
		"Action" => 'Get',
		'SelectionCriteria' => array( 'Logins' => array( $currentClient ) )
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
	$balance = json_decode( $result, true );
	
	if ( !empty( $balance['data']['Accounts'][0]['Amount'] ) )
	{
		$resultArray['sum'] = $balance['data']['Accounts'][0]['Amount'];
		if ( !isset( $balance['data']['Accounts'][0]['Currency'] ) )
		{
			$resultArray['currency'] = 'у.е.';
		}
		else
		{
			$resultArray['currency'] = $balance['data']['Accounts'][0]['Currency'];
		}
		if ( $resultArray['currency'] == 'BYN' )
		{
			$resultArray['currency'] = 'р.';
		}
	}
	else
	{
		$resultArray['sum'] = '0';
		$resultArray['currency'] = 'у.е.';
	}
	return $resultArray;
}

function countZeroDays ($statistics)
{
	$zeroDays = 0;
	$days = 0;
	foreach ( $statistics as $day )
	{
		if ( $days > 30 )
		{
			break;
		}
		if (
			$day['Shows_search'] == '0' &&
			$day['Shows_context'] == '0' &&
			$day['Clicks_search'] == '0' &&
			$day['Clicks_context'] == '0' &&
			$day['Sum_search'] == '0' &&
			$day['Sum_context'] == '0'
		)
		{
			$zeroDays++;
			echo $day['date'];
		}
		else
		{
			$days++;
		}
	}
	return $zeroDays;
}

function isZeroDay ($day)
{
	return ( $day['Shows_search'] == '0' &&
		$day['Clicks_search'] == '0' &&
		$day['Sum_search'] == '0' );
}

function getDayWord ($day)
{
	if ( $day == 0 || ( $day >= 5 && $day <= 20 ) )
	{
		return "дней";
	}
	else
	{
		$day = $day%10;
		switch ( $day )
		{
			case ( 1 ):
				return "день";
				break;
			case ( 2 ):
			case ( 3 ):
			case ( 4 ):
				return "дня";
				break;
			default:
				return "дней";
		}
	}
}

function pr2 ($i)
{
	if ( $i == 0 )
	{
		echo 0;
	}
	else
	{
		echo number_format( $i, 2, ',', ' ' );
	}
}

function pr0 ($i)
{
	if ( $i == 0 )
	{
		echo 0;
	}
	else
	{
		echo number_format( $i, 0, ',', ' ' );
	}
}

function getAvCampaign ($currentClient)
{
	$allCampaigns = Yii::app()->db->createCommand()->select( 'Id_campaign' )->from( 'campaigns' )
		->where( 'Yandex_login=:login', array( ':login' => $currentClient ) )->queryAll();
	$averageSum = 0;
	$allDays = 0;
	foreach ( $allCampaigns as $id )
	{
		$sum = 0;
		$days = 0;
		$allStatisticsForOneCampaign = Yii::app()->db->createCommand()->select( '*' )->from( 'api' )
			->where( 'Id_campaign=:id', array( ':id' => $id['Id_campaign'] ) )->order( 'Date DESC' )->queryAll();
		foreach ( $allStatisticsForOneCampaign as $oneDayStatistics )
		{
			if ( $oneDayStatistics['Sum_search'] != '0' || $oneDayStatistics['Sum_context'] != '0' )
			{
				$sum += $oneDayStatistics['Sum_search'];
				$sum += $oneDayStatistics['Sum_context'];
				$days++;
			}
			if ( $days > 8 )
			{
				break;
			}
		}
		if ( $days > $allDays )
		{
			$allDays = $days;
		}
		if ( $days != 0 )
		{
			$averageSumForOneCampaign = $sum/$days;
			$averageSum += $averageSumForOneCampaign;
		}
	}
	$arr['sum'] = $averageSum;
	$arr['days'] = $allDays;
	return $arr;
}