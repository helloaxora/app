<?php
/* @var $this MarketerController */
/* @var $data Marketer */
?>


<div class="view">
	<table width="100%">
		<tr>
			<td>
				<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Name' ) ); ?>:</b>
				<?php echo CHtml::link( CHtml::encode( $data->Name ), array( 'view', 'id' => $data->Id ) ); ?>
				<br/>
				
				<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Phone' ) ); ?>:</b>
				<?php echo CHtml::encode( $data->Phone ); ?>
				<br/>
				
				<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Email' ) ); ?>:</b>
				<?php echo CHtml::encode( $data->Email ); ?>
				<br/>
			</td>
			<td align="center">
				<?php echo CHtml::image( Yii::app()->request->baseUrl . '/images/' . CHtml::encode( $data->Photo ), "", array( "height" => 150, "width" => 150, "align"=>"right" ) ); ?>
				
			</td>
		</tr>
	</table>
</div>