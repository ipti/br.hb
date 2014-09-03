<?php
/* @var $this AnatomyController */
/* @var $model Anatomy */

$this->breadcrumbs=array(
	'Anatomies'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Anatomy', 'url'=>array('index')),
	array('label'=>'Create Anatomy', 'url'=>array('create')),
	array('label'=>'Update Anatomy', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Anatomy', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Anatomy', 'url'=>array('admin')),
);
?>

<h1>View Anatomy #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'student',
		'weight',
		'height',
		'date',
	),
)); ?>
