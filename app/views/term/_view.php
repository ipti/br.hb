<?php
/* @var $this TermController */
/* @var $data Term */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('student')); ?>:</b>
	<?php echo CHtml::encode($data->student); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('campaign')); ?>:</b>
	<?php echo CHtml::encode($data->campaign); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('agreed')); ?>:</b>
	<?php echo CHtml::encode($data->agreed); ?>
	<br />


</div>