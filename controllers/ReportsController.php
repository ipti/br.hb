<?php

namespace app\controllers;

use app\models\campaign;
use app\models\term;
use app\models\enrollment;
use app\models\classroom;
use app\models\school;
use app\models\student;
use mPDF;

class ReportsController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionConsultationLetter($sid = null) {
        $options = $sid == null ? [] : ['student' => \app\models\student::find()->where('id = :sid', ['sid' => $sid])->one()];

        return $this->render('consultationLetter', $options);
    }

    public function actionPrescription() {
        return $this->render('prescription');
    }

    public function actionTerms() {
        return $this->render('terms');
    }

    public function actionAnamnese($eid = null) {
        $options = $eid == null ? [] : ['enrollment' => \app\models\enrollment::find()->where('id = :eid', ['eid' => $eid])->one()];

        return $this->render('anamnese',$options);
    }

    public function actionGetAnamnese() {
        /* @var $enrollment \app\models\enrollment */
        /* @var $student \app\models\student */
        /* @var $term \app\models\term */
        /* @var $hb1 \app\models\hemoglobin */
        /* @var $anatomy \app\models\anatomy */

        $anamnese   = isset($_POST['anamnese-form']) ? $_POST['anamnese-form'] : null;
        $eid        = isset($anamnese['campaign-enrollment']) && !empty($anamnese['campaign-enrollment']) ? $anamnese['campaign-enrollment'] : null;
        $enrollment = $eid          != null ? \app\models\enrollment::find()->where("id = :eid", [ 'eid' => $eid])->one() : null;
        $student    = $enrollment   != null ? $enrollment->students : null;
        $term       = $eid          != null ? \app\models\term::find()->where("enrollment = :eid", ['eid' => $eid])->one() : null;
        $hb1        = $term         != null ? $term->getHemoglobins()->where("sample = 1")->one() : null;
        $anatomy    = $student      != null ? $student->getAnatomies()->orderBy("date desc")->one() : null;

        $name       = $student != null ? $student->name : "";
        $birthday   = $student != null ? date("d/m/Y", strtotime($student->birthday)) : "";
        $b          = $student != null ? $student->birthday : "";
        $today      = $student != null ? new \DateTime(date("Y-m-d")) : "";
        $age        = $student != null ? $today->diff(new \DateTime($b))->format("%y") : "";
        $sex        = $student != null ? \yii::t('app', $student->gender) : "";
        $weight     = $anatomy != null ? $anatomy->weight . "kg" : "";
        $height     = $anatomy != null ? $anatomy->height . "m" : "";
        $imc        = $anatomy != null ? number_format($weight / ($height * $height), 2) : "";
        $rate1      = $hb1     != null ? $hb1->rate : "";

        echo "<tr>";
        echo "<th>Nome:</th><td colspan='5'>";
        echo $name;
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Nascimento:</th><td>";
        echo $birthday;
        echo "</td>";
        echo "<th>Idade:</th><td colspan='3'>";
        echo $age;
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>Sexo:</th><td>";
        echo $sex;
        echo "</td>";
        echo "<th>Peso:</th><td>";
        echo $weight;
        echo "</td>";
        echo "<th>Altura:</th><td>";
        echo $height;
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<th>IMC:</th><td>";
        echo $imc;
        echo "</td>";
        echo "<th>Hb1:</th><td colspan='3'>";
        echo $rate1;
        echo "</td>";
        echo "</tr>";
    }

    public function actionAgreedTerms($cid,$sid){
        /* @var $campaign campaign*/
        /* @var $school school*/
        $html = "";
        $school = school::find()->where("id = :sid",['sid'=>$sid])->one();
        $terms = $school->getTerms()
                ->where("term.campaign = :cid and term.agreed = true",['cid'=>$cid])
                ->all();
        
        $tAgreed = [];
        foreach ($terms as $term):
            /* @var $term       \app\models\term */
            /* @var $enrollment \app\models\enrollment */
            /* @var $classroom  \app\models\classroom */
            /* @var $student    \app\models\student */
            $enrollment     = $term->getEnrollments()->one();
            $classroom      = $enrollment->getClassrooms()->orderBy('name')->one();
            $student        = $enrollment->getStudents()->orderBy('name')->one();
            $hemoglobin1    = $enrollment->getHemoglobins()->where('sample = 1')->one();
            $hemoglobin2    = $enrollment->getHemoglobins()->where('sample = 2')->one();          
            $hemoglobin3    = $enrollment->getHemoglobins()->where('sample = 3')->one();  
            
            if (isset($tAgreed[$classroom->name])) {
                $tAgreed[$classroom->name] = array_merge($tAgreed[$classroom->name], 
                    [['name'=> $student->name, 
                        'birthday' => $student->birthday,
                        'hb1' => $hemoglobin1 != null ? $hemoglobin1->rate : "",
                        'hb2' => $hemoglobin2 != null ? $hemoglobin2->rate : "",
                        'hb3' => $hemoglobin3 != null ? $hemoglobin3->rate : ""
                        ]
                        ]);
            } else{
                $tAgreed[$classroom->name] = 
                    [['name'=> $student->name, 
                        'birthday' => $student->birthday,
                        'hb1' => $hemoglobin1 != null ? $hemoglobin1->rate : "",
                        'hb2' => $hemoglobin2 != null ? $hemoglobin2->rate : "",
                        'hb3' => $hemoglobin3 != null ? $hemoglobin3->rate : ""
                        ]];
            }
        endforeach;
        foreach ($tAgreed as $cName => $students){
            $header = "<div class='agreed-terms-list'>"
                    . "<table>"
                    . "<tr>"
                    . "<th colspan='5' class='list-header'>Escola: $school->name</th>"
                    . "</tr>"
                    . "<tr>"
                    . "<th colspan='5' class='list-header'>Turma: $cName</th>"
                    . "</tr>"
                    . "<tr><td colspan='5' style='border:0'></td></tr>"
                    . "<tr>"
                        . "<th class='student'>Aluno</th>"
                        . "<th class='birthday'>Nascimento</th>"
                        . "<th class='rate'>Taxa 1</th>"
                        . "<th class='rate'>Taxa 2</th>"
                        . "<th class='rate'>Taxa 3</th>"
                    . "</tr>";
            $body = "";
            
         
            foreach ($students as $s ){
                $sName = $s['name'];
                $sBirthday = $s['birthday'];
                $sHb1 = $s['hb1'];
                $sHb2 = $s['hb2'];
                $sHb3 = $s['hb3'];
                $body .= "<tr>"
                        . "<td class='student'>$sName</td>"
                        . "<td class='birthday'>".date("d/m/Y",strtotime($sBirthday))."</td>"
                        . "<td class='rate'>".$sHb1."</td>"
                        . "<td class='rate'>".$sHb2."</td>"
                        . "<td class='rate'>".$sHb3."</td>"
                        . "</tr>";
            }
            $footer = "</table>"
                    . "</div>";
                    
            if (end($tAgreed) !== $students){
                $footer .= "<pagebreak type='NEXT-ODD' resetpagenum='1' pagenumstyle='i' suppress='off' />";
            }
            
            $html .= $header.$body.$footer;
        }


        $mpdf = new mPDF();

        $css1 = file_get_contents(__DIR__ . '/../vendor/bower/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        $mpdf->WriteHTML($html);

        $mpdf->Output('agreedTerms.pdf', 'I');
        exit;
        
    }
    
    
    /**
     * Build Terms
     * 
     * @return Json
     */
    public function actionBuildTerms($cid) {
        $campaignID = $cid;
        $html = "";
        
        if (isset($campaignID)) {
            $schools = array();
            /* @var $campaign \app\models\campaign */
            $campaign   = campaign::find()->where('id = :sid', ['sid' => $campaignID])->one();
            $terms      = $campaign->getTerms()->all();

            foreach ($terms as $term):
                /* @var $term       \app\models\term */
                /* @var $enrollment \app\models\enrollment */
                /* @var $classroom  \app\models\classroom */
                /* @var $student    \app\models\student */
                $enrollment     = $term->getEnrollments()->one();
                $classroom      = $enrollment->getClassrooms()->orderBy('name')->one();
                $school         = $classroom->getSchools()->orderBy('name')->one();
                $student        = $enrollment->getStudents()->orderBy('name')->one();

                $schools[$school->id]['name'] = $school->name;
                $schools[$school->id]['classrooms'][$classroom->id]['name'] = $classroom->name;
                $schools[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['name'] = $student->name;
                $schools[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['nameMother'] = $student->mother;
                $schools[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['nameFather'] = $student->father;
            endforeach;
        
        
            foreach ($schools as $i => $school):
                $sName = $school['name'];
                $classrooms = $school['classrooms'];
                //School
                $html .= "&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> "
                        . "<p class='page-white'> Escola: ".$sName."</p> "
                        . "<pagebreak type='NEXT-ODD' resetpagenum='1' pagenumstyle='i' suppress='off' />";
                        
                foreach ($classrooms as $j => $classroom):
                    $cName = $classroom['name'];
                    $students = $classroom['students'];
                  //Turma
                 $html .= "&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> "
                         . "<p class='page-white'> Turma: ".$cName."</p> "
                         . "<pagebreak type='NEXT-ODD' resetpagenum='1' pagenumstyle='i' suppress='off' />";
                
                    foreach ($students as $k => $student):
                        $sName = $student['name'];
                        $sMother = $student['nameMother'];
                        $sFather = $student['nameMother'];


                        //========================================================  

                        $html .= '
                        <div class="report">
                            <div class="report-content">
                                <div class="report-head">  
                                    <p align="center"> 
                                        <img src="/images/reporters/prefeitura.png" width="260" height="120">
                                        <br>
                                        <br> 
                                        <b>Autorização para que seu filho participe de uma campanha de saúde na escola</b>  
                                        <br>
                                        </p>
                                    </div>
                            <br>
                            <div class="report-body">
                                <p style="text-align: justify; text-justify: inter-word;"> Prezado(a) Senhor(a) <br><br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Caso o senhor(a) concorde, o seu filho(a) será submetido(a) a uma punção da extremidade do dedo médio da
                                    mão esquerda, com lancetador de lancetas descartáveis, para a obtenção de uma pequena gota de sangue. Esta
                                    punção será feita por profissional treinado e a criança sentirá somente um pequeno desconforto, sendo que não
                                    há riscos à sua saúde. Com esta gota de sangue, faremos a dosagem da concentração de hemoglobina, dado que
                                    será utilizada para o diagnóstico de anemia.
                                    <br>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    Caso o senhor(a) concorde, por favor assine este termo.
                                </p>
                                <br>

                                <pre><b>Nome da criança ou adolescente: ' . $sName . ' </b> </pre>
                                <br>
                                <table>
                                    <tr>
                                        <td>[ ] - Nome da Mãe: '. $sMother .'</td>
                                        <td rowspan="4" class="dedinho-term-report">
                                            <img src="/images/reporters/dedinho.png">
                                        </td>
                                    </tr>
                                    <tr><td class="answer-line"></td></tr>
                                    <tr><td><br>[ ] - Nome do Pai: '. $sFather .'</td></tr>
                                    <tr><td class="answer-line"></td></tr>
                                </table>  
                                <br>
                                <br>
                                <table class="table-term">
                                    <tr><td>Peso</td><td>Altura</td><td>Data de Coleta</td></tr>
                                    <tr><td>&nbsp;</td><td></td><td></td></tr>
                                </table>
                                <br>
                                <table class="table-term">
                                    <tr><td><b>HB 1</b></td><td><b>Data de Coleta</b></td></tr>
                                    <tr><td>&nbsp;</td><td></td></tr>
                                    <tr><td><b>HB 2</b></td><td><b>Data de Coleta</b></td></tr>
                                    <tr><td>&nbsp;</td><td></td></tr>
                                    <tr><td><b>HB 3</b></td><td><b>Data de Coleta</b></td></tr>
                                    <tr><td>&nbsp;</td><td></td></tr>
                                </table>
                                <br>   
                                <pre> [ ] - Sulfato ferroso: __________________________________________________ </pre> 
                                <pre> [ ] - Vermifugo: _____________________________________________________ </pre> </div>
                            </div>
                        </div>'
                        ."<pagebreak type='NEXT-ODD' resetpagenum='1' pagenumstyle='i' suppress='off' />";
                    endforeach;
                endforeach;
            endforeach;
            
            $mpdf = new mPDF();

            $css1 = file_get_contents(__DIR__ . '/../vendor/bower/bootstrap/dist/css/bootstrap.css');
            $mpdf->WriteHTML($css1, 1);

            $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
            $mpdf->WriteHTML($css2, 1);

            $mpdf->WriteHTML($html);

            $mpdf->Output('terms.pdf', 'I');
            exit;
        }
    }
        
    public function actionGetConsultationLetter($student = null) {
        $letter     = isset($_POST['consultation-letter-form']) ? $_POST['consultation-letter-form'] : null;
        $sid        = isset($letter['campaign-student'])    && !empty($letter['campaign-student'])  ? $letter['campaign-student']   : null;
        $date       = isset($letter['consult-date'])        && !empty($letter['consult-date'])      ? $letter['consult-date']       : "____/____/____";
        $time       = isset($letter['consult-time'])        && !empty($letter['consult-time'])      ? $letter['consult-time']       : "____:____";
        $place      = isset($letter['consult-location'])    && !empty($letter['consult-location'])  ? $letter['consult-location']   : "____________________________________";

        $student = ($letter != null && $sid != null) ? \app\models\student::find()->where("id = :sid", ['sid' => $letter["campaign-student"]])->one() : null;
        /* @var $student \app\models\student */
        $name   = $student != null ? $student->name : "____________________________________________________________________";
        $sex    = $student == null ? true           : ($student->gender == "male" ? true : false); /* male or female */

        echo "Prezados Pais,";
        echo "<br/>";
        echo "<br/>";
        echo "<p>Como é do conhecimento de vocês, realizamos, a partir de uma gotinha de sangue tirada do dedo ";
        echo $sex ? "do seu filho" : "da sua filha";
        echo " <b><u>";
        echo $name;
        echo"</u></b>, um exame que diagnostica a anemia.</p>";
        echo "<p>Ficamos preocupados, pois o resultado mostrou que ";
        echo $sex ? "ele" : "ela";
        echo " encontra-se com anemia. Vocês deverão levar ";
        echo $sex ? "seu filho" : "sua filha";
        echo" à consulta médica, para que ele receba o tratamento:</p>";
        echo "<b>Dia da Consulta:</b>";
        echo " <b><u>";
        echo $date;
        echo"</u></b><br/>";
        echo "<b>Hora da Consulta:</b>";
        echo " <b><u>";
        echo $time;
        echo"</u></b><br/>";
        echo "<b>Local da Consulta:</b>";
        echo " <b><u>";
        echo $place;
        echo"</u></b><br/>";
        echo "<p>Gostaríamos de pedir a vocês para já prestarem atenção na alimentação da ";
        echo $sex ? "seu filho" : "sua filha";
        echo", principalmente nestes pontos:<br/><br/>";
        echo "   <b>1 – Devemos oferecer às crianças, sempre que possível, carnes (de boi, frango ou peixe), feijão e folhas escuras, como couve e brócolis;<br/><br/>";
        echo "      2 – Devemos oferecer às crianças, logo após as refeições, sucos de frutas, principalmente as cítricas, como laranja e limão;<br/><br/>";
        echo "      3 – Não devemos deixar as crianças tomarem refrigerantes, chá ou café junto das refeições;<br/><br/>";
        echo "      4 – Lembrem-se também que leite faz muito bem, mas não junto das refeições. É melhor deixar passar duas horas após a refeição para dar leite às crianças.<br/></b><p/>";
        echo "Com estas medidas podemos ajudar as nossas crianças a ficarem sempre saudáveis e alegres.<br/><br/>";
    }

}
