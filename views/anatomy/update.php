<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\anatomy */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Anatomy',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Anatomies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="anatomy-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
