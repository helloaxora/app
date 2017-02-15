<?php
/* @var $this InvoiceController */
/* @var $data Invoice */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->Id), array('view', 'id'=>$data->Id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Yandex_login')); ?>:</b>
	<?php echo CHtml::encode($data->Yandex_login); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sum_Yandex')); ?>:</b>
	<?php echo CHtml::encode($data->Sum_Yandex); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Sum_Google')); ?>:</b>
	<?php echo CHtml::encode($data->Sum_Google); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Date')); ?>:</b>
	<?php echo CHtml::encode($data->Date); ?>
	<br />


</div>