<?php

use kartik\widgets\Alert;
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

$this->assetBundles['Hemoglobin'] = new app\assets\AppAsset();
$this->assetBundles['Hemoglobin']->js = [
    'scripts/HemoglobinView/Functions.js',
    'scripts/HemoglobinView/Click.js'
];
?>

<div class="hemoglobin-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL]);

    if ($model->isNewRecord) {
        if($sample == 1){
            $classrooms = $campaign->getClassroomsWithAgreedTerms();
        }
        else {
            $classrooms = $campaign->getClassroomsWithAttendedConsults();
        }
        echo Html::label(yii::t('app','Classrooms with Agreed Terms...'));
        echo Select2::widget([
            'name' => 'classroom',
            'id'=>'classrooms',
            'data' => $classrooms,
            'options' => [
                'placeholder' => yii::t('app', 'Select Classroom...'),
                'class' => 'form-select2',
                'sample' => $sample,
                'campaign' => $campaign->id
            ],
            'pluginOptions'=>['allowClear'=>true]
        ]);
        echo "<table id='hemoglobins' class='kv-grid-table table table-bordered table-striped'>"
                . "<thead>"
                    . "<tr>"
                        . "<th>".yii::t("app", "Student")."</th>"
                        . "<th>".yii::t("app", "Rate")."</th>"
                    . "<tr>"
                . "</thead>"
                . "<tbody></tbody>"
                . "</table>";
        echo Alert::widget([
            'options' => [
                'id' => 'noHemoglobinsMessage',
                'class' => 'alert alert-danger',
                'style' => 'display:none;',
            ],
            'body' => 'Todos os alunos que aderiram a campanha dessa turma tiveram suas hemoglobinas coletadas'
        ]);
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
                    'widgetClass' => Select2::class,
                    'options' => [
                        'data' => $model->sample == 1 
                            ? (ArrayHelper::map($campaign->getTerms()->where('agreed = true')->all(), 'id', 'students.name')) 
                            : (ArrayHelper::map($campaign->getConsults()->where('attended = true')->all(), 'terms.id', 'terms.students.name')),
                        'options' => [
                            'placeholder' => Yii::t('app', 'Select Student...'),
                            'class' => 'form-select2',
                            "disabled" => "disabled"
                        ]
                    ],
                ],
                'rate' => [
                    'type' => Form::INPUT_TEXT,
                ],
                'sample' => [
                    'type' => Form::INPUT_RAW,
                    'value' => Html::activeHiddenInput($model, 'sample', ['value' => $model->sample])
                ]
            ]
        ]); 
        echo Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']);
    }
    ActiveForm::end();
    ?>
</div>
