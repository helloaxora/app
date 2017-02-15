<?php
if ( isset( $_POST['period'] ) )
{
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
	$sql = "SELECT * FROM api WHERE Id_campaign='" . $_POST['campaign'] . "' ORDER BY Date DESC";
	$res = $conn->query( $sql );
	
	
	$statistics = array();
	for ( $i = 0; $i < $_POST['numberOfDays']; $i++ )
	{
		$statistics[] = $res->fetch_assoc();
	}
	
	if ( $_POST['period'] == 'yesterday' )
	{
		statPerDay( $statistics );
	}
	else if ( $_POST['period'] == 'week' )
	{
		
		statPerWeek( $statistics );
	}
	else if ( $_POST['period'] == 'month' )
	{
		
		statPerMonth( $statistics );
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
	echo json_encode( $data );
	
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
	echo json_encode( $data );
	
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
	echo json_encode( $data );
	
}
