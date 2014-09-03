<?php
/* @var $this AnatomyController */
/* @var $model Anatomy */

$this->breadcrumbs=array(
	'Anatomies'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Anatomy', 'url'=>array('index')),
	array('label'=>'Manage Anatomy', 'url'=>array('admin')),
);
?>

<h1>Create Anatomy</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>