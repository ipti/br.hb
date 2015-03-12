<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\Url;

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


$sample1 = ['class'=> kartik\grid\DataColumn::className(),
            'label' => yii::t('app', 'Rate')." 1",
            'content' => function ($model, $key, $index, $column){
                /* @var $model \app\models\hemoglobin */
                return $model->getHemoglobin(1)->rate;
            }
        ];
            
$sample2 = $sample < 2 ? "" : ['class'=> kartik\grid\DataColumn::className(),
                'label' => yii::t('app', 'Rate')." 2",
                'content' => function ($model, $key, $index, $column){
                /* @var $model \app\models\hemoglobin */
                if($model->getHemoglobin(2) == null)
                    return "-----";
                return $model->getHemoglobin(2)->rate;
                }
            ];
$sample3 = ['class'=> kartik\grid\DataColumn::className(),
                'label' => yii::t('app', 'Rate')." 3",
                'content' => function ($model, $key, $index, $column){
                /* @var $model \app\models\hemoglobin */
                return $model->getHemoglobin(3)->rate;
                }
            ];
$columns = [['class'=> kartik\grid\DataColumn::className(),
                'attribute' => 'agreed_term',
                'content' => function ($model, $key, $index, $column){
                    return $model->agreedTerm->students->name;
                }
            ]];
$columns = array_merge($columns, [$sample1]);
if($sample == 1) $columns = array_merge($columns, [[
    'class'=> kartik\grid\DataColumn::className(),
    'label'=>yii::t('app', 'Print'), 
    'content'=>function($model, $key, $index, $column){
    /* @var $model \app\models\hemoglobin */
        return Html::a(Icon::show('print',[], Icon::FA),  Url::toRoute(['reports/consultation-letter', 'sid' => $model->agreedTerm->enrollments->student]));
    }
    ]]);
if($sample >=2)$columns = array_merge($columns, [$sample2]);
if($sample >=3)$columns = array_merge($columns, [$sample3]);
            
?>

<div class="hemoglobin-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]); ?>

</div>
