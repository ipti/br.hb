<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $capaign Integer */
/* @var $sample Integer */

$this->title = Yii::t('app', 'Hemoglobins');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hemoglobin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Hemoglobin',
]), ['create','cid'=>$campaign->id,'s'=>$sample], ['class' => 'btn btn-success']) ?>
    </p>

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
