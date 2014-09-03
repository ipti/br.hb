<?php
/* @var $this TermController */
/* @var $model Term */
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
		<?php echo $form->label($model,'student'); ?>
		<?php echo $form->textField($model,'student'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'campaign'); ?>
		<?php echo $form->textField($model,'campaign'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'agreed'); ?>
		<?php echo $form->textField($model,'agreed'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->