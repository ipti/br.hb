<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ferritin */
/* @var $capaign Integer */
/* @var $sample Integer */

$this->title = Yii::t('app', 'Create Ferritin');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ferritins'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ferritin-create">
    
    <?= $this->render('_form', [
        'model' => $model,
        'campaign' => $campaign
    ]) ?>

</div>
