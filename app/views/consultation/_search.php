<?php
/* @var $this ConsultationController */
/* @var $model Consultation */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'doctor'); ?>
		<?php echo $form->textField($model,'doctor'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'student'); ?>
		<?php echo $form->textField($model,'student'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'attended'); ?>
		<?php echo $form->textField($model,'attended'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'delivered'); ?>
		<?php echo $form->textField($model,'delivered'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->