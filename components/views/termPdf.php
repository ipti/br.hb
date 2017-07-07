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

<div class="report-content" id="term">
    <div class="report-head">
        
        <div class="row pdf">
            <div class="col grid-3 pdf">
            <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/hb.png" alt="HB" width="40">
            </div>
            <div class="col grid-6 pdf">
                <h4 class="report-title margin-bottom-5">Autorização</h4>
                <p class="bold">para que seu filho participe de <br> uma campanha de saúde na escola</p>
            </div>
            <div class="col grid-3 pdf">
                <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
            </div>
            
        </div>
        
    </div><!-- .report-head -->

    <div class="report-body">

        <div class="report-row pdf margin-top-15">
            <div class="col grid-12 pdf">
                <p style="text-align: justify; text-justify: inter-word; font-size:14px;">Prezado(a) Senhor(a) <br><br>
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

        <div class="report-row pdf margin-top-25">
            <div class="col grid-3 pdf report-text-left">
                <p> <span class="bold">Nome da criança <br> ou adolescente</span> _ _ _ _ _ _ _ </p>
            </div>
            <div class="col grid-9 pdf report-text-left">
                <p style="padding-top: 17px;"><?= $truncate($data['sName']) ?></p>
        </div>  

        <div class="report-row pdf margin-top-10">
            <div class="col grid-3 pdf report-text-left">
                <p> <span class="bold">Turma</span> _ _ _ _ _ _ _ _ _ _ _ _ _ </p>
            </div>
            <div class="col grid-9 pdf report-text-left">
                <p><?= $truncate($data['cName']) ?> </p>
            </div>
        </div>

        <div class="report-row pdf margin-top-10">
            <div class="col grid-9 pdf">
                <div class="report-row pdf">
                    <div class="col grid-12 pdf report-text-left">
                        <p><span class="bold">[ ] - Assinatura da mãe:</span> <?= $data['mother'] ?> </p>
                    </div>
                    <div class="col grid-12 pdf report-text-left">
                        <p>________________________________________________________________________________________</p>
                    </div>
                </div>
                <div class="report-row pdf margin-top-10">
                    <div class="col grid-12 pdf report-text-left">
                        <p><span class="bold">[ ] - Assinatura do pai:</span> <?= $data['father'] ?>  </p>
                    </div>
                    <div class="col grid-12 pdf report-text-left">
                        <p>________________________________________________________________________________________</p>
                    </div>
                </div>
            </div>
            <div class="col grid-3 pdf right">
                <div class="foto-3-4">
                    
                </div>
            </div>
        </div><!-- .report-row -->  

        <div class="report-row pdf margin-top-25">
            <div class="col grid-3 pdf report-text-left">
                <p><span class="bold">PESO</span>  ____________________&nbsp;&nbsp;&nbsp;</p>
            </div>
            <div class="col grid-3 pdf report-text-left">
                <p><span class="bold">ALTURA</span>  __________________</p>
            </div>
            <div class="col grid-6 pdf report-text-left">
                <p><span class="bold">&nbsp;&nbsp;&nbsp;DATA DA COLETA</span>&nbsp;&nbsp;&nbsp;&nbsp;  _________/_________/_____________</p>
            </div>
        </div>

        <div class="report-row pdf margin-top-5">
            <div class="col grid-12 pdf report-text-left">
                <p class="bold">HB 1</p>
                <p>_________________________________________________________________________________ &nbsp;&nbsp;  _________/_________/_____________</p>
            </div>
        </div>

        <div class="report-row pdf">
            <div class="col grid-12 pdf report-text-left">
                <p class="bold">HB 2</p>
                <p>_________________________________________________________________________________ &nbsp;&nbsp;  _________/_________/_____________</p>
            </div>
        </div>

        <div class="report-row pdf">
            <div class="col grid-12 pdf report-text-left">
                <p class="bold">HB 3</p>
                <p>_________________________________________________________________________________ &nbsp;&nbsp;  _________/_________/_____________</p>
            </div>
        </div>

        <div class="report-row pdf margin-top-10">
            <div class="col grid-12 pdf report-text-left">
                <p class="bold">[ ] - Sulfato ferroso</p>
                <p>____________________________________________________________________________________________________________________</p>
            </div>
        </div>

         <div class="report-row pdf">
            <div class="col grid-12 pdf report-text-left">
                <p class="bold">[ ] - Vermifugo</p>
                <p>____________________________________________________________________________________________________________________</p>
            </div>
        </div>


    </div><!-- .report-body -->

</div> <!-- .report-content -->