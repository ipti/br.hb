
<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\campaign;
use app\models\school;
use kartik\widgets\DepDrop;
use kartik\select2\Select2;

 $this->assetBundles['Reports'] = new app\assets\AppAsset();
 $this->assetBundles['Reports']->js = [
    'scripts/ReportsView/Term.js'
    ];
 
 

include_once __DIR__ . '/../../web/libs/mpdf60/mpdf.php';

$this->title = yii::t('app', 'Termos');
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
            
        </div>


        <?php
        $html = '<div class="report">
            <br> <br> <br> 
            <div class="report-content">
                <div> <b> <p align="center"> 
                            <img src="/images/reporters/boquim/prefeitura.jpg" width="260" height="120">
                            <br><br>
                            Autorização para que seu filho participe de uma campanha de saúde na escola <br>
                        </p></b></div>
                <br>

                <p style="text-align: justify;
    text-justify: inter-word;">
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

                <b><pre>Nome da criança ou adolescente: ___________________________________________________</pre></b> 
                <br>
                <table>
                    <tr>
                        <td>
                            <p><pre>[ ] - Nome do Pai:<br> ____________________________________________________________</pre></p>
                            <br>
                            <p><pre>[ ] - Nome da Mãe:<br> ____________________________________________________________</pre></p>
                        </td>

                        <td style="
                            width: 124px;
                            height: 155px;
                            border: #000000 solid 3px; 
                            ">
                        </td>
                    </tr>

                </table>  
               <br>

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

                <pre> [ ] - Sulfato ferroso: __________________________________________________ </pre> 
                <pre> [ ] - Vermifugo: _____________________________________________________ </pre> 
            </div>
        </div>';

        $mpdf = new mPDF();

        $css1 = file_get_contents(__DIR__ . '/../../vendor/bower/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        $mpdf->WriteHTML($html);

//        $mpdf->Output('terms.pdf', 'I');
//        exit;
        
        ?>