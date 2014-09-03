<?php
/* @var $this AddressController */
/* @var $model Address */

$this->breadcrumbs=array(
	'Addresses'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Address', 'url'=>array('index')),
	array('label'=>'Manage Address', 'url'=>array('admin')),
);
?>

<h1>Create Address</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>