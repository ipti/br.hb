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
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o nome do aluno']
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
                'options' => ['maxlength' => true, 'placeholder' => 'Descreva a(s) alergia(s) do aluno'],
            ],
            'anemia' => [
                'type' => Form::INPUT_CHECKBOX,
                'options' => ['value' => '1'],
            ],
            'anemia_text' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Descreva a(s) anemia(s) do aluno'],
            ],
            'header_responsible_1' => [
                'type' => 'raw',
                'value' => '<hr><h4>Dados do Responsável 1</h4><br>'
            ],
            'responsible_1_name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o nome do responsável 1']
            ],
            'responsible_1_telephone' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => '(__) _____-____']
            ],
            'responsible_1_kinship' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => [1 => 'Mãe', 2 => 'Pai', 3 => 'Irmão/Irmã', 4 => 'Outro'],
                'options' => ['prompt' => 'Selecione o grau de parentesco']
            ],
            'responsible_1_email' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o email do responsável 1']
            ],
            'header_responsible_2' => [
                'type' => 'raw',
                'value' => '<hr><h4>Dados do Responsável 2</h4><br>'
            ],
            'responsible_2_name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o nome do responsável 2']
            ],
            'responsible_2_telephone' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => '(__) _____-____']
            ],
            'responsible_2_kinship' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => [1 => 'Mãe', 2 => 'Pai', 3 => 'Irmão/Irmã', 4 => 'Outro'],
                'options' => ['prompt' => 'Selecione o grau de parentesco']
            ],
            'responsible_2_email' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true, 'placeholder' => 'Digite o email do responsável 2']
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
