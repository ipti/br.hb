<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Consultations');
$this->params['breadcrumbs'][] = $this->title;
$this->params['button'] =
        Html::a(Yii::t('app', 'Create Consultation', [
                    'modelClass' => 'Consultation',
                ]), ['create', 'cid' => $campaign->id], ['class' => 'btn btn-success navbar-btn'])
?>

<div class="consultation-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute' => 'terms',
                'content' => function ($model, $key, $index, $column){
                    return $model->terms->students->name;
                }
            ],
            //'doctor',
            ['class' => \kartik\grid\BooleanColumn::className(),
                'contentOptions' => ['class' => 'attendedClick'],
                'attribute' => 'attended',
                'vAlign' => 'middle',
            ],
            ['class' => \kartik\grid\BooleanColumn::className(),
                'contentOptions' => ['class' => 'deliveredClick'],
                'attribute' => 'delivered',
                'vAlign' => 'middle',
            ],
        ],
    ]); ?>

</div>
