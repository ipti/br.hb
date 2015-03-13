<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = yii::t('app', 'Reports');
?>

<?php

    echo Html::a(yii::t('app', "Letter of Consultation's Notice"), \yii\helpers\Url::toRoute('reports/consultation-letter'));
    echo "<br>";
    echo Html::a(yii::t('app', 'Prescription'), \yii\helpers\Url::toRoute('prescription'));
    echo "<br>";
    echo Html::a(yii::t('app', 'Anamnese'), \yii\helpers\Url::toRoute('anamnese'));
    echo "<br>";
    echo Html::a(yii::t('app', 'Terms'), \yii\helpers\Url::toRoute('terms'));

?>