<?php
/* @var $this MarketerController */
/* @var $model Marketer */


$this->breadcrumbs=array(
	'Marketers'=>array('index'),
	$model->Name,
);

$this->menu=array(
	array('label'=>'Список маркетологов', 'url'=>array('index')),
	array('label'=>'Создать маркетолога', 'url'=>array('create')),
	array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Marketer', 'url'=>array('admin')),
);
?>

<h1>View Marketer <?php echo $model->Name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Name',
		'Phone',
		'Email',
	),
)); ?>
