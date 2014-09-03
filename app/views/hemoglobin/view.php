<?php
/* @var $this HemoglobinController */
/* @var $model Hemoglobin */

$this->breadcrumbs=array(
	'Hemoglobins'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Hemoglobin', 'url'=>array('index')),
	array('label'=>'Create Hemoglobin', 'url'=>array('create')),
	array('label'=>'Update Hemoglobin', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Hemoglobin', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Hemoglobin', 'url'=>array('admin')),
);
?>

<h1>View Hemoglobin #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'agreed_term',
		'rate',
		'sample',
	),
)); ?>
