<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Campaign */

$this->title = Yii::t('app', 'Create Campaign');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Campaigns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
