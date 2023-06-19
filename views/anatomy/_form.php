
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;


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
                'type' => Form::INPUT_TEXT,
                'options' => [
                    'placeholder' => 'Digite o peso em kg (Ex: 56.5)',
                    'class' => 'form-control mask-decimal',
                    'onkeyup' => new JsExpression('
                        var value = this.value;
                        value = value.replace(",", ".");
                        this.value = value;
                    '),
                ],
                'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">kg</span></div>',
                'widgetOptions' => [
                    'clientOptions' => [
                        'alias' => 'decimal',
                        'groupSeparator' => '.',
                        'autoGroup' => true,
                        'digits' => 2,
                        'digitsOptional' => false,
                        'allowMinus' => false,
                        'placeholder' => '0',
                    ],
                ],
            ],
            'height' => [
                'type' => Form::INPUT_TEXT,
                'options' => [
                    'placeholder' => 'Digite a altura em metros (Ex: 1.85)',
                    'class' => 'form-control mask-decimal',
                    'onkeyup' => new JsExpression('
                        var value = this.value;
                        value = value.replace(",", ".");
                        this.value = value;
                    '),
                ],
                'inputTemplate' => '<div class="input-group">{input}<span class="input-group-addon">m</span></div>',
                'widgetOptions' => [
                    'clientOptions' => [
                        'alias' => 'decimal',
                        'groupSeparator' => '.',
                        'autoGroup' => true,
                        'digits' => 2,
                        'digitsOptional' => false,
                        'allowMinus' => false,
                        'placeholder' => '0',
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

<script>
    
</script>
