<tr>
	<td><?php echo date( "d.m.Y", strtotime( $apiStatistics[$i]['Date'] ) ); ?></td>
	<td><?php echo $apiStatistics[$i]['Shows_search']; ?></td>
	<td><?php echo $apiStatistics[$i]['Clicks_search']; ?></td>
	<td><?php
		if ( $apiStatistics[$i]['Shows_search'] != 0 )
		{
			pr2( $apiStatistics[$i]['Clicks_search']*100/$apiStatistics[$i]['Shows_search'] );
		}
		else
		{
			echo '0';
		}
		?></td>
	<td><?php
		if ( $apiStatistics[$i]['Clicks_search'] != 0 )
		{
			pr2( $apiStatistics[$i]['Sum_search']/$apiStatistics[$i]['Clicks_search'] );
		}
		else
		{
			echo '0';
		} ?></td>
	<td><?php pr2( $apiStatistics[$i]['Sum_search'] ); ?></td>
</tr>