<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\enrollment */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Enrollment',
]) . ' ' . $model->student;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Enrollments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->student, 'url' => ['view', 'student' => $model->student, 'classroom' => $model->classroom]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="enrollment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
