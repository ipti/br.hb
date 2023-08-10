<?php

use yii\helpers\Html;
use app\components\ReportHeaderWidget;


$truncate = function($str){
    $str_truncate = '';
    $count = strlen($str) + 1;
    $gap = false;
    while($count < 93){
        if($gap){
            $str_truncate .= "_";
            $gap = false;
        }   
        else{
            $str_truncate .= " ";
            $gap = true;
        }
        ++$count;
    }
    return ('<span>'.$str_truncate.'</span>'.$str);
}

?>

<div class="report-content">
    <div class="report-head">
        
        <div class="row">
            <div class="col grid-3">
                <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/hb.png" alt="HB" width="40">
            </div>
            <div class="col grid-6">
                <h4 class="report-title margin-bottom-5">Carta de Aviso</h4>
            </div>
            <div class="col grid-3">
                <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
            </div>
        </div>
        
    </div><!-- .report-head -->

    <div class="report-body">

        <div class="report-row margin-top-15">
            <div class="col grid-12">
                <p style="text-align: justify; text-justify: inter-word;">Prezados Pais,<br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Como é do conhecimento de vocês, realizamos, a partir de uma gotinha de sangue tirada do dedo <?= $data['sSex'] ? "do seu filho" : "da sua filha" ?> <b>
                    <?= $data['sName'] ?></b>, 
                    um exame que diagnostica a anemia.
                    <br>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Fiquem tranquilos, pois o resultado mostrou que <?= $data['sSex'] ? "ele" : "ela" ?> <b>não encontra-se com anemia.</b>
                    <br>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    O Nível de Hemoglobina encotrado no exame foi  <?= $data['sHb1'] ?>
                </p>
            </div>
        </div> 

        <div class="report-row margin-top-25">
            <div class="col grid-12 report-text-left">
                <p> <span class="bold">Nome da criança <br> ou adolescente:</span> <?= $data['sName'] ?> </p>
            </div>
        </div>  

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p> <span class="bold">Turma:</span> <?= $data['cName'] ?></p>
            </div>
        </div>

        <!-- .report-row -->  

    </div><!-- .report-body -->
</div>
    
</div> <!-- .report-content -->