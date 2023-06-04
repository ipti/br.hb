<?php

use yii\helpers\Html;

/** @var yii\web\View $this yii\web\View */
/** @var app\models\term $model app\models\term */
/** @var integer $campaign integer */

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
