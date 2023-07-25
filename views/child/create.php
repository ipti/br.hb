<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\student */

$this->title = 'Adicionar Aluno';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="student-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelEnrollment' => $modelEnrollment,
        'modelAddress' => $modelAddress,
        'classrooms' => $classrooms,
        'schools' => $schools,
        'campaigns' => $campaigns
    ]) ?>
</div>
