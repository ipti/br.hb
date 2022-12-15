<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2;

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['type' => ActiveForm::TYPE_VERTICAL],
]);

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Booting HB');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row justify-content-md-center">
    <div class="form-group">
        <?php
        echo Html::label(yii::t('app', 'Escolas do TAG'));
        echo Select2::widget([
            'name' => 'school',
            'id' => 'schools',
            'data' => $schools,
            'options' => [
                'placeholder' => yii::t('app', 'Select School...'),
                'class' => 'form-select2',
                'multiple' => true
            ],
            'pluginOptions' => ['allowClear' => true, 'closeOnSelect' => false]
        ]);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo Html::label(yii::t('app', 'Salas de Aula do TAG'));
        echo Select2::widget([
            'name' => 'classroom',
            'id' => 'classrooms',
            'data' => $classrooms,
            'options' => [
                'placeholder' => yii::t('app', 'Select Classroom...'),
                'class' => 'form-select2',
                'multiple' => true
            ],
            'pluginOptions' => ['allowClear' => true, 'closeOnSelect' => false]
        ]);
        ?>
    </div>
    <div class="form-group">
        <?php
        echo Html::label(yii::t('app', 'Estudantes do TAG'));
        echo Select2::widget([
            'name' => 'student',
            'id' => 'students',
            'data' => $students,
            'options' => [
                'placeholder' => yii::t('app', 'Select Student...'),
                'class' => 'form-select2',
                'multiple' => true
            ],
            'pluginOptions' => ['allowClear' => true, 'closeOnSelect' => false]
        ]);
        ?>
    </div>
    <?= Html::submitButton('Fazer Download dos Dados', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end() ?>