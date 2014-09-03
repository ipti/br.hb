<?php
/* @var $this ConsultationController */
/* @var $model Consultation */

$this->breadcrumbs=array(
	'Consultations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Consultation', 'url'=>array('index')),
	array('label'=>'Manage Consultation', 'url'=>array('admin')),
);
?>

<h1>Create Consultation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>