<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\icons\Icon;
use yii\helpers\Url;
use kartik\grid\DataColumn;
use yii\helpers\VarDumper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $campaign Integer */

$this->title = Yii::t('app', 'Ferritins');
$this->params['button'] = Html::a(Yii::t('app', 'Criar Ferritina', [
    'modelClass' => 'ferritin',]),['create', 'cid' => $campaign->id],
    ['class'=>'btn btn-success navbar-btn']);

$columns = [
    [
    'class' => DataColumn::class,
    'attribute' => 'agreed_term',
    'options' => ['style' => 'width:70%'],
    'content' => function ($model) {
        return $model->agreedTerm->students->name;
    }
],
[
    'class' => DataColumn::class,
    'label' => yii::t('app', 'Rate'),
    'options' => ['style' => 'width:5%'],
    'content' => function ($model) {
        return $model->getFerritin(1)->rate . "g/dL";
    }
],
[
    'class' => DataColumn::class,
    'label' => yii::t('app', 'Actions'),
    'options' => ['style' => 'width:10%'],
    'content' => function($model, $key, $index, $column) {
        return Html::a(Icon::show('edit', [], Icon::FA).yii::t('app', 'Update'), Url::toRoute(['ferritin/update', 'id' => $model->id]));
    }
]
];

?>

<div class="ferritin-index">

    <?= Html::a(
        Icon::show('file-pdf-o', [], Icon::FA) . yii::t('app', 'Anemics Lists...'),
        Url::toRoute(['anemics-lists', 'cid' => $campaign->id]),
        ['target' => '_blank', 'id' => 'anemicsLists', 'class' => 'btn btn-primary pull-right']
    ) ?>
    <br>
    <br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns
    ]); ?>

</div>