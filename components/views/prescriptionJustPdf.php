<?php

use yii\helpers\Html;
use app\components\ReportHeaderWidget;

?>

<div class="report-head">        
    <div class="row pdf">
        <div class="col grid-3 pdf">
            <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/hb.png" alt="HB" width="40">
        </div>
        <div class="col grid-6 pdf">
            <h5 class="bold">Receituário</h5>
        </div>
        <div class="col grid-3 pdf">
            <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
        </div>
    </div>
    <?php
    $sulfato = '';
    $vermifugo = '';
    $concentracaoPorML = 25;
    $gotasPorML = 20;
    $concentracaoPorGota = $concentracaoPorML / $gotasPorML;

    $weight = floatval($data['weight']);
    $posologia = ceil($weight / $concentracaoPorGota);

    if ($weight > 30) {
        $sulfato = "<b>Sulfato Ferroso</b> em comprimido, <b>1 Comprimido a cada 12h</b>.";
    } else {
        $sulfato = "<b>Sulfato Ferroso</b> em gotas, <b>$posologia gotas</b>, três vezes ao dia.";
    }
    $vermifugo = "<b>Albendazol</b> em comprimido, (pode dissolver em água ou suco).";
    ?>
    <div class="report-footer" id="prescription">
        <h5 class="margin-bottom-10 bold"><?= $data['name'] ?></h5>
        <p class="no-indent" style="font-size: 11px;"><?= $sulfato ?></p>
        <p class="no-indent" style="font-size: 11px;"><?= $vermifugo ?></p>
    </div>
   
</div>

<div class=footer-pdf></div>

<div class="report-footer ">
        <p class="">___________________________________________________________</p>        
        <p class="">Assinatura do médico responsável</p>        
    </div>