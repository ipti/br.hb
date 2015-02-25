<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $campaign integer */

$this->assetBundles['Term'] = new app\assets\AppAsset();
$this->assetBundles['Term']->js = [
    'scripts/TermView/Functions.js',
    'scripts/TermView/Click.js'
];

$this->title = Yii::t('app', 'Terms');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="term-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?=
        Html::a(Yii::t('app', 'Create {modelClass}', [
                    'modelClass' => 'Term',
                ]), ['create', 'c' => $campaign], ['class' => 'btn btn-success'])
        ?>
    </p>

    <?=
    GridView::widget([
        'id' => 'termsGridView',
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class'=> kartik\grid\DataColumn::className(),
                'attribute' => 'student',
                'content' => function ($model, $key, $index, $column){
                    return $model->students->name;
                }
            ],
            ['class' => '\kartik\grid\BooleanColumn',
                'contentOptions' => ['class' => 'agreedClick'],
                'attribute' => 'agreed',
                'vAlign' => 'middle',
            ],
        ],
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'id' => 'pjaxTerm'
            ],
        ],
    ]);
    ?>
</div>

<?php
Modal::begin(['id' => 'updateModal']);
    echo "<div id='updateModalContent'></div>";
Modal::end();
?>
