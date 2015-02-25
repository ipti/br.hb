<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Addresses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Address', [
    'modelClass' => 'Address',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'state',
            'city',
            'neighborhood',
            'street',
            // 'number',
            // 'complement',
            // 'postal_code',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
