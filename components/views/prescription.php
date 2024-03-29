<?php
use app\components\ReportHeaderWidget;

$this->title = "Todas as prescrições";
?>

<div class="report-content">
    <div class="report-head">
        <?= ReportHeaderWidget::widget(); ?>
        <h4 class="report-title">Questionário de Anamnese</h4>
    </div>
    <div class="report-body">
        <div id="anamnese-header">
            <div class="report-row report-text-left margin-top-25">
                <div class="col grid-6">
                    <p><span>Nome: </span>
                        <?= $student['name'] ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Peso: </span>
                        <?= $student['weight'] ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Idade: </span>
                        <?= $student['age'] ?>
                    </p>
                </div>
            </div>

            <div class="report-row report-text-left">
                <div class="col grid-6">
                    <p><span>Nascimento: </span>
                        <?= $student['birthday'] ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Hb1: </span>
                        <?= $student['rate1'] ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Altura: </span>
                        <?= $student['height'] ?>
                    </p>
                </div>
            </div>

            <div class="report-row report-text-left">
                <div class="col grid-6">
                    <p><span>Sexo: </span>
                        <?= $student['sex'] ?>
                    </p>
                </div>
                <div class="col grid-3">
                    <p><span>Imc: </span>
                        <?= $student['imc'] ?>
                    </p>
                </div>
                <div class="col grid-3">
                </div>
            </div>
        </div>
        <div class="report-row margin-top-15" id='impar'>
            <div class="col grid-12 report-text-left">
                <p class="bold">A criança já foi internada alguma vez?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <img class="left img-circle"
                            src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                        <p class="left">Sim</p>
                        <img class="left  img-circle"
                            src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"
                            alt="circle red">
                        <p class="left">Não</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row" id='par'>
            <div class="col grid-12 report-text-left">
                <p class="bold">Se SIM, qual foi o motivo?</p>
            </div>
            <div class="col grid-12 padding-left-10">
                <hr class="answer-line-full">
            </div>
        </div>

        <div class="report-row" id='impar'>
            <div class="col grid-12 report-text-left">
                <p class="bold">Já teve Pneumonia?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <img class="left img-circle"
                            src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"
                            alt="circle red">
                        <p class="left">Sim</p>
                        <img class="left  img-circle"
                            src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"
                            alt="circle red">
                        <p class="left">Não</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row" id='par'>
            <div class="col grid-12 report-text-left">
                <p class="bold">Quantas vezes?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 no-padding-left">
                            <img class="left img-circle"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png"
                                alt="circle red">
                            <p class="left">1</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left  img-circle"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png"
                                alt="circle red">
                            <p class="left">2</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png"
                                alt="circle red">
                            <p class="left padding-left-5">3</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png"
                                alt="circle red">
                            <p class="left padding-left-5">4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row">
            <div class="col grid-12 report-text-left">
                <p class="bold">Tem alergia a algum medicamento?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 grid-2 padding-left-5">
                            <img class="left"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                            <p class="left padding-left-5">Sim</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left img-circle"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                            <p class="left">Não</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="report-row">
            <div class="col grid-12 report-text-left">
                <p class="bold left">Qual?</p>
            </div>
            <div class="col grid-12 padding-left-10">
                <hr class="answer-line-full">
            </div>
        </div>

        <div class="report-row">
            <div class="col grid-12 report-text-left">
                <p class="bold">Inchava os pés ou as mãos quando era uma bebê?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <div class="col grid-2 grid-2 padding-left-5">
                            <img class="left"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                            <p class="left padding-left-5">Sim</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left img-circle"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
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
                            <img class="left"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                            <p class="left padding-left-5">Sim</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left img-circle"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
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
                            <img class="left img-circle"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png"
                                alt="circle red">
                            <p class="left">1</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left  img-circle"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png"
                                alt="circle red">
                            <p class="left">2</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png"
                                alt="circle red">
                            <p class="left padding-left-5">3</p>
                        </div>
                        <div class="col grid-2">
                            <img class="left"
                                src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png"
                                alt="circle red">
                            <p class="left padding-left-5">4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-3 report-text-left">
                <p class="bold">Como foi tratada?</p>
            </div>
            <div class="col grid-3 report-text-left">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Sulfato ferroso</p>
            </div>
            <div class="col grid-2 report-text-left">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Dieta</p>
            </div>
            <div class="col grid-3 report-text-left no-padding">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Outro:____________________</p>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-4 report-text-left no-padding-right">
                <p class="bold">Melhorou com o tratamento?</p>
            </div>
            <div class="col grid-2 report-text-left no-padding">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Sim</p>
            </div>
            <div class="col grid-2 report-text-left no-padding">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Não</p>
            </div>
            <div class="col grid-4 report-text-left no-padding">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Não complentou o tratamento</p>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Existem outras pessoas na família que têm ou já tiveram anemia?</p>
            </div>
            <div class="col grid-12">
                <div class="report-row">
                    <div class="report-text-left ">
                        <img class="left img-circle"
                            src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                        <p class="left">Sim</p>
                        <img class="left  img-circle"
                            src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png"
                            alt="circle red">
                        <p class="left">Não</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-3 report-text-left">
                <p class="bold">Se SIM, quem?</p>
            </div>
            <div class="col grid-2 report-text-left">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Irmão(a)</p>
            </div>
            <div class="col grid-3 report-text-left">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Pai ou mãe</p>
            </div>
            <div class="col grid-3 report-text-left no-padding">
                <img class="left img-circle"
                    src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png">
                <p class="left">Outro:____________________</p>
            </div>
        </div>

        <div class="report-row margin-top-10">
            <div class="col grid-12 report-text-left">
                <p class="bold">Legenda:</p>
            </div>
            <div class="col grid-12 report-text-left">
                <p class="left">Caso seja marcado uma opção com <img width="20"
                        src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                    ou 3 com <img width="20"
                        src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png">no formulário acima é
                    necessário que o aluno seja encaminhado para
                    exame clínico. Caso apareça uma opção ou 2 <img width="20"
                        src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png">, temos um caso
                    intermediário, em que o médico pode ou não examinar.
                </p>
            </div>
        </div>
        </div>
    </div> <!-- .report-body -->
    <div class="report-head">
        <div class="divider-dashed margin-top-10"></div>
        <div class="margin-top-10"></div>
        <?= ReportHeaderWidget::widget(); ?>
        <h5 class="report-title">Receituário</h5>
        <div id="prescription">
            <h2 class="report-title margin-bottom-15">
                <?= $student['name'] ?>
            </h2>
            <p class="no-indent">
                <?= $sulfato ?>
            </p>
            <p class="no-indent">
                <?= $vermifugo ?>
            </p>
        </div>
    </div>



</div> <!-- .report-content -->