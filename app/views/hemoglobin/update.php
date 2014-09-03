<?php
/* @var $this HemoglobinController */
/* @var $model Hemoglobin */

$this->breadcrumbs=array(
	'Hemoglobins'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Hemoglobin', 'url'=>array('index')),
	array('label'=>'Create Hemoglobin', 'url'=>array('create')),
	array('label'=>'View Hemoglobin', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Hemoglobin', 'url'=>array('admin')),
);
?>

<h1>Update Hemoglobin <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>