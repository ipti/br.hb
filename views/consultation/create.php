<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\consultation */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Consultation',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Consultations'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consultation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
