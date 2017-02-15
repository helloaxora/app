<?php
function statPerDaySearch ($info)
{
	$data = array();
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
		$data['ctr'] = pr2( $data['clicks']*100/$data['shows'] );
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = pr2( $data['sum']/$data['clicks'] );
	}
	$data['sum'] = pr2( $data['sum'] );
	$data['shows'] = number_format( $data['shows'], 0, ',', ' ' );
	$data['clicks'] = number_format( $data['clicks'], 0, ',', ' ' );
	$data['sum'] .= ' <small>' . $_POST['currency'] . '</small>';
	$data['ctr'] .= ' <small>%</small>';
	$data['avPrice'] .= ' <small>' . $_POST['currency'] . '</small>';
	return $data;
	
}

function statPerDayContext ($info)
{
	$data = array();
	if ( isset( $info[0]['Shows_context'] ) )
	{
		$data['shows'] = $info[0]['Shows_context'];
	}
	else
	{
		$data['shows'] = 0;
	}
	if ( isset( $info[0]['Clicks_context'] ) )
	{
		$data['clicks'] = $info[0]['Clicks_context'];
	}
	else
	{
		$data['clicks'] = 0;
	}
	if ( isset( $info[0]['Sum_context'] ) )
	{
		$data['sum'] = $info[0]['Sum_context'];
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
		$data['ctr'] = pr2( $data['clicks']*100/$data['shows'] );
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = pr2( $data['sum']/$data['clicks'] );
	}
	$data['sum'] = pr2( $data['sum'] );
	$data['shows'] = number_format( $data['shows'], 0, ',', ' ' );
	$data['clicks'] = number_format( $data['clicks'], 0, ',', ' ' );
	$data['sum'] .= ' <small>' . $_POST['currency'] . '</small>';
	$data['ctr'] .= ' <small>%</small>';
	$data['avPrice'] .= ' <small>' . $_POST['currency'] . '</small>';
	return  $data;
	
}

function statPerWeekSearch ($info)
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
	if ( $data['clicks'] == 0 )
	{
		$data['ctr'] = 0;
	}
	else
	{
		$data['ctr'] = pr2( $data['clicks']*100/$data['shows'] );
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = pr2( $data['sum']/$data['clicks'] );
	}
	$data['sum'] = pr2( $data['sum'] );
	$data['shows'] = number_format( $data['shows'], 0, ',', ' ' );
	$data['clicks'] = number_format( $data['clicks'], 0, ',', ' ' );
	$data['sum'] .= ' <small>' . $_POST['currency'] . '</small>';
	$data['ctr'] .= ' <small>%</small>';
	$data['avPrice'] .= ' <small>' . $_POST['currency'] . '</small>';
	return $data;
	
}

function statPerWeekContext ($info)
{
	$data[] = array();
	
	$data['shows'] = 0;
	$data['clicks'] = 0;
	$data['sum'] = 0;
	if ( count( $info ) != 0 )
	{
		for ( $i = 0; $i < 7; $i++ )
		{
			$data['shows'] += $info[$i]['Shows_context'];
			$data['clicks'] += $info[$i]['Clicks_context'];
			$data['sum'] += $info[$i]['Sum_context'];
		}
	}
	if ( $data['clicks'] == 0 )
	{
		$data['ctr'] = 0;
	}
	else
	{
		$data['ctr'] = pr2( $data['clicks']*100/$data['shows'] );
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = pr2( $data['sum']/$data['clicks'] );
	}
	$data['sum'] = pr2( $data['sum'] );
	$data['shows'] = number_format( $data['shows'], 0, ',', ' ' );
	$data['clicks'] = number_format( $data['clicks'], 0, ',', ' ' );
	$data['sum'] .= ' <small>' . $_POST['currency'] . '</small>';
	$data['ctr'] .= ' <small>%</small>';
	$data['avPrice'] .= ' <small>' . $_POST['currency'] . '</small>';
	return $data;
	
}

function statPerMonthSearch ($info)
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
	
	if ( $data['clicks'] == 0 )
	{
		$data['ctr'] = 0;
	}
	else
	{
		$data['ctr'] = pr2( $data['clicks']*100/$data['shows'] );
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = pr2( $data['sum']/$data['clicks'] );
	}
	$data['sum'] = pr2( $data['sum'] );
	$data['shows'] = number_format( $data['shows'], 0, ',', ' ' );
	$data['clicks'] = number_format( $data['clicks'], 0, ',', ' ' );
	$data['sum'] .= ' <small>' . $_POST['currency'] . '</small>';
	$data['ctr'] .= ' <small>%</small>';
	$data['avPrice'] .= ' <small>' . $_POST['currency'] . '</small>';
	
	return $data;
	
}

function statPerMonthContext ($info)
{
	$data[] = array();
	$data['shows'] = 0;
	$data['clicks'] = 0;
	$data['sum'] = 0;
	if ( count( $info ) != 0 )
	{
		for ( $i = 0; $i < 30; $i++ )
		{
			$data['shows'] += $info[$i]['Shows_context'];
			$data['clicks'] += $info[$i]['Clicks_context'];
			$data['sum'] += $info[$i]['Sum_context'];
		}
		
	}
	
	if ( $data['clicks'] == 0 )
	{
		$data['ctr'] = 0;
	}
	else
	{
		$data['ctr'] = pr2( $data['clicks']*100/$data['shows'] );
	}
	if ( $data['clicks'] == 0 )
	{
		$data['avPrice'] = 0;
	}
	else
	{
		$data['avPrice'] = pr2( $data['sum']/$data['clicks'] );
	}
	$data['sum'] = pr2( $data['sum'] );
	$data['shows'] = number_format( $data['shows'], 0, ',', ' ' );
	$data['clicks'] = number_format( $data['clicks'], 0, ',', ' ' );
	$data['sum'] .= ' <small>' . $_POST['currency'] . '</small>';
	$data['ctr'] .= ' <small>%</small>';
	$data['avPrice'] .= ' <small>' . $_POST['currency'] . '</small>';
	
	return $data;
	
}

function pr2 ($i)
{
	if ( $i == 0 )
	{
		return 0;
	}
	else
	{
		return number_format( $i, 2, ',', ' ' );
	}
}

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