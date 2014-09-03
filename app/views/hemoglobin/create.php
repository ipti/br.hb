<?php
/* @var $this HemoglobinController */
/* @var $model Hemoglobin */

$this->breadcrumbs=array(
	'Hemoglobins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Hemoglobin', 'url'=>array('index')),
	array('label'=>'Manage Hemoglobin', 'url'=>array('admin')),
);
?>

<h1>Create Hemoglobin</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>