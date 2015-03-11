<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;

use app\models\campaign;

use kartik\builder\Form;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;

$this->title = yii::t('app', 'Anamnese');
?>
<div class="report">
    <div class="report-filter hidden-print">
<?php
        echo Html::beginForm(Url::toRoute('reports/get-anaminese'),'POST',['id'=>'form-letter', 'class'=>'form-vertical']);
        
        echo Form::widget([
            'formName' => 'letter-form',
            'columns'=>4,
            'attributes' => [
                'campaign' => [
                    'label'=>yii::t('app', 'Campaign'), 
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => Select2::className(),
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
                    'widgetClass' => DepDrop::className(),
                    'options'=>[
                        'data' => [],
                        'options' => [
                            'placeholder' => yii::t('app', 'Select School...'),
                        ],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['letter-form-campaign'],
                            'url' => Url::to(['/campaign/get-schools-list']),
                            'loadingText' => yii::t('app', 'Loading Schools...'),
                        ]
                    ],
                ],
                'campaign-classroom' => [
                    'label'=>yii::t('app', 'Classroom'), 
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => DepDrop::className(),
                    'options'=>[
                        'data' => [],
                        'options' => [
                            'placeholder' => yii::t('app', 'Select Classroom...'),
                        ],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['letter-form-campaign'],
                            'depends' => ['letter-form-campaign-school'],
                            'url' => Url::to(['/campaign/get-classrooms-list']),
                            'loadingText' => yii::t('app', 'Loading Classrooms...'),
                        ]
                    ],
                ],
                'campaign-student' => [
                    'label'=>yii::t('app', 'Student'), 
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => DepDrop::className(),
                    'options'=>[
                        'data' => [],
                        'options' => [
                            'placeholder' => yii::t('app', 'Select Student...'),
                        ],
                        'type' => DepDrop::TYPE_SELECT2,
                        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                        'pluginOptions' => [
                            'depends' => ['letter-form-campaign'],
                            'depends' => ['letter-form-campaign-school'],
                            'depends' => ['letter-form-campaign-classroom'],
                            'url' => Url::to(['/campaign/get-students-list']),
                            'loadingText' => yii::t('app', 'Loading Students...'),
                        ]
                    ],
                ],
            ]
        ]); 
        echo Form::widget([
            'formName' => 'letter-form',
            'columns'=>1,
            'attributes' => [
                'actions'=>[
                    'type'=>Form::INPUT_RAW, 
                    'value'=>'<div class="pull-right">' . 
                        Html::resetButton(Icon::show('recycle',[], Icon::FA).'Reset', ['class'=>'btn btn-default']) . ' ' .
                        Html::button(Icon::show('refresh',[], Icon::FA).'Generate', ['id'=>'submit-letter', 'type'=>'button', 'class'=>'btn btn-primary']) . 
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
            QUESTIONÁRIO DE ANAMNESE<br>
            Tecnologia Social Hb
            <hr >
            <table class="table-bordered">
                <tr>
                    <th>Nome:</th><td colspan="5"></td>
                </tr>
                <tr>
                    <th>Nascimento:</th><td></td>
                    <th>Idade:</th><td colspan="3"></td>

                </tr>
                <tr>
                    <th>Sexo:</th><td></td>
                    <th>Peso:</th><td></td>
                    <th>Altura:</th><td></td>

                </tr>
                <tr>
                    <th>IMC:</th><td></td>
                    <th>Hb1:</th><td colspan="3"></td>
                </tr>
            </table>
            <hr>
        </div>
        <div class="report-body">
            <div id='impar'>
                A criança já foi internada alguma vez?
                <pre>(    ) SIM             (    ) NÃO</pre>
                Se SIM, qual foi o motivo?
                <hr class="answer-line-full">
            </div>
            <div id='par'>
                Já teve Pneumonia?
                <pre>(    ) SIM             (    ) NÃO</pre>
                Quantas vezes?
                <pre>(    ) 1               (    ) 2              (    ) 3              (    ) 4 ou mais</pre>
            </div>
            <div id='impar'>
                Tem alergia a algum medicamento?
                <pre>(    ) SIM             (    ) NÃO</pre>
                Qual?
                <hr class="answer-line-full">
            </div>
            <div id='par'>
                Inchava os pés ou as mãos quando era um bebê?
                <pre>(    ) SIM             (    ) NÃO</pre>
            </div>
            <div id='impar'>
                Já fez exame de sangue?
                <pre>(    ) SIM             (    ) NÃO</pre>
            </div>
            <div id='par'>
                Já teve anemia anteriormente?
                <pre>(    ) SIM             (    ) NÃO</pre>
                Quantas vezes?
                <pre>(    ) 1               (    ) 2            (    ) 3                (    ) 4 ou mais</pre>
                Como foi tratada?
                <pre>(    ) Sulfato Ferroso (    ) Dieta        (    ) Outros: _________________________</pre>
                Melhorou com o tratamento:
                <pre>(    ) SIM             (    ) NÃO          (    ) Não completou o tratamento</pre>
            </div>
            <div id='impar'>
                Existem outras pessoas na família que têm ou já tiveram anemia?
                <pre>(    ) SIM             (    ) NÃO</pre>

                Se SIM, quem?   
                <pre>(    ) Irmão(a)        (    ) Pai ou Mãe   (    ) Outros: _________________________</pre>
            </div>

            OBS:
            <hr class="answer-line">
            <hr class="answer-line">
        </div>
        
        
</div>
    <div class="pull-right hidden-print">
    <?=Html::button(Icon::show('print',[], Icon::FA).'Print', ['class'=>'btn btn-primary', 'onclick'=>'window.print()'])?>
    </div>