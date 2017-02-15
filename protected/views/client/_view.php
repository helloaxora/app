<?php
/* @var $this ClientController */
/* @var $data Client */
?>

<div class="view">
	
	<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Yandex_login' ) ); ?>:</b>
	<?php echo CHtml::link( CHtml::encode( $data->Yandex_login ), array( 'view', 'id' => $data->Id ) ); ?>
	<br/>
	
	<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Password' ) ); ?>:</b>
	<?php echo CHtml::encode( $data->Password ); ?>
	<br/>
	
	<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Email_for_notifications' ) ); ?>:</b>
	<?php echo CHtml::encode( $data->Email_for_notifications ); ?>
	<br/>
	
	<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Phone_for_notifications' ) ); ?>:</b>
	<?php echo CHtml::encode( $data->Phone_for_notifications ); ?>
	<br/>
	
	<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Company_name' ) ); ?>:</b>
	<?php echo CHtml::encode( $data->Company_name ); ?>
	<br/>
	
	<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Name_marketer' ) ); ?>:</b>
	<?php echo CHtml::encode( $data->Name_marketer ); ?>
	<br/>
	
	<b><?php echo CHtml::encode( $data->getAttributeLabel( 'Send_msg' ) ); ?>:</b>
	<?php echo CHtml::encode( $data->Send_msg ); ?>
	<br/>


</div>