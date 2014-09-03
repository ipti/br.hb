<?php
/* @var $this TermController */
/* @var $model Term */

$this->breadcrumbs=array(
	'Terms'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Term', 'url'=>array('index')),
	array('label'=>'Manage Term', 'url'=>array('admin')),
);
?>

<h1>Create Term</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>