<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\consultation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consultation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'term')
            ->dropDownList(\yii\helpers\ArrayHelper::map(
                    $campaign->getHemoglobins()->where('sample = 1')->all(), 'agreed_term', 'agreedTerm.students.name'),
                    [$model->isNewRecord ? "":"disabled"=>"disabled"]) ?>
    
    <?= Html::activeHiddenInput($model, 'doctor') ?>
    
    <?= $form->field($model, 'attended')->checkbox() ?>

    <?= $form->field($model, 'delivered')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
