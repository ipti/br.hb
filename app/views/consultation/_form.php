<?php
/* @var $this ConsultationController */
/* @var $model Consultation */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'consultation-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'doctor'); ?>
		<?php echo $form->textField($model,'doctor'); ?>
		<?php echo $form->error($model,'doctor'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'student'); ?>
		<?php echo $form->dropDownList($model,'student', CHtml::listData(Student::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'student'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'attended'); ?>
		<?php echo $form->checkBox($model,'attended'); ?>
		<?php echo $form->error($model,'attended'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivered'); ?>
		<?php echo $form->checkBox($model,'delivered'); ?>
		<?php echo $form->error($model,'delivered'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->