<?php
/* @var $this MarketerController */
/* @var $model Marketer */

$this->breadcrumbs=array(
	'Marketers'=>array('index'),
	$model->Name=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Marketer', 'url'=>array('index')),
	array('label'=>'Create Marketer', 'url'=>array('create')),
	array('label'=>'View Marketer', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Marketer', 'url'=>array('admin')),
);
?>

<h1>Update Marketer <?php echo $model->Id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>