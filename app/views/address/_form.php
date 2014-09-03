<?php
/* @var $this AddressController */
/* @var $model Address */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'address-form',
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
        <?php echo $form->labelEx($model, 'state'); ?>
        <?php
        echo $form->dropDownList($model, 'state', array('AC' => 'AC', 'AL' => 'AL', 'AM' => 'AM', 'AP' => 'AP', 'BA' => 'BA', 'CE' => 'CE', 'DF' => 'DF', 'ES' => 'ES', 'GO' => 'GO',
            'MA' => 'MA', 'MG' => 'MG', 'MS' => 'MS', 'MT' => 'MT', 'PA' => 'PA', 'PB' => 'PB', 'PE' => 'PE', 'PI' => 'PI', 'PR' => 'PR',
            'RJ' => 'RJ', 'RN' => 'RN', 'RO' => 'RO', 'RR' => 'RR', 'RS' => 'RS', 'SC' => 'SC', 'SE' => 'SE', 'SP' => 'SP', 'TO' => 'TO'));
        ?>
        <?php echo $form->error($model, 'state'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'city'); ?>
        <?php echo $form->textField($model, 'city', array('size' => 15, 'maxlength' => 60)); ?>
        <?php echo $form->error($model, 'city'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'neighborhood'); ?>
        <?php echo $form->textField($model, 'neighborhood', array('size' => 15, 'maxlength' => 30)); ?>
        <?php echo $form->error($model, 'neighborhood'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'street'); ?>
        <?php echo $form->textField($model, 'street', array('size' => 20, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'street'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'complement'); ?>
        <?php echo $form->textField($model, 'complement', array('size' => 20, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'complement'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'number'); ?>
        <?php echo $form->textField($model, 'number', array('size' => 5, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'postal_code'); ?>
        <?php
        $this->widget('CMaskedTextField', array(
            'model' => $model,
            'attribute' => 'postal_code',
            'mask' => '99999-999',
            'htmlOptions' => array('size' => 9))
        );
        //echo $form->textField($model,'postal_code',array('size'=>8,'maxlength'=>8)); 
        ?>
        <?php echo $form->error($model, 'postal_code'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->