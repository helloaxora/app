<?php
/* @var $this MarketerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Marketers',
);

$this->menu=array(
	array('label'=>'Create Marketer', 'url'=>array('create')),
	array('label'=>'Manage Marketer', 'url'=>array('admin')),
);
?>

<h1>Маркетологи</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
