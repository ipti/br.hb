<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Terms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Term',
]), ['create',['c'=>$campaign]], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'student',
            //'agreed',
            [
                'class' => '\kartik\grid\BooleanColumn',
                'attribute' => 'agreed',
                'trueLabel' => '1', 
                'falseLabel' => '0'
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
