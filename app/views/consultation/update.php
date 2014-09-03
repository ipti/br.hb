<?php
/* @var $this ConsultationController */
/* @var $model Consultation */

$this->breadcrumbs=array(
	'Consultations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Consultation', 'url'=>array('index')),
	array('label'=>'Create Consultation', 'url'=>array('create')),
	array('label'=>'View Consultation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Consultation', 'url'=>array('admin')),
);
?>

<h1>Update Consultation <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>