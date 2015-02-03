<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Campaign',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaigns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
