<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\student */

$this->title = 'Criar Aluno';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="student-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
