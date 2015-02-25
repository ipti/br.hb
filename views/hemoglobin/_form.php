<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\hemoglobin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hemoglobin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($sample == 1){?>
    <?= $form->field($model, 'agreed_term')
            ->dropDownList(ArrayHelper::map(
                    $campaign->getTerms() ->where('agreed = true') ->all(), 'id', 'students.name'),
                    [$model->isNewRecord ? "":"disabled"=>"disabled"]) ?>
    <?php }else{?>
    <?=  $form->field($model, 'agreed_term')
            ->dropDownList(ArrayHelper::map(
                    $campaign->getConsults() ->where('attended = true') ->all(), 'id', 'terms.students.name'),
                    [$model->isNewRecord ? "":"disabled"=>"disabled"]) ?>
    <?php }?>

    <?= $form->field($model, 'rate')->input('number',['min'=>0, 'step'=>'0.1']) ?>

    <?= Html::activeHiddenInput($model, 'sample', ['value'=>$sample]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
