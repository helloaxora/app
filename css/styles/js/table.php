<?php
function zeroCell($str)
{
	$cell='<div class="row">
			<div class="side_l"><hr class="zeroCell">
			</div>
			<div class="middle">'.$str.'</div>
			<div class="side_r"><hr class="zeroCell">
			</div>
		</div>';
	return $cell;
}

function isZeroDaySearch ($day)
{
	return ( $day['Shows_search'] == '0' &&
		$day['Clicks_search'] == '0' &&
		$day['Sum_search'] == '0' );
}

function isZeroDayContext ($day)
{
	return ( $day['Shows_context'] == '0' &&
		$day['Clicks_context'] == '0' &&
		$day['Sum_context'] == '0' );
}

if ( isset( $_POST['campaign'] ) )
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
	for ( $i = 0; $i < $_POST['numberOfDays']; $i++ )
	{
		$statistics[] = $res->fetch_assoc();
	}
	
	$table = '<table class="responsive-table campaign-statistics-table">
						<tr><th>Дата</th>
							<th>Показы</th>
							<th>Клики</th>
							<th>CTR, %</th>
							<th>Средняя цена клика</th>
							<th>Дневной расход, ' . $_POST['currency'] . '</th></tr><tbody>';
	$arr = array();
	
	if ( $_POST['type'] == 'search' )
	{
		
		for ( $i = 0; $i < $_POST['numberOfDays']; $i++ )
		{
			if ( ( isZeroDaySearch( $statistics[$i] ) && $i == $_POST['numberOfDays'] - 1 )
				||
				( isZeroDaySearch( $statistics[$i] ) && !isZeroDaySearch( $statistics[$i + 1] ) )
			)
			{
				$table .= '<tr class="zeroCell"><td>' . date( "d.m.Y", strtotime( $statistics[$i]['Date'] ) ) . '</td>
	<td colspan="5">'.zeroCell(' показов не было ').'</td></tr>';
			}
			elseif ( isZeroDaySearch( $statistics[$i] ) && isZeroDaySearch( $statistics[$i + 1] ) )
			{
				$lastDay = $statistics[$i]['Date'];
				while ( isZeroDaySearch( $statistics[$i] ) && $i < $_POST['numberOfDays'] )
				{
					$i++;
				}
				$i -= 1;
				
				$firstDay = $statistics[$i]['Date'];
				$firstDay = date_parse( date( 'Y-m-d', strtotime( $firstDay ) ) );
				$lastDay = date_parse( date( 'Y-m-d', strtotime( $lastDay ) ) );
				$period = $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' &#8212 ' . $lastDay['day'] . ' ' . month( $lastDay['month'] );
				
				$table .= '<tr class="zeroCell"><td ><font align="center">. . .</font></td><td colspan="5">
'.zeroCell(' '.$period .' показов не было ').'
</td></tr>';
				
			}
			else
			{
				$table .= '<tr><td>' . date( "d.m.Y", strtotime( $statistics[$i]['Date'] ) ) . '</td>';
				$table .= '<td>' . $statistics[$i]['Shows_search'] . '</td>';
				$table .= '<td>' . $statistics[$i]['Clicks_search'] . '</td>';
				if ( $statistics[$i]['Shows_search'] != 0 )
				{
					$table .= '<td>' . pr2( $statistics[$i]['Clicks_search']*100/$statistics[$i]['Shows_search'] ) . '</td>';
				}
				else
				{
					$table .= '<td>0</td>';
				}
				if ( $statistics[$i]['Clicks_search'] != 0 )
				{
					$table .= '<td>' . pr2( $statistics[$i]['Sum_search']/$statistics[$i]['Clicks_search'] ) . '</td>';
				}
				else
				{
					$table .= '<td>0</td>';
				}
				$table .= '<td>' . pr2( $statistics[$i]['Sum_search'] ) . '</td></tr>';
			}
			
		}
		if ( $_POST['numberOfDays'] == 0 )
		{
			$firstDay = date_parse( date( 'Y-m-d', strtotime( "-1 days" ) ) );
			$lastDay = date_parse( date( 'Y-m-d', strtotime( "-30 days" ) ) );
			$mainDates = $lastDay['day'] . ' ' . month( $lastDay['month'] ) . ' &#8212 ' . $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' ' . $lastDay['year'];
			
			$table .= '<tr class="zeroCell"><td><font align="center">. . .</font></td><td colspan="5">
					'.zeroCell(' '.$mainDates .' показов не было ').'
					</td></tr>';
		}
		
		
		$table .= '</tbody></table>';
		$arr['table'] = $table;
		
		if($_POST['period']=='day')
		{
			$arr['stat']=statPerDaySearch($statistics);
		}
		elseif($_POST['period']=='week')
		{
			$arr['stat']=statPerWeekSearch($statistics);
		}
		elseif($_POST['period']=='month')
		{
			$arr['stat']=statPerMonthSearch($statistics);
		}
		
		echo json_encode( $arr );
		
	}
	else
	{
		
		for ( $i = 0; $i < $_POST['numberOfDays']; $i++ )
		{
			if ( ( isZeroDayContext( $statistics[$i] ) && $i == $_POST['numberOfDays'] - 1 )
				||
				( isZeroDayContext( $statistics[$i] ) && !isZeroDayContext( $statistics[$i + 1] ) )
			)
			{
				$table .= '<tr class="zeroCell"><td>' . date( "d.m.Y", strtotime( $statistics[$i]['Date'] ) ) . '</td>
	<td colspan="5">'.zeroCell(' показов не было ').'</td></tr>';
			}
			elseif ( isZeroDayContext( $statistics[$i] ) && isZeroDayContext( $statistics[$i + 1] ) )
			{
				$lastDay = $statistics[$i]['Date'];
				while ( isZeroDayContext( $statistics[$i] ) && $i < $_POST['numberOfDays'] )
				{
					$i++;
				}
				$i -= 1;
				
				$firstDay = $statistics[$i]['Date'];
				$firstDay = date_parse( date( 'Y-m-d', strtotime( $firstDay ) ) );
				$lastDay = date_parse( date( 'Y-m-d', strtotime( $lastDay ) ) );
				$period = $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' &#8212 ' . $lastDay['day'] . ' ' . month( $lastDay['month'] );
				
				$table .= '<tr class="zeroCell"><td ><font align="center">. . .</font></td><td colspan="5">
'.zeroCell(' '.$period .' показов не было ').'
</td></tr>';
				
			}
			else
			{
				$table .= '<tr><td>' . date( "d.m.Y", strtotime( $statistics[$i]['Date'] ) ) . '</td>';
				$table .= '<td>' . $statistics[$i]['Shows_context'] . '</td>';
				$table .= '<td>' . $statistics[$i]['Clicks_context'] . '</td>';
				if ( $statistics[$i]['Shows_context'] != 0 )
				{
					$table .= '<td>' . pr2( $statistics[$i]['Clicks_context']/$statistics[$i]['Shows_context'] ) . '</td>';
				}
				else
				{
					$table .= '<td>0</td>';
				}
				if ( $statistics[$i]['Clicks_context'] != 0 )
				{
					$table .= '<td>' . pr2( $statistics[$i]['Sum_context']/$statistics[$i]['Clicks_context'] ) . '</td>';
				}
				else
				{
					$table .= '<td>0</td>';
				}
				$table .= '<td>' . pr2( $statistics[$i]['Sum_context'] ) . '</td></tr>';
			}
		}
		if ( $_POST['numberOfDays'] == 0 )
		{
			$firstDay = date_parse( date( 'Y-m-d', strtotime( "-1 days" ) ) );
			$lastDay = date_parse( date( 'Y-m-d', strtotime( "-30 days" ) ) );
			$mainDates = $lastDay['day'] . ' ' . month( $lastDay['month'] ) . ' &#8212 ' . $firstDay['day'] . ' ' . month( $firstDay['month'] ) . ' ' . $lastDay['year'];
			
			$table .= '<tr class="zeroCell"><td><font align="center">. . .</font></td><td colspan="5">
'.zeroCell(' '.$mainDates .' показов не было ').'</td></tr>';
		}
		
		$table .= '</tbody></table>';
		$arr['table'] = $table;
		
		if($_POST['period']=='day')
		{
			$arr['stat']=statPerDayContext($statistics);
		}
		elseif($_POST['period']=='week')
		{
			$arr['stat']=statPerWeekContext($statistics);
		}
		elseif($_POST['period']=='month')
		{
			$arr['stat']=statPerMonthContext($statistics);
		}
		echo json_encode( $arr );
		
	}
	
	
}