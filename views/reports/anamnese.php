    <?php

    use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\campaign;
use app\models\school;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;

$this->title = yii::t('app', 'Anamnese');
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

<div class="report">
    <br> <br> <br> 
    <div class="report-content">
        <div>  <p align="center"> QUESTIONÁRIO DE ANAMNESE<br>
        Tecnologia Social Hb</p></div>
        <br>
        <div>
            <table style='width:100%'>
                <tr>
                    <th colspan='3'>Nome:  </th>
                </tr>
                <tr>
                    <th>Nascimento:</th>
                    <th colspan="2">Idade: </th>
                    
                </tr>
                <tr>
                    <th>Sexo:</th>
                    <th>Peso:</th>
                    <th>Altura:</th>
                    
                </tr>
                <tr>
                    <th>IMC:</th>
                    <th colspan="2">Hb1:</th>
                </tr>
            </table>
        </div>
        <hr>
        <div id='impar'>
        A criança já foi internada alguma vez?
        <pre>(    ) SIM             (    ) NÃO</pre>

        Se SIM, qual foi o motivo?<br>
        <br>
        <hr>
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
        Qual?<hr>
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
        
        <pre>
___________________________________________________________________________________ 
___________________________________________________________________________________ </pre>        
    </div>
</div>