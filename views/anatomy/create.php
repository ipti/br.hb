<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\anatomy */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Anatomy',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Anatomies'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="anatomy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
