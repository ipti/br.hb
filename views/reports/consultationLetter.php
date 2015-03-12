<?php
/* @var $this yii\web\View  */
/* @var $student \app\models\student */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\icons\Icon;

use app\models\campaign;

use kartik\builder\Form;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;

$this->title = yii::t('app', "Letter of Consultation's Notice");

$this->assetBundles['Reports'] = new app\assets\AppAsset();
$this->assetBundles['Reports']->js = [
    'scripts/ReportsView/Functions.js',
    'scripts/ReportsView/Click.js'
];
?>

<div class="report">
    <div class="report-filter hidden-print">
        <?php
        echo Html::beginForm(Url::toRoute('reports/get-consultation-letter'),'POST',['id'=>'form-consultation-letter', 'class'=>'form-vertical']);
        if(isset($student) && $student != null){
            echo Form::widget([
                'formName' => 'consultation-letter-form',
                'columns'=>1,
                'attributes' => [
                    'campaign-student'=>[
                        'type'=>Form::INPUT_RAW,
                        'value' => Html::hiddenInput('consultation-letter-form[campaign-student]', $student->id)
                    ],
                    'name'=>[
                        'label'=>yii::t('app', 'Student'), 
                        'type'=>Form::INPUT_STATIC,
                        'value'=>$student->name
                    ],
                ]
            ]);
        }else{
        echo Form::widget([
            'formName' => 'consultation-letter-form',
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
                            'depends' => ['consultation-letter-form-campaign'],
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
                            'depends' => ['consultation-letter-form-campaign'],
                            'depends' => ['consultation-letter-form-campaign-school'],
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
        }
        echo Form::widget([
            'formName' => 'consultation-letter-form',
            'columns'=>3,
            'attributes' => [
                'consult-date' => [
                    'label'=>yii::t('app', 'Consult Date'), 
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => DatePicker::className(),
                    'hint' => yii::t('app', 'Enter consult date (mm/dd/yyyy)')
                ],
                'consult-time' => [
                    'label' => yii::t('app', 'Consult Time'),
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => TimePicker::className(),
                    'hint' => yii::t('app', 'Enter consult time (hh:mm)')
                ],
                'consult-location' => [
                    'label'=>yii::t('app', 'Consult Location'), 
                    'type' => Form::INPUT_TEXT,
                ],
            ]
        ]); 
        echo Form::widget([
            'formName' => 'consultation-letter-form',
            'columns'=>1,
            'attributes' => [
                'actions'=>[
                    'type'=>Form::INPUT_RAW, 
                    'value'=>'<div class="pull-right">' . 
                        Html::resetButton(Icon::show('recycle',[], Icon::FA).'Reset', ['class'=>'btn btn-default']) . ' ' .
                        Html::button(Icon::show('refresh',[], Icon::FA).'Generate', ['id'=>'submit-consultation-letter', 'type'=>'button', 'class'=>'btn btn-primary']) . 
                    '</div>'
                ],
            ]
        ]); 
        echo Html::endForm(); ?>
    </div>
    <div class="report-content">
        <div class="report-head">
            <div class="report-head-image "></div>
        </div>
        <div class="report-body">
            Prezados Pais,
            <br/>
            <br/>
            <p>Como é do conhecimento de vocês, realizamos, a partir de uma gotinha de sangue tirada do dedo do seu filho(a) ____________________________________________________________________, um exame que diagnostica a
                anemia.</p>
            <p>Ficamos preocupados, pois o resultado mostrou que a sua criança encontra-se com anemia. Vocês deverão levar seu filho(a) à consulta médica, para que ele receba o tratamento:</p>
            <b>Dia da Consulta:</b>____/____/____<br/>
            <b>Hora da Consulta:</b> ____:____<br/>
            <b>Local da Consula:</b> ____________________________________<br/>
            <p>Gostaríamos de pedir a vocês para já prestarem atenção na alimentação da sua criança, principalmente nestes pontos:<br/><br/>
                <b>1 – Devemos oferecer às crianças, sempre que possível, carnes (de boi, frango ou peixe), feijão e folhas escuras, como couve e brócolis;<br/><br/>
                    2 – Devemos oferecer às crianças, logo após as refeições, sucos de frutas, principalmente as cítricas, como laranja e limão;<br/><br/>
                    3 – Não devemos deixar as crianças tomarem refrigerantes, chá ou café junto das refeições;<br/><br/>
                    4 – Lembrem-se também que leite faz muito bem, mas não junto das refeições. É melhor deixar passar duas horas após a refeição para dar leite às crianças.<br/></b><p/>
            Com estas medidas podemos ajudar as nossas crianças a ficarem sempre saudáveis e alegres.<br/><br/>
        </div>
        <div id="report-footer">Muito obrigado pela atenção.</div>
    </div>
    <div class="pull-right hidden-print">
    <?=Html::button(Icon::show('print',[], Icon::FA).'Print', ['id'=>'print-button', 'class'=>'btn btn-primary', 'onclick'=>'window.print()'])?>
    </div>
</div>