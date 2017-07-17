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
                <h4 class="report-title margin-bottom-5">Autorização</h4>
                <p class="bold">para que seu filho participe de <br> uma campanha de saúde na escola</p>
            </div>
            <div class="col grid-3">
                <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
            </div>
        </div>
        
    </div><!-- .report-head -->

    <div class="report-body">

        <div class="report-row margin-top-15">
            <div class="col grid-12">
                <p style="text-align: justify; text-justify: inter-word;">Prezado(a) Senhor(a) <br><br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Caso o senhor(a) concorde, o seu filho(a) será submetido(a) a uma punção da extremidade do dedo médio da
                    mão esquerda, com lancetador de lancetas descartáveis, para a obtenção de uma pequena gota de sangue. Esta
                    punção será feita por profissional treinado e a criança sentirá somente um pequeno desconforto, sendo que não
                    há riscos à sua saúde. Com esta gota de sangue, faremos a dosagem da concentração de hemoglobina, dado que
                    será utilizada para o diagnóstico de anemia.
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Caso o senhor(a) concorde, por favor assine este termo.
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

        <div class="report-row margin-top-10">
            <div class="col grid-10">
                <div class="report-row">
                    <div class="col grid-12 report-text-left">
                        <p><span class="bold">[ ] - Assinatura da mãe:</span> <?= $data['mother'] ?> </p>
                    </div>
                    <div class="col grid-12 report-text-left">
                        <hr class="line">
                    </div>
                </div>
                <div class="report-row margin-top-10">
                    <div class="col grid-12 report-text-left">
                        <p><span class="bold">[ ] - Assinatura do pai:</span> <?= $data['father'] ?>  </p>
                    </div>
                    <div class="col grid-12 report-text-left">
                        <hr class="line">
                    </div>
                </div>
            </div>
            <div class="col grid-2 right">
                <div class="foto-3-4" style="float: right; height: 130px; width: 100px;"> </div>
            </div>
        </div><!-- .report-row -->  

        <div class="report-row margin-top-25">
            <div class="col grid-3 report-text-left">
                <p class="left"><span class="bold">PESO </span></p>
                <div class="left" style="width:110px;"><hr class="line-inline"></div>
            </div>
            <div class="col grid-3 report-text-left">
                <p class="left"><span class="bold">ALTURA </span></p>
                <div class="left" style="width:110px;"><hr class="line-inline"></div>
            </div>
            <div class="col grid-6 report-text-left">
                <p class="left"><span class="bold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATA DA COLETA </span></p>
                <div class="left" style="width:60px;"><hr class="line-inline"></div><p class="left">/</p>
                <div class="left" style="width:60px;"><hr class="line-inline"></div><p class="left">/</p>
                <div class="left" style="width:110px;"><hr class="line-inline"></div>
            </div>
        </div>

        <div class="report-row  margin-top-25">
            <div class="col grid-12 report-text-left">
                <p class="bold">HB 1</p>
                <div class="margin-top-10">
                    <div class="left" style="width:605px">
                        <hr class="line-inline">
                    </div>
                    <p class="left">&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <div class="left" style="width:60px;"><hr class="line-inline"></div><p class="left">/</p>
                    <div class="left" style="width:60px;"><hr class="line-inline"></div><p class="left">/</p>
                    <div class="left" style="width:110px;"><hr class="line-inline"></div>
                </div>
            </div>
            <div class="col grid-3 report-text-left">
                
            </div>
        </div>

        <div class="report-row  margin-top-25">
            <div class="col grid-12 report-text-left">
                <p class="bold">HB 2</p>
                <div class="margin-top-10">
                    <div class="left" style="width:605px">
                        <hr class="line-inline">
                    </div>
                    <p class="left">&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <div class="left" style="width:60px;"><hr class="line-inline"></div><p class="left">/</p>
                    <div class="left" style="width:60px;"><hr class="line-inline"></div><p class="left">/</p>
                    <div class="left" style="width:110px;"><hr class="line-inline"></div>
                </div>
            </div>
            <div class="col grid-3 report-text-left">
                
            </div>
        </div>

        <div class="report-row  margin-top-25">
            <div class="col grid-12 report-text-left">
                <p class="bold">HB 3</p>
                <div class="margin-top-10">
                    <div class="left" style="width:605px">
                        <hr class="line-inline">
                    </div>
                    <p class="left">&nbsp;&nbsp;&nbsp;&nbsp;</p>
                    <div class="left" style="width:60px;"><hr class="line-inline"></div><p class="left">/</p>
                    <div class="left" style="width:60px;"><hr class="line-inline"></div><p class="left">/</p>
                    <div class="left" style="width:110px;"><hr class="line-inline"></div>
                </div>
            </div>
            <div class="col grid-3 report-text-left">
                
            </div>
        </div>

        <div class="report-row margin-top-25">
            <div class="col grid-12 report-text-left">
                <p class="bold">[  ] - Sulfato </p>
                <div class="margin-top-25" style="width: 854px;"><hr class="line-inline"></div>
            </div>
        </div>

         <div class="report-row  margin-top-25">
            <div class="col grid-12 report-text-left">
                <p class="bold">[  ] - Vermifugo </p>
                <div class="margin-top-25" style="width: 854px;"><hr class="line-inline"></div>
            </div>
        </div>

    </div><!-- .report-body -->
</div>
    
</div> <!-- .report-content -->