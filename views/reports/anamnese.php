<?php
/* @var $this yii\web\View  */
/* @var $enrollment \app\models\enrollment */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;
use app\components\ReportHeaderWidget;

use app\models\campaign;

use kartik\builder\Form;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;

$this->title = yii::t('app', 'Anamnese');
$this->assetBundles['Reports'] = new app\assets\AppAsset();
$this->assetBundles['Reports']->js = [
    'scripts/ReportsView/Functions.js',
    'scripts/ReportsView/Click.js'
];
?>
<div class="report">
    <div class="report-filter hidden-print">
<?php
        echo Html::beginForm(Url::toRoute('reports/get-anamnese'),'POST',['id'=>'form-anamnese', 'class'=>'form-vertical']);
        if(isset($enrollment) && $enrollment != null){
            echo Form::widget([
                'formName' => 'anamnese-form',
                'columns'=>1,
                'attributes' => [
                    'campaign'=>[
                        'type'=>Form::INPUT_RAW,
                        'value' => Html::hiddenInput('anamnese-form[campaign]', $campaign)
                    ],
                    'campaign-enrollment'=>[
                        'type'=>Form::INPUT_RAW,
                        'value' => Html::hiddenInput('anamnese-form[campaign-enrollment]', $enrollment->id)
                    ],
                    'name'=>[
                        'label'=>yii::t('app', 'Student'), 
                        'type'=>Form::INPUT_STATIC,
                        'value'=>$enrollment->students->name
                    ],
                ]
            ]);
            //$js = "$('#submit-anamnese').trigger('click')";
            //$this->registerJs($js,$this::POS_READY);
        }else{
            echo Form::widget([
                'formName' => 'anamnese-form',
                'columns'=>4,
                'attributes' => [
                    'campaign' => [
                        'label'=>yii::t('app', 'Campaign'), 
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => Select2::class,
                        'options'=>[
                            'data' => ArrayHelper::map(campaign::find()->all(), 'id', 'name'),
                            'options' => [
                                'placeholder' => yii::t('app', 'Select Campaign...'),
                            ],
                            'pluginOptions' => ['allowClear' => true]
                        ],
                    ],
                    'campaign-school' => [
                        'label'=>yii::t('app', 'School'), 
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => DepDrop::class,
                        'options'=>[
                            'data' => [],
                            'options' => [
                                'placeholder' => yii::t('app', 'Select School...'),
                            ],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => ['anamnese-form-campaign'],
                                'url' => Url::to(['/campaign/get-schools-list']),
                                'loadingText' => yii::t('app', 'Loading Schools...'),
                            ]
                        ],
                    ],
                    'campaign-classroom' => [
                        'label'=>yii::t('app', 'Classroom'), 
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => DepDrop::class,
                        'options'=>[
                            'data' => [],
                            'options' => [
                                'placeholder' => yii::t('app', 'Select Classroom...'),
                            ],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => ['anamnese-form-campaign'],
                                'depends' => ['anamnese-form-campaign-school'],
                                'url' => Url::to(['/campaign/get-classrooms-list']),
                                'loadingText' => yii::t('app', 'Loading Classrooms...'),
                            ]
                        ],
                    ],
                    'campaign-enrollment' => [
                        'label'=>yii::t('app', 'Student'), 
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => DepDrop::class,
                        'options'=>[
                            'data' => [],
                            'options' => [
                                'placeholder' => yii::t('app', 'Select Student...'),
                            ],
                            'type' => DepDrop::TYPE_SELECT2,
                            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                            'pluginOptions' => [
                                'depends' => ['anamnese-form-campaign'],
                                'depends' => ['anamnese-form-campaign-school'],
                                'depends' => ['anamnese-form-campaign-classroom'],
                                'url' => Url::to(['/campaign/get-enrollments-list']),
                                'loadingText' => yii::t('app', 'Loading Students...'),
                            ]
                        ],
                    ],
                ]
            ]); 
        }
        echo Form::widget([
            'formName' => 'anamnese-form',
            'columns'=>1,
            'attributes' => [
                'actions'=>[
                    'type'=>Form::INPUT_RAW, 
                    'value'=>'<div class="pull-right">' . 
                        Html::button(Icon::show('refresh',[], Icon::FA).Yii::t('app', 'Generate'), ['id'=>'submit-anamnese', 'type'=>'button', 'class'=>'btn btn-primary']) . 
                    '</div>'
                ],
            ]
        ]); 
        echo Html::endForm(); 
        ?>
    </div>

    <div class="report-content">
        <div class="report-head">
            <div class="pull-right hidden-print">
                <?=Html::button(Icon::show('print',[], Icon::FA).Yii::t('app', 'Print'), ['id'=>'print-button', 'class'=>'btn btn-primary fixed-btn', 'onclick'=>'window.print()'])?>
            </div>
            <?= ReportHeaderWidget::widget(); ?>
            <h4 class="report-title">Questionário de Anamnese</h4>
        </div>
        <div class="report-body">
            <div id="anamnese-header">
                <div class="report-row report-text-left margin-top-25">
                    <div class="col grid-6">
                        <p><span>Nome:</span></p>
                    </div>
                    <div class="col grid-3">
                        <p><span>Peso:</span></p>
                    </div>
                    <div class="col grid-3">
                        <p><span>Idade:</span></p>
                    </div>
                </div>

                <div class="report-row report-text-left">
                    <div class="col grid-6">
                        <p><span>Nascimento:</span></p>
                    </div>
                    <div class="col grid-3">
                        <p><span>Hb1:</span></p>
                    </div>
                    <div class="col grid-3">
                        <p><span>Altura:</span></p>
                    </div>
                </div>

                <div class="report-row report-text-left">
                    <div class="col grid-6">
                        <p><span>Sexo:</span></p>
                    </div>
                    <div class="col grid-3">
                        <p><span>Imc:</span></p>
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
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                            <p class="left">Sim</p>
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
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
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
                            <p class="left">Sim</p>
                            <img class="left  img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" alt="circle red">
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

            <div class="report-row">
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
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
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
                                <img class="left" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png">
                                <p class="left padding-left-5">Sim</p>
                            </div>
                            <div class="col grid-2">
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
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
                                <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
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
                <div class="col grid-3 report-text-left">
                    <p class="bold">Como foi tratada?</p>
                </div>
                <div class="col grid-3 report-text-left">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
                    <p class="left">Sulfato ferroso</p>
                </div>
                <div class="col grid-2 report-text-left">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
                    <p class="left">Dieta</p>
                </div>
                <div class="col grid-3 report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
                    <p class="left">Outro:____________________</p>
                </div>
            </div>

            <div class="report-row margin-top-10">
                <div class="col grid-4 report-text-left no-padding-right">
                    <p class="bold">Melhorou com o tratamento?</p>
                </div>
                <div class="col grid-2 report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
                    <p class="left">Sim</p>
                </div>
                <div class="col grid-2 report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
                    <p class="left">Não</p>
                </div>
                <div class="col grid-4 report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
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
                            <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png" alt="circle red">
                            <p class="left">Sim</p>
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
                <div class="col grid-2 report-text-left">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
                    <p class="left">Irmão(a)</p>
                </div>
                <div class="col grid-3 report-text-left">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
                    <p class="left">Pai ou mão</p>
                </div>
                <div class="col grid-3 report-text-left no-padding">
                    <img class="left img-circle" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-stroke.png" >
                    <p class="left">Outro:____________________</p>
                </div>
            </div>

            <div class="report-row margin-top-10">
                <div class="col grid-12 report-text-left">
                    <p class="bold">Legenda:</p>
                </div>
                <div class="col grid-12 report-text-left">
                    <p class="left">Caso seja marcado uma opção com <img width="20" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/triple-circle.png" >
                    ou 3 com <img width="20" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png">no formulário acima é necessário que o aluno seja encaminhado para
exame clínico.  Caso apareça uma opção ou 2 <img width="20" src="<?php echo Yii::getAlias('@web'); ?>/images/reporters/circle-red.png">, temos um caso intermediário, em que o médico pode ou não examinar.
                    </p>
                </div>
            </div>
            
        </div> <!-- .report-body -->
            <div class="report-head">
                <div class="divider-dashed margin-top-10"></div>
                <div class="margin-top-10"></div>
                <?= ReportHeaderWidget::widget(); ?>
                <h5 class="report-title">Receituário</h5>
                <div id="prescription">
                    <h2 class="report-title margin-bottom-15"></h2>
                    <p class="no-indent"></p>
                    <p class="no-indent"></p>
                </div>
            </div>

        
        
    </div> <!-- .report-content -->
</div>