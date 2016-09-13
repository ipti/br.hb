<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\consultation */

$this->title = Yii::t('app', 'Update Consultation') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consultations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="consultation-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
