<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\term */
/* @var $campaign integer */

$this->title = Yii::t('app', 'Update Term') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Terms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="term-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'campaign' => $campaign
    ]) ?>

</div>
