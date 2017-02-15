<?php
/* @var $this MarketerController */
/* @var $model Marketer */

$this->breadcrumbs=array(
	'Marketers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Marketer', 'url'=>array('index')),
	array('label'=>'Manage Marketer', 'url'=>array('admin')),
);
?>

<h1>Создание маркетолога</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>