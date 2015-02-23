<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\student;

/* @var $this yii\web\View */
/* @var $model app\models\term */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="term-form">

   <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
    ]); ?>

    <?= $form->field($model, 'student')
            ->dropDownList(ArrayHelper::map(student::find()->all(), 'id', 'name'),
                    [$model->isNewRecord ? "":"disabled"=>"disabled"]) ?>

    <?= Html::activeHiddenInput($model, 'campaign') ?>

    <?= $form->field($model, 'agreed')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
