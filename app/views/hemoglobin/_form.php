<?php
/* @var $this HemoglobinController */
/* @var $model Hemoglobin */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hemoglobin-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'agreed_term'); ?>
        <?php
        echo $form->dropDownList($model, 'agreed_term', CHtml::listData(Term::model()->findAll('agreed = true'), 'id', 'studentFK.name'), array(
            'ajax' => array(
                'type' => 'POST',
                'url' => $this->createUrl('hemoglobin/getSampleByStudent'),
                'update' => '#' . CHtml::activeId($model, 'sample')
        )));
        ?>
        <?php echo $form->error($model, 'agreed_term'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'rate'); ?>
        <?php echo $form->numberField($model, 'rate', array('min' => '0', 'max' => '100', 'step' => '0.1')); ?>
        <?php echo $form->error($model, 'rate'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'sample'); ?>
        <?php echo $form->dropDownList($model, 'sample', array('1' => '1', '2' => '2', '3' => '3')); ?>
        <?php echo $form->error($model, 'sample'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->