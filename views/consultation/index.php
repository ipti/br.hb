<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->assetBundles['Consultation'] = new app\assets\AppAsset();
$this->assetBundles['Consultation']->js = [
    'scripts/ConsultationView/Functions.js',
    'scripts/ConsultationView/Click.js'
];

$this->title = Yii::t('app', 'Consultations');
$this->params['breadcrumbs'][] = $this->title;
$this->params['button'] =
        Html::a(Yii::t('app', 'Create Consultation'), ['create', 'cid' => $campaign->id], ['class' => 'btn btn-success navbar-btn'])
?>

<div class="consultation-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute' => 'term',
                'content' => function ($model, $key, $index, $column){
                    return $model->terms->students->name;
                }
            ],
            //'doctor',
            ['class' => \kartik\grid\BooleanColumn::className(),
                'contentOptions' => ['class' => 'attendedClick cursor-pointer'],
                'attribute' => 'attended',
                'vAlign' => 'middle',
            ],
            ['class' => \kartik\grid\BooleanColumn::className(),
                'contentOptions' => ['class' => 'deliveredClick cursor-pointer'],
                'attribute' => 'delivered',
                'vAlign' => 'middle',
            ],
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
