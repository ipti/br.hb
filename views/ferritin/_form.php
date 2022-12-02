<?php

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\select2\Select2;

use app\models\campaign;
use app\models\term;

/* @var $this yii\web\View */
/* @var $model app\models\hemoglobin */
/* @var $form yii\widgets\ActiveForm */
/* @var $campaign app\models\campaign */

$this->assetBundles['Ferritin'] = new app\assets\AppAsset();
$this->assetBundles['Ferritin']->js = [
    'scripts/FerritinView/Functions.js',
    'scripts/FerritinView/Click.js'
];
?>

<div class="ferritin-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);

    if ($model->isNewRecord) {
        $classrooms = $campaign->getClassroomsWithAgreedTerms();
        echo Html::label(yii::t('app','Classrooms with Agreed Terms...'));
        echo Select2::widget([
            'name' => 'classroom',
            'id'=>'classrooms',
            'data' => $classrooms,
            'options' => [
                'placeholder' => yii::t('app', 'Select Classroom...'),
                'class' => 'form-select2',
                'campaign' => $campaign->id
            ],
            'pluginOptions'=>['allowClear'=>true]
        ]);
        echo "<table id='ferritins' class='kv-grid-table table table-bordered table-striped'>"
                . "<thead>"
                    . "<tr>"
                        . "<th>".yii::t("app", "Student")."</th>"
                        . "<th>".yii::t("app", "Rate")."</th>"
                    . "<tr>"
                . "</thead>"
                . "<tbody></tbody>"
                . "</table>";
        echo Html::submitButton(Yii::t('app', 'Create'), ['id'=>'send', "style"=>"display:none",  'class' =>'btn btn-success']);
   
    } else {
        $term = term::find()->where('id = :sid', ['sid' => $model->agreed_term])->one();
        $campaign = campaign::find()->where('id = :sid', ['sid' => $term->campaign])->one();
        echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => [
                'agreed_term' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => Select2::className(),
                    'options' => [
                            (ArrayHelper::map($campaign->getTerms()->where('agreed = true')->all(), 'id', 'students.name')) ,
                        'options' => [
                            'placeholder' => Yii::t('app', 'Select Student...'),
                            'class' => 'form-select2',
                            "disabled" => "disabled"
                        ]
                    ],
                ],
                'rate' => [
                    'type' => Form::INPUT_TEXT,
                ]
            ]
        ]); 
        echo Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']);
    }
    ActiveForm::end();
    ?>
</div>
