<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\Dialog;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\student */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= Html::activeHiddenInput($model, 'fid') ?>
    
    <?= $form->field($model, 'name')->textInput(['maxlength' => 150]) ?>
    
    <?= Html::activeHiddenInput($model, 'address') ?>
    
    <?= Html::button(
        $model->getAttributeLabel('address').'...', 
        ['value' => $model->isNewRecord 
                    ?Url::to(['address/create'])
                    :Url::to(['address/update','id'=>$model->address]),
            'id'=>'changeAddress',
            'class'=>'btn btn-primary',
            'for'=>'#student-address'
        ]) 
    ?>

    <?= $form->field($model, 'birthday')->textInput() ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'male' => 'Male', 'female' => 'Female', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'responsible')->textInput(['maxlength' => 150]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
    Modal::begin([
        'id' => 'addressModal'
    ]);
        echo "<div id='addressModalContent'></div>";
        
    Modal::end();

//    Dialog::begin([
//        'clientOptions' => [
//            'title' => 'Address Dialog',
//            'modal' => true,
//            'resizable' => false,
//            'height' => '300',
//            'autoOpen'=> false,
//            'buttons' => [
//                "Confirm" => "",
//                "Cancel" => ""
//            ]
//        ],
//        'id' => 'addressDialog',
//    ]);
//
//    $address = new app\models\address();
//    
//  
//    echo $this->render('@app/views/address/_form', [
//        'model' => $model->isNewRecord ? $address : $model->address0,
//        'isDialog' => true
//    ]);
//
//    Dialog::end();
//
//
//    $this->registerJs('   
//        $("#changeAddress").click(function(){   
//            $("#addressDialog").dialog("open");   
//        });');


?>
