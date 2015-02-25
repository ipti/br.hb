<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\anatomy */
/* @var $form yii\widgets\ActiveForm */
/* @var $campaign app\models\campaign*/
?>

<div class="anatomy-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student')
            ->dropDownList(ArrayHelper::map($campaign->getStudents()->all(), 'id', 'name'),
                    [$model->isNewRecord ? "":"disabled"=>"disabled"]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'date')->input('date',['value'=>date('Y-m-d')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
