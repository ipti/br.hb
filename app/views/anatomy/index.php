<?php
/* @var $this AnatomyController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Anatomies',
);

$this->menu=array(
	array('label'=>'Create Anatomy', 'url'=>array('create')),
	array('label'=>'Manage Anatomy', 'url'=>array('admin')),
);
?>

<h1>Anatomies</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
