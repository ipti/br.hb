<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Consultations');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Consultation',
]), ['create', 'cid'=>$campaign->id], ['class' => 'btn btn-success']) ?>
    </p>

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
