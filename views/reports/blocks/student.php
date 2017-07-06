<?php
/* @var $this yii\web\View  */

use yii\helpers\Html;
use yii\helpers\Url;

?>
<div id="anamnese-header">
    <div class="report-row report-text-left margin-top-25">
        <div class="col grid-6">
            <p><span>Nome:</span> <?= $data['name'] ?></p>
        </div>
        <div class="col grid-3">
            <p><span>Peso:</span> <?= $data['weight'] ?></p>
        </div>
        <div class="col grid-3">
            <p><span>Idade:</span> <?= $data['age'] ?></p>
        </div>
    </div>

    <div class="report-row report-text-left">
        <div class="col grid-6">
            <p><span>Nascimento:</span> <?= $data['birthday'] ?></p>
        </div>
        <div class="col grid-3">
            <p><span>Hb1:</span> <?= $data['rate1'] ?></p>
        </div>
        <div class="col grid-3">
            <p><span>Altura:</span> <?= $data['height'] ?></p>
        </div>
    </div>

    <div class="report-row report-text-left">
        <div class="col grid-6">
            <p><span>Sexo:</span> <?= $data['sex'] ?></p>
        </div>
        <div class="col grid-3">
            <p><span>Imc:</span> <?= $data['imc'] ?></p>
        </div>
        <div class="col grid-3">
        </div>
    </div>
</div>