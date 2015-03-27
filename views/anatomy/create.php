<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\anatomy */

$this->title = Yii::t('app', 'Create Anatomy');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Anatomies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anatomy-create">

    <?= $this->render('_form', [
        'model' => $model,
        'campaign'=>$campaign,
    ]) ?>

</div>
