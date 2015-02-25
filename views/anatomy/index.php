<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $campaign app\models\campaign */

$this->title = Yii::t('app', 'Anatomies');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="anatomy-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Anatomy', [
    'modelClass' => 'Anatomy',
]), ['create','cid'=>$campaign->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute' => 'student',
                'content' => function ($model, $key, $index, $column){
                    return $model->students->name;
                }
            ],
            'weight',
            'height',
            'date',
            ['class'=> kartik\grid\BooleanColumn::className(),
                'header'=> Yii::t('app', 'Updated'),
                'options'=>['mydate'=>$campaign->begin],
                'contentOptions' => ['class' => 'agreedClick'],
                'content' => function ($model, $key, $index, $column){
                    return $model->date >= $column->options['mydate'] 
                            ? '<span class="glyphicon glyphicon-ok text-success"></span>'
                            : '<span class="icon-info fa fa-info"></span>';
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
