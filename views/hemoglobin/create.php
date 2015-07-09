<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\hemoglobin */
/* @var $capaign Integer */
/* @var $sample Integer */

$this->title = Yii::t('app', 'Create Hemoglobin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Hemoglobins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hemoglobin-create">
    
    <?= $this->render('_form', [
        'model' => $model,
        'campaign' => $campaign,
        'sample' => $sample
    ]) ?>

</div>
