<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/* @var $this yii\web\View */
/* @var $model app\models\Student */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Form::widget([
        'model' => $model,
        'form' => $form,
        'attributes' => [
            'name' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'gender' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => ['male' => 'Masculino', 'female' => 'Feminino'],
                'options' => ['prompt' => 'Selecione o sexo']
            ],
            'mother' => [
                'type' => Form::INPUT_TEXT,
                'options' => ['maxlength' => true]
            ],
            'birthday' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \kartik\date\DatePicker::class,
                'options'=>[
                    'pluginOptions' => ['format' => 'yyyy-mm-dd'],
                ],
            ],
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
    .modal-content {
        padding: 30px;
    }
</style>
