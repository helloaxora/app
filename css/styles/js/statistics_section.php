<?php
if ( isset( $_POST['period'] ) )
{
	require_once( __DIR__. '/../../../../app.axora_configuration.php' );
	$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE );
	
	if ( $conn->connect_error )
	{
		exit ( 'Connection error.' );
	}
	$sql = "USE " . DB_DATABASE;
	$conn->query( $sql );
	require_once "functions.php";
	$sql = "SET CHARACTER SET 'utf8'";
	$res = $conn->query( $sql );
	$sql = "SELECT * FROM api WHERE Id_campaign='" . $_POST['campaign'] . "' ORDER BY Date DESC";
	$res = $conn->query( $sql );
	
	
	$statistics = array();
	if ( $res->num_rows != 0 )
	{
		while ( $data = $res->fetch_assoc() )
		{
			$statistics[] = $data;
		}
		$arr = array();
		if ( $_POST['period'] == 'day' )
		{
			if ( $_POST['type'] == 'search' )
			{
				$arr = statPerDaySearch( $statistics );
			}
			else
			{
				$arr = statPerDayContext( $statistics );
			}
		}
		else if ( $_POST['period'] == 'week' )
		{
			if ( $_POST['type'] == 'search' )
			{
				$arr = statPerWeekSearch( $statistics );
			}
			else
			{
				$arr = statPerWeekContext( $statistics );
			}
		}
		else if ( $_POST['period'] == 'month' )
		{
			if ( $_POST['type'] == 'search' )
			{
				$arr = statPerMonthSearch( $statistics );
			}
			else
			{
				$arr = statPerMonthContext( $statistics );
			}
		}
		echo json_encode( $arr );
	}
	
}
