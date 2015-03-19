<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $campaign app\models\campaign */

$this->title = Yii::t('app', 'Anatomies');
$this->params['breadcrumbs'][] = $this->title;
$this->params['button'] = 
        Html::a(Yii::t('app', 'Create Anatomy', [
                    'modelClass' => 'Anatomy',
                ]), ['create', 'cid' => $campaign->id], ['class' => 'btn btn-success navbar-btn']);
?>

<div class="anatomy-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=> kartik\grid\DataColumn::className(),
                'header'=> Yii::t('app', 'Student'),
                'filterType' => GridView::FILTER_SELECT2, 
                'content' => function ($model, $key, $index, $column){
                    return $model->getStudents()->one()->name;
                }
            ],
            ['class'=> kartik\grid\DataColumn::className(),
                'header'=> Yii::t('app', 'Classroom'),
                'content' => function ($model, $key, $index, $column){
                    return $model->getClassrooms()->one()->name;
                }
            ],
            ['class'=> kartik\grid\DataColumn::className(),
                'header'=> Yii::t('app', 'weight'),
                'content' => function ($model, $key, $index, $column){
                    $anatomie = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomie != null)
                        return $anatomie->weight;
                    return null;
                }
            ],
            ['class'=> kartik\grid\DataColumn::className(),
                'header'=> Yii::t('app', 'height'),
                'content' => function ($model, $key, $index, $column){
                    $anatomie = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomie != null)
                        return $anatomie->height;
                    return null;
                }
            ],
            ['class'=> kartik\grid\DataColumn::className(),
                'header'=> Yii::t('app', 'date'),
                'content' => function ($model, $key, $index, $column){
                    $anatomie = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomie != null)
                        return $anatomie->date;
                    return null;
                }
            ],
            ['class'=> kartik\grid\BooleanColumn::className(),
                'header'=> Yii::t('app', 'Updated'),
                'options'=>['mydate'=>$campaign->begin],
                'contentOptions' => ['class' => 'agreedClick'],
                'content' => function ($model, $key, $index, $column){
                    $anatomie = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomie != null)
                        return $anatomie->date >= $column->options['mydate'] 
                                ? '<span class="glyphicon glyphicon-ok text-success"></span>'
                                : '<span class="icon-info fa fa-info"></span>';
                    return '<span class="icon-error fa fa-remove"></span>';
                }
            ],
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'id' => 'pjaxAnatomies'
            ],
        ],
    ]); ?>

</div>
