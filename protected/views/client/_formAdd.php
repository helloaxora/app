<?php
/* @var $this ClientController */
/* @var $model Client */
/* @var $form CActiveForm */
?>

<div class="form">
	
	<?php $form = $this->beginWidget( 'CActiveForm', array(
		'id' => 'client-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => true,
	) ); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php echo $form->errorSummary( $model ); ?>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'login' ); ?>
		<?php echo $form->textField( $model, 'login', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'login' ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'name' ); ?>
		<?php echo $form->textField( $model, 'name', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'name' ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'surname' ); ?>
		<?php echo $form->textField( $model, 'surname', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'surname' ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'currency' ); ?>
		<?php echo $form->dropDownList( $model, 'currency', array( 'BYN' => 'BYN	', 'cu' => 'условн единицы', 'EUR' => 'евро' ), array( 'style' => 'width: 390px' ) ); ?>
		<?php echo $form->error( $model, 'currency' ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'Send_msg'); ?>
		<?php echo $form->checkBox( $model, 'Send_msg');?>
		<?php echo $form->error($model,'Send_msg'); ?>
	</div>
	____________________________________________________________________________
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'Email_for_notifications' ); ?>
		<?php echo $form->textField( $model, 'Email_for_notifications', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'Email_for_notifications' ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'Phone_for_notifications' ); ?>
		<?php echo $form->textField( $model, 'Phone_for_notifications', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'Phone_for_notifications' ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'Company_name' ); ?>
		<?php echo $form->textField( $model, 'Company_name', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'Company_name' ); ?>
	</div>
	
	<?php //!!!!!!!!!!!!
	$marketers = Yii::app()->db->createCommand( 'SELECT (name) FROM marketer' )->queryAll();
	foreach ( $marketers as $one )
	{
		$params[$one['name']] = $one['name'];
	}
	?>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'Name_marketer' ); ?>
		<?php echo $form->dropDownList( $model, 'Name_marketer', $params, array( 'style' => 'width: 390px' ) ); ?>
		<?php echo $form->error( $model, 'Name_marketer' ); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton( $model->isNewRecord ? 'Create' : 'Save' ); ?>
	</div>
	
	<?php $this->endWidget(); ?>

</div><!-- form -->
