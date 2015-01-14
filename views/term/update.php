<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\term */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Term',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Terms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="term-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
