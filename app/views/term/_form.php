<?php
/* @var $this TermController */
/* @var $model Term */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'term-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'student'); ?>
		<?php echo $form->dropDownList($model, 'student', CHtml::listData(Student::model()->findAll(), 'id', 'name'));
                //$form->textField($model,'student'); ?>
		<?php echo $form->error($model,'student'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'campaign'); ?>
		<?php echo $form->textField($model,'campaign', array('disabled'=>'true')); ?>
		<?php echo $form->error($model,'campaign'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'agreed'); ?>
		<?php echo $form->checkBox($model,'agreed'); ?>
		<?php echo $form->error($model,'agreed'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->