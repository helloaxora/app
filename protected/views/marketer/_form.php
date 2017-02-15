<?php
/* @var $this MarketerController */
/* @var $model Marketer */
/* @var $form CActiveForm */
?>

<div class="form">
	
	<?php $form = $this->beginWidget( 'CActiveForm', array(
		'id' => 'marketer-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation' => true,
		'enableClientValidation' => true,
		'stateful' => true,
		'htmlOptions' => array( 'enctype' => 'multipart/form-data' ),
	) ); ?>
	
	<p class="note">Fields with <span class="required">*</span> are required.</p>
	
	<?php echo $form->errorSummary( $model ); ?>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'Name' ); ?>
		<?php echo $form->textField( $model, 'Name', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'Name' ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'Phone' ); ?>
		<?php echo $form->textField( $model, 'Phone', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'Phone' ); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx( $model, 'Email' ); ?>
		<?php echo $form->textField( $model, 'Email', array( 'size' => 60, 'maxlength' => 255 ) ); ?>
		<?php echo $form->error( $model, 'Email' ); ?>
	</div>
	<?php echo $model->photo; ?>
	<div class="row">
		<?php echo $form->labelEx( $model, 'Photo' ); ?>
		<?php echo $form->fileField( $model, 'Photo', array( "height" => 20, "width" => 200 ) ); ?>
		<?php echo $form->error( $model, 'Photo' ); ?>
	</div>
	
	<?php if ( $model->isNewRecord != '1' )
	{ ?>
		<div class="row">
			<?php echo CHtml::image( Yii::app()->request->baseUrl . '/images/' . $model->Photo, "", array( "height" => 200, "width" => 200 ) );			?>
		</div>
	<?php } ?>
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton( $model->isNewRecord ? 'Create' : 'Save' ); ?>
	</div>
	
	<?php $this->endWidget(); ?>

</div><!-- form -->