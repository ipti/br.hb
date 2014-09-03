<?php
/* @var $this ConsultationController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Consultations',
);

$this->menu=array(
	array('label'=>'Create Consultation', 'url'=>array('create')),
	array('label'=>'Manage Consultation', 'url'=>array('admin')),
);
?>

<h1>Consultations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
