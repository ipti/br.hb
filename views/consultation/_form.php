<?php

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\consultation */
/* @var $form yii\widgets\ActiveForm */
/* @var $campaign app\models\campaign */
?>

<div class="consultation-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'doctor' => [
                'type' => Form::INPUT_RAW,
                'value' => Html::activeHiddenInput($model, 'doctor')
            ],
            'term' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::className(),
                'options' => [
                    'data' => ArrayHelper::map($campaign->getHemoglobinsWithoutConsult()->all(), 'agreed_term', 'agreedTerm.students.name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select Student...'),
                        $model->isNewRecord ? "" : "disabled" => "disabled"
                    ]
                ],
            ],
            'attended' => [
                'type' => Form::INPUT_CHECKBOX,
            ],
            'delivered' => [
                'type' => Form::INPUT_CHECKBOX,
            ],
        ]
    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), 
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end();
    ?>

</div>
