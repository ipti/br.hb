<?php
/* @var $this TermController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Terms',
);

$this->menu=array(
	array('label'=>'Create Term', 'url'=>array('create')),
	array('label'=>'Manage Term', 'url'=>array('admin')),
);
?>

<h1>Terms</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
