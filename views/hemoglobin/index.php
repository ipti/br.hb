<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\Url;
use kartik\grid\DataColumn;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $campaign Integer */
/* @var $sample Integer */

$this->title = Yii::t('app', 'Hemoglobins');
$this->params['breadcrumbs'][] = $this->title;
$this->params['campaign'] = $campaign->id;
$this->params['button'] =
        Html::a(Yii::t('app', 'Create Hemoglobin', [
                    'modelClass' => 'Hemoglobin',
                ]), ['create', 'cid' => $campaign->id, 's' => $sample],
                ['class' => 'btn btn-success navbar-btn'] );

$sample1 = ['class'=> DataColumn::className(),
            'label' => yii::t('app', 'Rate')." 1",
            'options' => ['style' => 'width:5%'],
            'content' => function ($model){
                /* @var $model \app\models\hemoglobin */
                return $model->getHemoglobin(1)->rate . "g/dL";
            }
        ];
            
$sample2 = $sample < 2 ? "" : ['class'=> DataColumn::className(),
                'label' => yii::t('app', 'Rate')." 2",
                'options' => ['style' => 'width:5%'],
                'content' => function ($model){
                    /* @var $model \app\models\hemoglobin */
                    return ($model->getHemoglobin(2) == null ) ? "-----"  : $model->getHemoglobin(2)->rate . "g/dL";
                }
            ];
$sample3 = ['class'=> DataColumn::className(),
                'label' => yii::t('app', 'Rate')." 3",
                'options' => ['style' => 'width:5%'],
                'content' => function ($model){
                /* @var $model \app\models\hemoglobin */
                return $model->getHemoglobin(3)->rate . "g/dL";
                }
            ];
$columns = [['class'=> DataColumn::className(),
                'attribute' => 'agreed_term',
                'options' => ['style' => 'width:70%'],
                'content' => function ($model){
                    return $model->agreedTerm->students->name;
                }
            ]];
$columns = array_merge($columns, [$sample1]);

//$campaigID = $campaign->id;

if ($sample >= 2) { $columns = array_merge($columns, [$sample2]); }
if ($sample >= 3) { $columns = array_merge($columns, [$sample3]); }
$columns = array_merge($columns, [[
        'class' => DataColumn::className(),
        'label' => yii::t('app', 'Actions'),
        'options' => ['style' => 'width:10%'],
        'content' => function($model, $key, $index, $column) {
            /* @var $model \app\models\hemoglobin */
            return Html::a(Icon::show('edit', [], Icon::FA).yii::t('app', 'Update'), Url::toRoute(['hemoglobin/update', 'id' => $model->id]));
        }
    ]]);
?>

<div class="hemoglobin-index">
    <?=Html::a(Icon::show('file-pdf-o', [], Icon::FA).yii::t('app','Anemics Lists...'),Url::toRoute(['anemics-lists', 'cid' => $campaign->id, 's' => $sample ]),
         ['target'=>'_blank', 'id'=>'anemicsLists', 'class' => 'btn btn-primary pull-right']) ?>
    <br>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]); ?>

</div>
