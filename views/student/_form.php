<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\Dialog;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\student */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($model, 'fid') ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => 150]) ?>
    
    <?= Html::activeHiddenInput($model, 'address') ?>
    
    <?= Html::button($model->getAttributeLabel('address').'...', ['id'=>'changeAddress', 'class'=>'btn btn-primary']) ?>

    <?= $form->field($model, 'birthday')->textInput() ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'male' => 'Male', 'female' => 'Female', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'responsible')->textInput(['maxlength' => 150]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
Dialog::begin([
    'clientOptions' => [
        'id' => 'addressDialog',
        'title' => 'Address Dialog',
        'modal' => true,
        'resizable' => false,
        'height' => '300',
        'autoOpen'=> false,
    ],
]);

echo 'Dialog contents here...';

Dialog::end();


$this->registerJs('
    $("#changeAddress").on("click", function(){
        $("#addressDialog").dialog("open");        
    });');


?>
