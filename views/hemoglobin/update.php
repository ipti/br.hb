<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\hemoglobin */

$this->title = Yii::t('app', 'Update Hemoglobin') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hemoglobins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="hemoglobin-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
