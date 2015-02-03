<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-form">
   <?php $form = ActiveForm::begin([
        'id' => $model->formName()
    ]); ?>
    
    
    <?php
    //beforeSubmit
    $js = "
        $('form#".$model->formName()."').on('beforeSubmit', function(e){
            var \$form = $(this);
            submitCampaignForm(\$form);
        }).on('submit', function(e){
            e.preventDefault();
        });";
    $this->registerJs($js);
    ?>

    <?= $form->field($model, 'coordinator')->hiddenInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'begin')->input("date") ?>

    <?= $form->field($model, 'end')->input("date") ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
