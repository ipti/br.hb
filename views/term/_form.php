<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\models\enrollment;


use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\term */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="term-form">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3><?= $model->isNewRecord ? Yii::t('app', 'Create Campaign') : Yii::t('app', 'Update Campaign') ?></h3>
        <?= $model->isNewRecord ? '' : $model->name ?>
    </div>

    <?php $form = ActiveForm::begin([
     'id' => $model->formName(),
     'type' => ActiveForm::TYPE_VERTICAL
     ]); ?>

    <div class="modal-container">

    <?php
    $js = "
        $('form#".$model->formName()."').on('beforeSubmit', function(e){
            var \$form = $(this);
            submitTermForm(\$form);
        }).on('submit', function(e){
            e.preventDefault();
        });";
    $this->registerJs($js);


    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'enrollment' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::className(),
                'options' => [
                    'data' => ArrayHelper::map(enrollment::find()->all(), 'id', 'students.name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select Student...'),
                        $model->isNewRecord ? "" : "disabled" => "disabled"
                    ]
                ],
            ],
            'campaign'=>['type'=>FORM::INPUT_RAW, 
                'value'=>Html::activeHiddenInput($model, 'campaign')
                ],
            'agreed' => ['type'=>Form::INPUT_CHECKBOX],

        ]
        
    ]); ?>

    </div>
    
    <div class="form-group modal-footer">
        <?= Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>"modal", 'class' => 'btn btn-danger pull-left'])
            .Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end();?>