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
                <h4 class="report-title margin-bottom-5"><?= $data['isConsutationLetters'] ? "Carta de Aviso de Consulta" : "Carta de Aviso" ?></h4>
            </div>
            <div class="col grid-3">
                <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
            </div>
        </div>
        
    </div><!-- .report-head -->
    <?php if(!$data['isConsutationLetters']){ ?>
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

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left"> 
                    
            <p>Gostaríamos de pedir a vocês para já prestarem atenção na alimentação <?= $data['sSex'] ? "do seu filho" : "da sua filha" ?>  principalmente nestes pontos:<br/><br/>
            <b>1 – Devemos oferecer às crianças, sempre que possível, carnes (de boi, frango ou peixe), feijão e folhas escuras, como couve e brócolis;<br/><br/>
               2 – Devemos oferecer às crianças, logo após as refeições, sucos de frutas, principalmente as cítricas, como laranja e limão;<br/><br/>
               3 – Não devemos deixar as crianças tomarem refrigerantes, chá ou café junto das refeições;<br/><br/>
               4 – Lembrem-se também que leite faz muito bem, mas não junto das refeições. É melhor deixar passar duas horas após a refeição para dar leite às crianças.<br/></b><p/>
               Com estas medidas podemos ajudar as nossas crianças a ficarem sempre saudáveis e alegres.<br/><br/>
            </div>
        </div>  

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p> 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Com estas medidas podemos ajudar as nossas crianças a ficarem sempre saudáveis e alegres.
                </p>
            </div>
        </div>  
        <!-- .report-row -->  

    </div><!-- .report-body -->
    <?php }else{ ?>
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
                    Ficamos preocupados, pois o resultado mostrou que <?= $data['sSex'] ? "ele" : "ela" ?> <b>encontra-se com anemia.</b> Vocês deverão levar
                    <?= $data['sSex'] ? "seu filho" : "sua filha" ?> à consulta médica, para que ele receba o tratamento:
                </p>
                </div>
            </div> 
            <div class="report-row margin-top-10">
                <div class="col grid-12 report-text-left">           
                    <P>
                        <b>Dia da Consulta:</b>
                    </P>
                    <P>
                        <b>Hora da Consulta:</b> 
                    </P>
                    <P>
                        <b>Local da Consulta:</b> 
                    </P>
                    </div>
                </div> 
            </div>
            <div class="report-row margin-top-10">
                <div class="col grid-12 report-text-left"> 
                        
                <p>Gostaríamos de pedir a vocês para já prestarem atenção na alimentação <?= $data['sSex'] ? "do seu filho" : "da sua filha" ?>  principalmente nestes pontos:<br/><br/>
                <b>1 – Devemos oferecer às crianças, sempre que possível, carnes (de boi, frango ou peixe), feijão e folhas escuras, como couve e brócolis;<br/><br/>
                2 – Devemos oferecer às crianças, logo após as refeições, sucos de frutas, principalmente as cítricas, como laranja e limão;<br/><br/>
                3 – Não devemos deixar as crianças tomarem refrigerantes, chá ou café junto das refeições;<br/><br/>
                4 – Lembrem-se também que leite faz muito bem, mas não junto das refeições. É melhor deixar passar duas horas após a refeição para dar leite às crianças.<br/></b><p/>
                Com estas medidas podemos ajudar as nossas crianças a ficarem sempre saudáveis e alegres.<br/><br/>
                </div>
            </div>
            <div>Muito obrigado pela atenção.</div> 
        </div>
    <?php }?>
</div>
    
</div> <!-- .report-content -->