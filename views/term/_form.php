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

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
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
        
    ]);
    
    echo Html::submitButton($model->isNewRecord 
            ? Yii::t('app', 'Create') 
            : Yii::t('app', 'Update'), [
                'class' => 
                    $model->isNewRecord 
                        ? 'btn btn-success' 
                        : 'btn btn-primary']);

    ActiveForm::end();
    ?>




</div>
