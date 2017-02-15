<?php
/* @var $this ClientController */
/* @var $model Client */

$this->breadcrumbs=array(
	'Clients'=>array('index'),
	'Add',
);

$this->menu=array(
	array('label'=>'List Client', 'url'=>array('index')),
	array('label'=>'Manage Client', 'url'=>array('admin')),
);
?>
	<h1>Create NEW Client</h1>

<?php $this->renderPartial('_formAdd', array('model'=>$model)); ?>