<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use \kartik\icons\Icon;
use \yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var searchModel app\models\enrollmentSearch */
/* @var campaign integer */

$this->assetBundles['Consultation'] = new app\assets\AppAsset();
$this->assetBundles['Consultation']->js = [
    'scripts/ConsultationView/Functions.js',
    'scripts/ConsultationView/Click.js'
];

$this->title = Yii::t('app', 'Consultations');
$this->params['breadcrumbs'][] = $this->title;
$this->params['button'] =
        Html::a(Yii::t('app', 'Create Consultation'), ['create', 'cid' => $campaign], ['class' => 'btn btn-success navbar-btn']);
$this->params['campaign'] = $campaign;
?>

<div class="consultation-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model, $key, $index, $column){
                    $c = $this->params['campaign'];
                    return ['consultation-key'=>$model->getTerms()->one()->getConsults()->one()->id];
                },
        'columns' => [
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute'=>'student',
                'header'=> Yii::t('app', 'Student'),
                'content' => function ($model, $key, $index, $column){
                    return $model->getStudents()->one()->name;
                }
            ],
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute'=>'classroom',
                'header'=> Yii::t('app', 'Classroom'),
                'content' => function ($model, $key, $index, $column){
                    return $model->getClassrooms()->one()->name;
                }
            ],
                    
            ['class' => \kartik\grid\BooleanColumn::className(),
                'contentOptions' => ['class' => 'attendedClick cursor-pointer'],
                'header'=> Yii::t('app', 'Attended'),
                'value' => function ($model, $key, $index, $column){
                /* @var $model \app\models\enrollment */
                    $c = $this->params['campaign'];
                    return $model->getTerms()->one()->getConsults()->one()->attended;
                },
                'vAlign' => 'middle',
            ],
            ['class' => \kartik\grid\BooleanColumn::className(),
                'contentOptions' => ['class' => 'deliveredClick cursor-pointer'],
                'header'=> Yii::t('app', 'Delivered'),
                'value' => function ($model, $key, $index, $column){
                    $c = $this->params['campaign'];
                    return $model->getTerms()->one()->getConsults()->one()->delivered;
                },
                'vAlign' => 'middle',
            ],[
                'class' => kartik\grid\DataColumn::className(),
                'label' => yii::t('app', 'Actions'),
                'content' => function($model, $key, $index, $column) {
                    
                    $consultation = $model;
                    $hemoglobin = $consultation->terms->getHemoglobins()->where("sample = 1")->one();
                    $link = $hemoglobin->isAnemic() 
                            ? Html::a(Icon::show('file-text-o', [], Icon::FA),Url::toRoute(['reports/prescription', 'eid' => $model->id]))
                            : Html::a(Icon::show('file-text-o', [], Icon::FA), "#",["class"=>"text-muted disabled"]);
                    
                    return $link;
                }
            ]
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'id' => 'pjaxConsults'
            ],
        ],
    ]); ?>
</div>

<?php
    Modal::begin([
        'size' => Modal::SIZE_SMALL,
        'id' => 'updateAttendedModal',
        'closeButton'=>false,
    ]);
    echo "<div class='modal-container'><p>";
    echo Yii::t("app","Are you sure you want to update?");
    echo "</p>";
    echo "<br>";
    echo "<div>";
    echo Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>"modal", 'class' => 'btn btn-danger pull-left'])
        .Html::button(Yii::t('app', 'Confirm'), ['id'=>'updateAttendedModal-confirm', 'class' => 'btn btn-success pull-right']);
    echo "</div>";
    echo "<br>";
    echo "<br></div>";
    Modal::end();
    
    Modal::begin([
        'size' => Modal::SIZE_SMALL,
        'id' => 'updateDeliveredModal',
        'closeButton'=>false,
    ]);
    echo "<div class='modal-container'><p>";
    echo Yii::t("app","Are you sure you want to update?");
    echo "</p>";
    echo "<br>";
    echo "<div>";
    echo Html::button(Yii::t('app', 'Cancel'), ['data-dismiss'=>"modal", 'class' => 'btn btn-danger pull-left'])
        .Html::button(Yii::t('app', 'Confirm'), ['id'=>'updateDeliveredModal-confirm', 'class' => 'btn btn-success pull-right']);
    echo "</div>";
    echo "<br>";
    echo "<br></div>";
    Modal::end();
?>