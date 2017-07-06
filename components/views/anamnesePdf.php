<?php

use yii\helpers\Html;
use app\components\ReportHeaderWidget;

?>

<div class="report-content" id="pdf">
        <div class="report-head">
            
            <div class="row pdf">
                <div class="col grid-3 pdf">
                <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/hb.png" alt="HB" width="40">
                </div>
                <div class="col grid-6 pdf">
                    <h4 class="report-title">Questionário de Anamnese</h4>
                </div>
                <div class="col grid-3 pdf">
                    <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
                </div>
                
            </div>
            
        </div>
        <div class="report-body">
            <div id="anamnese-header">
                <div class="report-row pdf report-text-left">
                    <div class="col grid-6 pdf">
                        <p style="font-size:11px"><span class="bold">Nome:</span> <?= $data['name']; ?></p>
                    </div>
                    <div class="col grid-3 pdf">
                        <p style="font-size:11px"><span class="bold">Peso:</span> <?= $data['weight']; ?></p>
                    </div>
                    <div class="col grid-3 pdf">
                        <p style="font-size:11px"><span class="bold">Idade:</span> <?= $data['age']; ?></p>
                    </div>
                </div>

                <div class="report-row pdf report-text-left">
                    <div class="col grid-6 pdf">
                        <p style="font-size:11px"><span class="bold">Nascimento:</span> <?= $data['birthday']; ?></p>
                    </div>
                    <div class="col grid-3 pdf">
                        <p style="font-size:11px"><span class="bold">Hb1:</span> <?= $data['rate1']; ?></p>
                    </div>
                    <div class="col grid-3 pdf">
                        <p style="font-size:11px"><span class="bold">Altura:</span> <?= $data['height']; ?></p>
                    </div>
                </div>

                <div class="report-row pdf report-text-left">
                    <div class="col grid-6 pdf">
                        <p style="font-size:11px"><span class="bold">Sexo:</span> <?= $data['sex']; ?></p>
                    </div>
                    <div class="col grid-3 pdf">
                        <p style="font-size:11px"><span class="bold">Imc:</span> <?= $data['imc']; ?></p>
                    </div>
                    <div class="col grid-3 pdf">
                    </div>
                </div>
            </div>
            <div class="report-row pdf margin-top-5">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold" style="font-size:11px">A criança já foi internada alguma vez?</p>
                </div>
                <div class="col grid-12 pdf">
                    <div class="report-row pdf">
                        <div class="report-text-left ">
                            <div class="col grid-2 pdf">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" width="18">
                                <p class="left padding-top-2">Sim</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" alt="circle red">
                                <p class="left padding-top-2">Não</p> 
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-row pdf">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold" style="font-size:11px">Se SIM, qual foi o motivo?</p>
                </div>
                <div class="col grid-12 pdf padding-left-5">
                    <hr class="answer-line-full">
                </div>
            </div>

            <div class="report-row pdf">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold" style="font-size:11px">Já teve Pneumonia?</p>
                </div>
                <div class="col grid-12 pdf">
                    <div class="report-row pdf">
                        <div class="report-text-left ">
                            <div class="col  grid-2 pdf">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" alt="circle red">
                                <p class="left padding-top-2">Sim</p>
                            </div>
                            <div class="col  grid-2 pdf">
                                <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" alt="circle red">
                                <p class="left padding-top-2">Não</p>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-row pdf" >
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold" style="font-size:11px">Quantas vezes?</p>
                </div>
                <div class="col grid-12 pdf">
                    <div class="report-row pdf">
                        <div class="report-text-left ">
                            <div class="col grid-2 pdf no-padding-left">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" width="18" alt="circle red">
                                <p class="left padding-top-2">1</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" width="18" alt="circle red">
                                <p class="left padding-top-2">2</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png"  width="14" alt="circle red">
                                <p class="left padding-left-5 padding-top-2">3</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" width="14" alt="circle red">
                                <p class="left padding-left-5 padding-top-2">4</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-row pdf">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold" style="font-size:11px">Tem alergia a algum medicamento?</p>
                </div>
                <div class="col grid-12 pdf">
                    <div class="report-row pdf">
                        <div class="report-text-left ">
                            <div class="col grid-2 pdf padding-left-5">
                                <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" width="14">
                                <p class="left padding-left-5 padding-top-2">Sim</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                                <p class="left padding-top-2">Não</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-row pdf">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold left" style="font-size:11px">Qual?</p>
                </div>
                <div class="col grid-12 pdf padding-left-5">
                    <hr class="answer-line-full">
                </div>
            </div>

            <div class="report-row pdf">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold" style="font-size:11px">Inchava os pés ou as mãos quando era uma bebê?</p>
                </div>
                <div class="col grid-12 pdf">
                    <div class="report-row pdf">
                        <div class="report-text-left ">
                            <div class="col grid-2 pdf padding-left-5">
                                <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" width="14">
                                <p class="left padding-left-5 padding-top-2">Sim</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                                <p class="left padding-top-2">Não</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-row pdf">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold" style="font-size:11px">Sente dor nas pernas com muita frequência?</p>
                </div>
                <div class="col grid-12 pdf">
                    <div class="report-row pdf">
                        <div class="report-text-left ">
                            <div class="col grid-2 pdf padding-left-5">
                                <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" width="14">
                                <p class="left padding-left-5 padding-top-2">Sim</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                                <p class="left padding-top-2">Não</p>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-row pdf">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold" style="font-size:11px">Quantas vezes?</p>
                </div>
                <div class="col grid-12 pdf">
                    <div class="report-row pdf">
                        <div class="report-text-left ">
                            <div class="col grid-2 pdf no-padding-left">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" width="18" alt="circle red">
                                <p class="left padding-top-2">1</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" width="18" alt="circle red">
                                <p class="left padding-top-2">2</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" width="14" alt="circle red">
                                <p class="left padding-left-5 padding-top-2">3</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" width="14" alt="circle red">
                                <p class="left padding-left-5 padding-top-2">4</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-row pdf">
                <div class="col grid-3 pdf report-text-left">
                    <p class="bold padding-top-2" style="font-size:11px">Como foi tratada?</p>
                </div>
                <div class="col grid-3 pdf report-text-left">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Sulfato ferroso</p>
                </div>
                <div class="col grid-2 pdf report-text-left">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Dieta</p>
                </div>
                <div class="col grid-4 pdf report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Outro:____________________________________</p>
                </div>
            </div>

            <div class="report-row pdf margin-top-10">
                <div class="col grid-4 pdf report-text-left no-padding-right">
                    <p class="bold padding-top-2" style="font-size:11px">Melhorou com o tratamento?</p>
                </div>
                <div class="col grid-2 pdf report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Sim</p>
                </div>
                <div class="col grid-2 pdf report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Não</p>
                </div>
                <div class="col grid-4 pdf report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Não complentou o tratamento</p>
                </div>
            </div>

            <div class="report-row pdf margin-top-10">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold"  style="font-size:11px">Existem outras pessoas na família que têm ou já tiveram anemia?</p>
                </div>
                <div class="col grid-12 pdf">
                    <div class="report-row pdf">
                        <div class="report-text-left ">
                            <div class="col grid-2 pdf">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" width="18" alt="circle red">
                                <p class="left padding-top-2">Sim</p>
                            </div>
                            <div class="col grid-2 pdf">
                                <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" alt="circle red">
                                <p class="left padding-top-2">Não</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="report-row pdf margin-top-10">
                <div class="col grid-3 pdf report-text-left">
                    <p class="bold padding-top-2" style="font-size:11px">Se SIM, quem?</p>
                </div>
                <div class="col grid-2 pdf report-text-left">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Irmão(a)</p>
                </div>
                <div class="col grid-3 pdf report-text-left">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Pai ou mão</p>
                </div>
                <div class="col grid-4 pdf report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"  width="18" >
                    <p class="left padding-top-2">Outro:____________________________________</p>
                </div>
            </div>

            <div class="report-row pdf margin-top-10">
                <div class="col grid-12 pdf report-text-left">
                    <p class="bold">Legenda:</p>
                </div>
                <div class="col grid-12 pdf report-text-left">
                    <p class="left">Caso seja marcado uma opção com <img width="14" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" width="14" >
                    ou 3 com <img width="14" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" width="18">no formulário acima é necessário que o aluno seja encaminhado para
