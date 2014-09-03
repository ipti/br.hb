<?php
/* @var $this HemoglobinController */
/* @var $data Hemoglobin */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agreed_term')); ?>:</b>
	<?php echo CHtml::encode($data->agreed_term); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rate')); ?>:</b>
	<?php echo CHtml::encode($data->rate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sample')); ?>:</b>
	<?php echo CHtml::encode($data->sample); ?>
	<br />


</div>