<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;

use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\term;
use\app\models\anatomy;

/* @var $this yii\web\View */
/* @var $model app\models\student */
/* @var $form yii\widgets\ActiveForm */

$this->assetBundles['Student'] = new app\assets\AppAsset();
$this->assetBundles['Student']->js = [
    'scripts/StudentView/Functions.js',
    'scripts/StudentView/Click.js'
];

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

    <?= $form->field($model, 'gender')->dropDownList([ 'male' => Yii::t('app', 'Male'), 'female' => Yii::t('app', 'Female'), ], ['prompt' => '']) ?>

    <?= $form->field($model, 'responsible')->textInput(['maxlength' => 150]) ?>

    <?php
        echo Html::button('<i class="glyphicon glyphicon-plus"></i> '.yii::t('app','New Anatomy'), 
            ['id'=>'addAnatomy', 
                'value' => $model->id,
                'class' => 'btn btn-success', 
            ]);
        echo GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => anatomy::find()->where(['student'=>$model->id]),
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'date',
                'height',
            ],
            'pjax'=>true,
            'pjaxSettings'=>[
                'neverTimeout'=>true,
                'options'=>[
                    'id'=>'pjaxAnatomy'
                ],
            ],
            'hover'=>true,
        ]); 
    ?>
    
    <?php
        echo Html::button('<i class="glyphicon glyphicon-plus"></i> '.yii::t('app','New Term'), 
            ['id'=>'addTerm', 
                'value' => $model->id,
                'class' => 'btn btn-success', 
            ]);
        echo GridView::widget([
            'dataProvider' => new ActiveDataProvider([
                'query' => term::find()->where(['student'=>$model->id]),
            ]),
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                //'id',
                ['class' => '\kartik\grid\BooleanColumn',
                    'attribute' => 'agreed',
                    'trueLabel' => Yii::t('app','Yes'), 
                    'falseLabel' => Yii::t('app','No'), 
                ],
            ],
            'pjax'=>true,
            'pjaxSettings'=>[
                'neverTimeout'=>true,
                'options'=>[
                    'id'=>'pjaxTerm'
                ],
            ],
            'hover'=>true,
        ]); 
    ?>

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

    Modal::begin([
        'id' => 'anatomyModal'
    ]);
        echo "<div id='anatomyModalContent'></div>";
        
    Modal::end();

?>