exame clínico.  Caso apareça uma opção ou 2 <img width="14" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" width="18">, temos um caso intermediário, em que o médico pode ou não examinar.
                    </p>
                </div>
            </div>
            
        </div> <!-- .report-body -->
            <div class="report-head">
                <div class="divider-dashed margin-top-25 margin-bottom-25"></div>
                <div class="margin-top-10"></div>
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
                    $sulfato ='';
                    $vermifugo ='';
                    $concentracaoPorML = 25;
                    $gotasPorML = 20;
                    $concentracaoPorGota = $concentracaoPorML / $gotasPorML;

                    $posologia = ceil($data['weight'] / $concentracaoPorGota);

                    if ($data['weight'] > 30) {
                        $sulfato = "<b>Sulfato Ferroso</b> em comprimido, <b>1 Comprimido a cada 12h</b>.";
                    } else {
                        $sulfato = "<b>Sulfato Ferroso</b> em gotas, <b>$posologia gotas</b>, três vezes ao dia.";
                    }
                    $vermifugo = "<b>Albendazol</b> em comprimido, (pode dissolver em água ou suco).";
                ?>
                <div class="report-footer margin-bottom-10" id="prescription">
                    <h5 class="margin-bottom-10 bold"><?= $data['name'] ?></h5>
                    <p class="no-indent" style="font-size: 11px;"><?= $sulfato ?></p>
                    <p class="no-indent" style="font-size: 11px;"><?= $vermifugo ?></p>
                </div>
            </div>

        
        
    </div> <!-- .report-content -->