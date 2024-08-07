<?php

use yii\helpers\Html;
use app\components\ReportHeaderWidget;

$this->title = "Todas as cartas Anamnese";
?>


<div class="mpdf-page-number" id="pdf">
    <div class="row" id="health-header">
        <div class="col grid-3 pdf">
            <img style="float:left;" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/hb.png" alt="HB" width="40">
        </div>
        <div class="col grid-6 pdf">
            <h4 id="health-title" class="report-title text-left">Questionario Anamnese</h4>
        </div>
        <div class="col grid-3 pdf">
            <img src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/apoio.png" alt="Apoio" width="220">
        </div>
    </div>
    <div class="report-body">
        <div id="anamnese-header">
            <div class="report-row report-text-left">
                <div class="col grid-6">
                    <p><span>Nome:</span>
                        <?= $data['name']; ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Peso:</span>
                        <?= $data['weight']; ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Idade:</span>
                        <?= $data['age']; ?>
                    </p>
                </div>
            </div>

            <div class="report-row report-text-left">
                <div class="col grid-6">
                    <p><span>Nascimento:</span>
                        <?= $data['birthday']; ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Hb1:</span>
                        <?= $data['rate1']; ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Altura:</span>
                        <?= $data['height']; ?>
                    </p>
                </div>
            </div>

            <div class="report-row report-text-left">
                <div class="col grid-6">
                    <p><span>Sexo:</span>
                        <?= $data['sex']; ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Imc:</span>
                        <?= $data['imc']; ?>
                    </p>
                </div>
                <div class="col grid-3">
                </div>
            </div>
        </div>
        <div class="report-row margin-top-10" id='impar'>
            <div class="col grid-12 report-text-left">
                <p class="bold">A criança já foi internada alguma vez?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 no-padding-left">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                            <p class="left">Sim</p>
                        </div>
                        <div class="col grid-2 no-padding-left">
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">Não</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row" id='par'>
            <div class="col grid-12 report-text-left">
                <p class="bold">Se SIM, qual foi o motivo? _____________________________________________________________________________________________________________________
                </p>
            </div>
        </div>

        <div class="report-row margin-top-10" id='impar'>
            <div class="col grid-12 report-text-left">
                <p class="bold">Já teve Pneumonia?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 no-padding-left">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">Sim</p>
                        </div>
                        <div class="col grid-2 no-padding-left">
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">Não</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10" id='par'>
            <div class="col grid-12 report-text-left">
                <p class="bold">Quantas vezes?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 no-padding-left">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                            <p class="left">1</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                            <p class="left">2</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" alt="circle red">
                            <p class="left padding-left-5">3</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" alt="circle red">
                            <p class="left padding-left-5">4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Tem alergia a algum medicamento?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 grid-2 padding-left-5">
                            <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                            <p class="left padding-left-5">Sim</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                            <p class="left">Não</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Qual?
                    ___________________________________________________________________________________________________________________________________________
                </p>
            </div>

        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Inchava os pés ou as mãos quando era uma bebê?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 grid-2 padding-left-5">
                            <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                            <p class="left padding-left-5">Sim</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                            <p class="left">Não</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Sente dor nas pernas com muita frequência?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 grid-2 padding-left-5">
                            <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                            <p class="left padding-left-5">Sim</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                            <p class="left">Não</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Quantas vezes?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 no-padding-left">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                            <p class="left">1</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                            <p class="left">2</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" alt="circle red">
                            <p class="left padding-left-5">3</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" alt="circle red">
                            <p class="left padding-left-5">4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Como foi tratada?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="col grid-3 report-text-left no-padding-left">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">Sulfato ferroso</p>
                    </div>
                    <div class="col grid-2 report-text-left">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">Dieta</p>
                    </div>
                    <div class="col grid-5 report-text-left no-padding">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">
                            Outro:____________________________________________________________
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-4 report-text-left no-padding-right">
                <p class="bold">Melhorou com o tratamento?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="col grid-2 report-text-left no-padding">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">Sim</p>
                    </div>
                    <div class="col grid-2 report-text-left no-padding">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">Não</p>
                    </div>
                    <div class="col grid-4 report-text-left no-padding">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">Não complentou o tratamento</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div id='par' class="col grid-12 report-text-left">
                <p class="bold">Já teve anemia anteriormente?</p>
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 no-padding-left">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">Sim</p>
                        </div>
                        <div class="col grid-2 no-padding-left">
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">Não</p>
                        </div>
                    </div>
                </div>
                <p class="bold">Quantas vezes?</p>
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 no-padding-left">
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">1</p>
                        </div>
                        <div class="col grid-2 no-padding-left">
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">2</p>
                        </div>
                        <div class="col grid-2 no-padding-left">
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">3</p>
                        </div>
                        <div class="col grid-2 no-padding-left">
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">4 ou mais</p>
                        </div>
                    </div>
                </div>
                <p class="bold">
                    Como foi tratada? _______________________________________________________________________________________________________________________________
                </p>
            </div>
            <div class="col grid-12 report-text-left">
                <p class="bold">Existem outras pessoas na família que têm ou já tiveram anemia?</p>
            </div>

            <div class="col grid-12">
                <div class="report-row">
                    <div class="col grid-2 report-text-left no-padding">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                        <p class="left">Sim</p>
                    </div>
                    <div class="col grid-2 report-text-left no-padding">
                        <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                        <p class="left">Não</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-3 report-text-left">
                <p class="bold">Se SIM, quem?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="col grid-2 report-text-left no-padding-left">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">Irmão(a)</p>
                    </div>
                    <div class="col grid-3 report-text-left">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">Pai ou mão</p>
                    </div>
                    <div class="col grid-5 report-text-left no-padding">
                        <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                        <p class="left">
                            Outro:________________________________________________________________
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="footer-print">
        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Legenda:</p>
            </div>
            <div class="col grid-12 report-text-left">
                <p class="left">Caso seja marcado uma opção com <img width="20" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                    ou 3 com <img width="20" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png">no formulário
                    acima é
                    necessário que o aluno seja encaminhado para
                    exame clínico. Caso apareça uma ou duas opções <img width="20" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png">, temos um caso
                    intermediário, em que o médico pode ou não examinar.
                </p>
            </div>
        </div>
    </div>