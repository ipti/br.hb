
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;

use app\models\campaign;

use kartik\builder\Form;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;

$this->title = yii::t('app', 'Termos');
?>
<div class="report">
    <div class="report-filter hidden-print">
    <?php
        echo Html::beginForm(Url::toRoute('reports/get-consultation-letter'), 'POST', ['id' => 'form-consultation-letter', 'class' => 'form-vertical']);

        echo Form::widget([
            'formName' => 'consultation-letter-form',
            'columns' => 4,
            'attributes' => [
                'campaign' => [
                    'label' => yii::t('app', 'Campaign'),
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => Select2::className(),
                    'options' => [
                        'data' => ArrayHelper::map(campaign::find()->all(), 'id', 'name'),
                        'options' => [
                            'placeholder' => yii::t('app', 'Select Campaign...'),
                        ],
                        'pluginOptions' => ['allowClear' => true]
                    ],
                ],
                'campaign-school' => [
                    'label' => yii::t('app', 'School'),
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => DepDrop::className(),
                    'options' => [
                        'data' => [],
                        'options' => [
                            'placeholder' => yii::t('app', 'Select School...'),
                        ],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['consultation-letter-form-campaign'],
                            'url' => Url::to(['/campaign/get-schools-list']),
                            'loadingText' => yii::t('app', 'Loading Schools...'),
                        ]
                    ],
                ],
                'campaign-classroom' => [
                    'label' => yii::t('app', 'Classroom'),
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => DepDrop::className(),
                    'options' => [
                        'data' => [],
                        'options' => [
                            'placeholder' => yii::t('app', 'Select Classroom...'),
                        ],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['consultation-letter-form-campaign'],
                            'depends' => ['consultation-letter-form-campaign-school'],
                            'url' => Url::to(['/campaign/get-classrooms-list']),
                            'loadingText' => yii::t('app', 'Loading Classrooms...'),
                        ]
                    ],
                ],
                'campaign-student' => [
                    'label' => yii::t('app', 'Student'),
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => DepDrop::className(),
                    'options' => [
                        'data' => [],
                        'options' => [
                            'placeholder' => yii::t('app', 'Select Student...'),
                        ],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['consultation-letter-form-campaign'],
                            'depends' => ['consultation-letter-form-campaign-school'],
                            'depends' => ['consultation-letter-form-campaign-classroom'],
                            'url' => Url::to(['/campaign/get-students-list']),
                            'loadingText' => yii::t('app', 'Loading Students...'),
                        ]
                    ],
                ],
            ]
        ]);
        echo Form::widget([
            'formName' => 'consultation-letter-form',
            'columns' => 1,
            'attributes' => [
                'actions' => [
                    'type' => Form::INPUT_RAW,
                    'value' => '<div class="pull-right">' .
                    Html::resetButton(Icon::show('recycle', [], Icon::FA) . 'Reset', ['class' => 'btn btn-default']) . ' ' .
                    Html::button(Icon::show('refresh', [], Icon::FA) . 'Generate', ['id' => 'submit-consultation-letter', 'type' => 'button', 'class' => 'btn btn-primary']) .
                    '</div>'
                ],
            ]
        ]);
        echo Html::endForm();
    ?>
    </div>
    <div class="report-content">
        <div class="report-head">
            <div class="report-head-image"></div>
            Autorização para que seu filho participe de uma campanha de saúde na escola
        </div>
        <div class="report-body">
            <br>

            <p>
                Prezado(a) Senhor(a) <br><br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Caso o senhor(a) concorde, o seu filho(a) será submetido a uma punção da extremidade do dedo médio da
                mão esquerda, com lancetador de lancetas descartáveis, para a obtenção de uma pequena gota de sangue. Esta
                punção será feita por profissional treinado e a criança sentirá somente um pequeno desconforto, sendo que não
                há riscos à sua saúde. Com esta gota de sangue, faremos a dosagem da concentração de hemoglobina, dado que
                será utilizado para o diagnóstico de anemia.
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Caso o senhor concorde, por favor preencha o nome de seu filho e assine.
            </p>
            <br>

            <p><b><pre>Nome da criança ou adolescente: ___________________________________________________</pre></b> </p>

            <table>
                <tr>
                    <td>
                        <p><pre>[ ] - Nome do Pai:<br> ____________________________________________________________</pre></p>
                        <br>
                        <p><pre>[ ] - Nome da Mãe:<br> ____________________________________________________________</pre></p>
                    </td>

                    <td>
                        <div class="photo"></div>  
                    </td>
                </tr>

            </table>    

            <table class="table-term">
                <tr>
                    <td>Peso</td>
                    <td>Altura</td>
                    <td>Data de Coleta</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <br>

            <table class="table-term">
                <tr>
                    <td><b>HB 1</b></td>
                    <td><b>Data Coleta</b></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>

                <tr>
                    <td><b>HB 2</b></td>
                    <td><b>Data Coleta</b></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>


                <tr>
                    <td><b>HB 3</b></td>
                    <td><b>Data Coleta</b></td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>

            </table>
            <br>   

            <p><pre> [ ] - Sulfato ferroso: __________________________________________________ </pre> </p>
            <p><pre> [ ] - Vermifugo: _____________________________________________________ </pre> </p>
        </div>
    </div>
</div>