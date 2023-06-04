
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;


use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

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
     'type' => ActiveForm::TYPE_VERTICAL
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
    $this->registerJs($js); 
    
    
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'student' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::class,
                'options' => [
                    'data' => ArrayHelper::map($campaign->getStudents()->all(), 'id', 'name'),
                    'options' => [
                        'placeholder' => Yii::t('app', 'Select Student...'),
                        $model->student == null ? "" : "readonly"
                    ]
                ],
            ],
            'weight' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => kartik\money\MaskMoney::class,
                'options'=>[
                    'pluginOptions' => [
                        'prefix' => '',
                        'suffix' => ' kg',
                        'allowNegative' => false,
                        'decimal' => ',',
                        'thousands' => '.',
                        'affixesStay' => true,
                        'precision' => 2
                    ],
                ],
            ],
            'height' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => kartik\money\MaskMoney::class,
                'options'=>[
                    'pluginOptions' => [
                        'prefix' => '',
                        'suffix' => ' m',
                        'allowNegative' => false,
                        'decimal' => ',',
                        'thousands' => '.',
                        'affixesStay' => true,
                        'precision' => 2
                    ],
                ],
            ],
            'date' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\date\DatePicker::class,
                'options'=>[
                    'pluginOptions' => ['format' => 'yyyy-mm-dd'],
                ],
            ],

        ]
        
    ]);

    ?>

    </div>

    <div class="form-group modal-footer">
        <?= Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>"modal", 'class' => 'btn btn-danger pull-left'])
            .Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
