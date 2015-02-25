<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Campaigns');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Campaign', [
    'modelClass' => 'Campaign',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'coordinator',
            'name',
            'begin',
            'end',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
