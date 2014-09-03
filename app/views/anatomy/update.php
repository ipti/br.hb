<?php
/* @var $this AnatomyController */
/* @var $model Anatomy */

$this->breadcrumbs=array(
	'Anatomies'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Anatomy', 'url'=>array('index')),
	array('label'=>'Create Anatomy', 'url'=>array('create')),
	array('label'=>'View Anatomy', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Anatomy', 'url'=>array('admin')),
);
?>

<h1>Update Anatomy <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>