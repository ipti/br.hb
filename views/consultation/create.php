<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\consultation */

$this->title = Yii::t('app', 'Create Consultation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consultations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-create">

    <?= $this->render('_form', [
        'model' => $model,
        'campaign' => $campaign,
    ]) ?>

</div>
