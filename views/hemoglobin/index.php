<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $capaign Integer */
/* @var $sample Integer */

$this->title = Yii::t('app', 'Hemoglobins');
$this->params['breadcrumbs'][] = $this->title;
$this->params['button'] =
        Html::a(Yii::t('app', 'Create Hemoglobin', [
                    'modelClass' => 'Hemoglobin',
                ]), ['create', 'cid' => $campaign->id, 's' => $sample], ['class' => 'btn btn-success navbar-btn']);
?>

<div class="hemoglobin-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute' => 'agreed_term',
                'content' => function ($model, $key, $index, $column){
                    return $model->agreedTerm->students->name;
                }
            ],
            'rate',
        ],
    ]); ?>

</div>
