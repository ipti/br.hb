<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\models\enrollmentSearch */
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
        'filterModel' => $searchModel,
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
            ['class'=> kartik\grid\DataColumn::className(),
                'header'=> Yii::t('app', 'Weight'),
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null)
                        return $anatomy->weight . "kg";
                    return null;
                }
            ],
            ['class'=> kartik\grid\DataColumn::className(),
                'header'=> Yii::t('app', 'Height'),
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null)
                        return $anatomy->height . "m";
                    return null;
                }
            ],
            ['class'=> kartik\grid\DataColumn::className(),
                'header'=> Yii::t('app', 'Date'),
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null)
                        return date("d/m/Y", strtotime($anatomy->date));
                    return null;
                }
            ],
            ['class'=> kartik\grid\BooleanColumn::className(),
                'header'=> Yii::t('app', 'Updated'),
                'options'=>['mydate'=>$campaign->begin],
                'contentOptions' => ['class' => 'agreedClick'],
                'content' => function ($model, $key, $index, $column){
                    $anatomy = $model->getStudents()->one()->getAnatomies()->orderBy("date desc")->one();
                    if($anatomy != null)
                        return $anatomy->date >= $column->options['mydate'] 
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
