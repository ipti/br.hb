<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\campaign;
use app\models\school;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;


$this->title = yii::t('app', 'Letter');
?>


<div class="report">
    <div class="report-head hidden-print">
        <div class="row">
            <div class="campaign-col col-sm-6 col-md-3">
                <?php
                $data = ArrayHelper::map(campaign::find()->all(), 'id', 'name');
                echo Html::label(yii::t('app', 'Campaign'));
                echo Select2::widget([
                    'name' => 'campaign',
                    'id' => 'campaign',
                    'data' => $data,
                    'options' => [
                        'placeholder' => yii::t('app', 'Select Campaign...'),
                    ],
                    'pluginOptions' => ['allowClear' => true]
                ]);
                ?>
            </div>
            <div class="campaign-col col-sm-6 col-md-3">
                <?php
                echo Html::label(yii::t('app', 'School'));
                echo DepDrop::widget([
                    'name' => 'school',
                    'id' => 'campaign_school',
                    'data' => [],
                    'options' => [
                        'placeholder' => yii::t('app', 'Select School...'),
                    ],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['campaign'],
                        'url' => Url::to(['/campaign/get-schools-list']),
                        'loadingText' => yii::t('app', 'Loading Schools...'),
                    ]
                ]);
                ?>
            </div>
            <div class="campaign-col col-sm-6 col-md-3">
                <?php
                echo Html::label(yii::t('app', 'Classroom'));
                echo DepDrop::widget([
                    'name' => 'classroom',
                    'id' => 'campaign_classroom',
                    'data' => [],
                    'options' => [
                        'placeholder' => yii::t('app', 'Select Classroom...'),
                    ],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['campaign'],
                        'depends' => ['campaign_school'],
                        'url' => Url::to(['/campaign/get-classrooms-list']),
                        'loadingText' => yii::t('app', 'Loading Classrooms...'),
                    ]
                ]);
                ?>
            </div>
            <div class="campaign-col col-sm-6 col-md-3">
                <?php
                echo Html::label(yii::t('app', 'Student'));
                echo DepDrop::widget([
                    'name' => 'student',
                    'id' => 'campaign_Student',
                    'data' => [],
                    'options' => [
                        'placeholder' => yii::t('app', 'Select Student...'),
                    ],
                    'type' => DepDrop::TYPE_SELECT2,
                    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
                    'pluginOptions' => [
                        'depends' => ['campaign'],
                        'depends' => ['campaign_school'],
                        'depends' => ['campaign_classroom'],
                        'url' => Url::to(['/campaign/get-students-list']),
                        'loadingText' => yii::t('app', 'Loading Student...'),
                    ]
                ]);
                ?>
            </div>
        </div>

        <div class="report-content">
            <div clas="report-body">
                Prezados Pais,
                <br/>
                <br/>
                <p>Como é do conhecimento de vocês, realizamos, a partir de uma gotinha de sangue tirada do dedo do seu filho(a) <span id="student-name"></span>, um exame que diagnostica a
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
    </div>
</div>