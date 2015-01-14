<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\classroom */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Classroom',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Classrooms'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classroom-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
