<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\Student */
/* @var $form yii\bootstrap4\ActiveForm */

$this->assetBundles['Child'] = new app\assets\AppAsset();
$this->assetBundles['Child']->js = [
    'scripts/StudentView/Functions.js'
];
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'header_student' => [
                'type' => 'raw',
                'value' => '<hr><h4>Dados do Aluno</h4><br>'
            ],
            'name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'gender' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ['male' => 'Masculino', 'female' => 'Feminino'],
                'options' => ['prompt' => 'Selecione o sexo']
            ],
            'birthday' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\date\DatePicker::class,
                'options'=>[
                    'pluginOptions' => ['format' => 'yyyy-mm-dd'],
                ],
            ],
            'allergy' => [
                'type' => Form::INPUT_CHECKBOX,
                'options' => ['value' => '1'],
            ],
            'allergy_text' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true],
                'fieldConfig' => [
                    'options' => ['style' => 'display:none']
                ],
            ],
            'anemia' => [
                'type' => Form::INPUT_CHECKBOX,
                'options' => ['value' => '1'],
            ],
            'anemia_text' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true],
                'fieldConfig' => [
                    'options' => ['style' => 'display:none']
                ],
            ],
            'header_responsible_1' => [
                'type' => 'raw',
                'value' => '<hr><h4>Dados do Responsável 1</h4><br>'
            ],
            'responsible_1_name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'responsible_1_telephone' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'responsible_1_kinship' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'responsible_1_email' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'header_responsible_2' => [
                'type' => 'raw',
                'value' => '<hr><h4>Dados do Responsável 2</h4><br>'
            ],
            'responsible_2_name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'responsible_2_telephone' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'responsible_2_kinship' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'responsible_2_email' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .modal-content {
        padding: 30px;
    }
</style>
