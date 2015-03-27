
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

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3><?= $model->isNewRecord ? Yii::t('app', 'New Anatomy') : Yii::t('app', 'Update Anatomy') ?></h3>
        <?= $model->isNewRecord ? '' : $model->name ?>
    </div>

    <?php $form = ActiveForm::begin([
     'id' => $model->formName(),
     ]); ?>

    <div class="modal-container">

    <?php
    $js = "
        $('form#".$model->formName()."').on('beforeSubmit', function(e){
            var \$form = $(this);
            submitAnatomyForm(\$form);
        }).on('submit', function(e){
            e.preventDefault();
        });";
    $this->registerJs($js); ?>

    <?= $form->field($model, 'student')
            ->dropDownList(ArrayHelper::map($campaign->getStudents()->all(), 'id', 'name'),
                    [$model->isNewRecord ? "":"disabled"=>"disabled"]) ?>

    <?= $form->field($model, 'weight')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'date')->input('date',['value'=>date('Y-m-d')]) ?>

    </div>

    <div class="form-group modal-footer">
        <?= Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>"modal", 'class' => 'btn btn-danger pull-left'])
            .Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
