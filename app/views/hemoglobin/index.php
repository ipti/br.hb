<?php
/* @var $this HemoglobinController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Hemoglobins',
);

$this->menu=array(
	array('label'=>'Create Hemoglobin', 'url'=>array('create')),
	array('label'=>'Manage Hemoglobin', 'url'=>array('admin')),
);
?>

<h1>Hemoglobins</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
