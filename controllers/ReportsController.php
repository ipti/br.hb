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
    
    public function actionMultiplePrescriptions($cid) {
        /* @var $campaign \app\models\campaign */
        /* @var $hemoglobin \app\models\hemoglobin */
        /* @var $term \app\models\term */
        /* @var $enrollment \app\models\enrollment */

        $campaign = campaign::find()->where("id = :cid", ["cid" => $cid])->one();
        $hemoglobins = $campaign->getHemoglobins()
                ->where("sample = 1")
                ->innerJoin("term", "term.id = agreed_term")
                ->innerJoin("enrollment e", "term.enrollment = e.id")
                ->innerJoin("student s", "e.student = s.id")
                ->orderBy("s.name ASC")
                ->all();
        
        $mpdf = new mPDF();

        $css1 = file_get_contents(__DIR__ . '/../vendor/bower/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        $i = 1;
        foreach($hemoglobins as $hemoglobin){
            if($hemoglobin->isAnemic()){
                $term = $hemoglobin->getAgreedTerm()->one();
                $enrollment = $term->getEnrollments()->one();
                $prescription = $this->actionPrescription($enrollment->id, false);
                $name = $prescription['name'];
                $sulfato = $prescription['sulfato'];
                $vermifugo = $prescription['vermifugo'];
                $mpdf->WriteHTML('<div class="report">
                                    <div class="report-content">
                                        <div class="report-head">
                                            <div class="report-head-image">
                                                <img src="/images/reporters/prefeitura.png" class="pull-left" width="200">
                                                <img src="/images/reporters/hb.png" class="pull-right" height="50px;">
                                                <div class="clear"></div>
                                            </div>
                                            <h4 class="report-title">Receituário</h4>
                                            <h5 >'.$name.'</h5>
                                            <br>
                                        </div>
                                        <div class="report-body" style="text-align: center">
                                            <span>
                                                '.$sulfato.'
                                                <br>
                                                '.$vermifugo.'                
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="dashed">'.$i.' </div>');
                if($i % 3 == 0 )
                    $mpdf->WriteHTML ("<pagebreak />");
                $i++;
            }
        }
        $mpdf->Output('MultiplePrescriptions.pdf', 'I');
    }

    public function actionPrescription($eid,$render=True) {
        /* @var $enrollment \app\models\enrollment */
        /* @var $student \app\models\student */
        /* @var $anatomy \app\models\anatomy */

        $enrollment = enrollment::find()->where("id = :eid", ["eid" => $eid])->one();
        $student = $enrollment->getStudents()->one();
        $name = $student->name;

        $anatomy = $student->getAnatomies()->orderBy("date desc")->one();
        if ($anatomy == null) {
            $sulfato = "<br>";
            $vermifugo = "<br>";
        } else {
            $peso = $anatomy->weight;

            $concentracaoPorML = 25;
            $gotasPorML = 20;
            $concentracaoPorGota = $concentracaoPorML / $gotasPorML;

            $posologia = ceil($peso / $concentracaoPorGota);


//            $gotasPor3 = $concentracaoPorGota/3;
//            $gotasPorPeso = ceil($gotasPor3 * $peso);

            if ($peso > 30) {
                $sulfato = "<b>Sulfato Ferroso</b> em comprimido, <b>1 Comprimido a cada 12h</b>.";
            } else {
                $sulfato = "<b>Sulfato Ferroso</b> em gotas, <b>$posologia gotas</b>, três vezes ao dia.";
            }
            $vermifugo = "<b>Albendazol</b> em comprimido, <b>1 Comprimido a cada 12h</b> (pode dissolver em água ou suco).";
        }
        $options = [
                        "name" => $name,
                        "sulfato" => $sulfato,
                        "vermifugo" => $vermifugo
            ];
        if($render){
            return $this->render('prescription', $options);
        }else{
            return $options;
        }
    }

    public function actionTerms() {
        return $this->render('terms');
    }
    
    public function actionLetterAndAnamnese($cid){
        $campaign = campaign::find()->where("id = :cid", ["cid" => $cid])->one();
        $hemoglobins = $campaign->getHemoglobins()
                ->where("sample = 1")
                ->innerJoin("term", "term.id = agreed_term")
                ->innerJoin("enrollment e", "term.enrollment = e.id")
                ->innerJoin("student s", "e.student = s.id")
                ->orderBy("s.name ASC")
                ->all();
        
        $letter = isset($_POST['consultation-letter-form']) ? $_POST['consultation-letter-form'] : null;
        $date = isset($letter['consult-date']) && !empty($letter['consult-date']) ? $letter['consult-date'] : "____/____/____";
        $time = isset($letter['consult-time']) && !empty($letter['consult-time']) ? $letter['consult-time'] : "____:____";
        $place = isset($letter['consult-location']) && !empty($letter['consult-location']) ? $letter['consult-location'] : "____________________________________";

        $mpdf = new mPDF();

        $css1 = file_get_contents(__DIR__ . '/../vendor/bower/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        $i = 1;
        foreach($hemoglobins as $hemoglobin){
            if($hemoglobin->isAnemic()){
                $term = $hemoglobin->getAgreedTerm()->one();
                $enrollment = $term->getEnrollments()->one();
                $student = $enrollment->getStudents()->one();
                
                $eid = $enrollment->id;
                $name = $student != null ? $student->name : "____________________________________________________________________";
                $gender = $student->gender;
                
                $mpdf->WriteHTML ('<div class="none">'.$i.' </div>');
                $mpdf->WriteHTML('<div class="report-head">
                        <div class="report-head-image">
                            <img src="/images/reporters/prefeitura.png" class="pull-left" width="200">
                            <img src="/images/reporters/hb.png" class="pull-right" height="50px;">
                            <div class="clear"></div>
                        </div>
                        <h4 class="report-title">QUESTIONÁRIO DE ANAMNESE<br>
                        Tecnologia Social Hb</h4>
                        <table id="anamnese-header" class="table-bordered">
                            '.$this->actionGetAnamneseRaw($cid, $eid).'
                        </table>
                        <br>
                    </div>
                    <div class="report-body">
                        <div id="impar">
                            A criança já foi internada alguma vez?
                            <pre>(    ) SIM             (    ) NÃO</pre>
                            Se SIM, qual foi o motivo?
                            <hr class="answer-line-full">
                        </div>
                        <div id="par">
                            Já teve Pneumonia?
                            <pre>(    ) SIM             (    ) NÃO</pre>
                            Quantas vezes?
                            <pre>(    ) 1               (    ) 2              (    ) 3            (    ) 4 ou mais</pre>
                        </div>
                        <div id="impar">
                            Tem alergia a algum medicamento?
                            <pre>(    ) SIM             (    ) NÃO</pre>
                            Qual?
                            <hr class="answer-line-full">
                        </div>
                        <div id="par">
                            Inchava os pés ou as mãos quando era um bebê?
                            <pre>(    ) SIM             (    ) NÃO</pre>
                        </div>
                        <div id="impar">
                            Já fez exame de sangue?
                            <pre>(    ) SIM             (    ) NÃO</pre>
                        </div>
                        <div id="par">
                            Já teve anemia anteriormente?
                            <pre>(    ) SIM             (    ) NÃO</pre>
                            Quantas vezes?
                            <pre>(    ) 1               (    ) 2            (    ) 3              (    ) 4 ou mais</pre>
                            Como foi tratada?
                            <pre>(    ) Sulfato Ferroso (    ) Dieta        (    ) Outros: _______________________</pre>
                            Melhorou com o tratamento:
                            <pre>(    ) SIM             (    ) NÃO          (    ) Não completou o tratamento</pre>
                        </div>
                        <div id="impar">
                            Existem outras pessoas na família que têm ou já tiveram anemia?
                            <pre>(    ) SIM             (    ) NÃO</pre>

                            Se SIM, quem?   
                            <pre>(    ) Irmão(a)        (    ) Pai ou Mãe   (    ) Outros: _______________________</pre>
                        </div>

                        OBS:
                        <hr class="answer-line">
                        <hr class="answer-line">');
                $mpdf->WriteHTML ("<pagebreak />");
                $mpdf->WriteHTML ('<div class="none">'.$i.' </div>'.$this->actionGetConsultationLetterRaw($name, $gender, $date, $time, $place));
                $mpdf->WriteHTML ("<pagebreak />");
                $i++;
            }
        }
        $mpdf->Output('LetterAndAnamnese.pdf', 'I');
    }

    public function actionAnamnese($cid, $eid = null) {
        $options = $eid == null ? ['campaign' => $cid] : ['enrollment' => \app\models\enrollment::find()->where('id = :eid', ['eid' => $eid])->one(), 'campaign' => $cid];

        return $this->render('anamnese', $options);
    }

    public function actionGetAnamnese() {
        $anamnese = isset($_POST['anamnese-form']) ? $_POST['anamnese-form'] : null;
        $cid = isset($anamnese['campaign']) && !empty($anamnese['campaign']) ? $anamnese['campaign'] : null;
        $eid = isset($anamnese['campaign-enrollment']) && !empty($anamnese['campaign-enrollment']) ? $anamnese['campaign-enrollment'] : null;
        
        echo $this->actionGetAnamneseRaw($cid, $eid);
    }
    
    public function actionGetAnamneseRaw($cid=null, $eid=null){
        /* @var $enrollment \app\models\enrollment */
        /* @var $student \app\models\student */
        /* @var $term \app\models\term */
        /* @var $hb1 \app\models\hemoglobin */
        /* @var $anatomy \app\models\anatomy */
        $enrollment = $eid != null ? \app\models\enrollment::find()->where("id = :eid", [ 'eid' => $eid])->one() : null;
        $student = $enrollment != null ? $enrollment->students : null;
        $term = $eid != null ? \app\models\term::find()->where("enrollment = :eid and campaign = :cid", ['eid' => $eid, 'cid' => $cid])->one() : null;
        $hb1 = $term != null ? $term->getHemoglobins()->where("sample = 1")->one() : null;
        $anatomy = $student != null ? $student->getAnatomies()->orderBy("date desc")->one() : null;
        
        $name = $student != null ? $student->name : "";
        $birthday = $student != null ? date("d/m/Y", strtotime($student->birthday)) : "";
        $b = $student != null ? $student->birthday : "";
        $today = $student != null ? new \DateTime(date("Y-m-d")) : "";
        $age = $student != null ? $today->diff(new \DateTime($b))->format("%y") . " " . \yii::t('app', 'years old') : "";
        $sex = $student != null ? \yii::t('app', $student->gender) : "";
        $weight = $anatomy != null ? $anatomy->weight . "kg" : "";
        $height = $anatomy != null ? $anatomy->height . "m" : "";
        $imc = $anatomy != null ? number_format($weight / ($height * $height), 2) : "";
        $rate1 = $hb1 != null ? $hb1->rate . "g/dL" : "";

        $html = "";
        $html = "<tr>"
                .   "<th>Nome:</th>"
                .   "<td colspan='5'>"
                .       $name
                .   "</td>"
                . "</tr>"
                . "<tr>"
                .   "<th>Nascimento:</th>"
                .   "<td>"
                .       $birthday
                .   "</td>"
                .   "<th>Idade:</th>"
                .   "<td colspan='3'>"
                .       $age
                .   "</td>"
                . "</tr>"
                . "<tr>"
                .   "<th>Sexo:</th>"
                .       "<td>"
                .       $sex
                .   "</td>"
                . "<th>Peso:</th>"
                .   "<td>"
                .       $weight
                .   "</td>"
                .   "<th>Altura:</th>"
                .   "<td>"
                .       $height
                .   "</td>"
                . "</tr>"
                . "<tr>"
                .   "<th>IMC:</th>"
                .   "<td>"
                .       $imc
                .   "</td>"
                .   "<th>Hb1:</th>"
                .   "<td colspan='3'>"
                .       $rate1
                .   "</td>"
                . "</tr>";
        return $html;
    }
    
    public function actionAgreedTerms($cid, $sid) {
        /* @var $campaign campaign */
        /* @var $school school */
        $html = "";
        $school = school::find()->where("id = :sid", ['sid' => $sid])->one();
        $terms = $school->getTerms()
                ->where("term.campaign = :cid and term.agreed = true", ['cid' => $cid])
                ->innerJoin("enrollment e", "term.enrollment = e.id")
                ->innerJoin("student s", "e.student = s.id")
                ->orderBy("s.name ASC")
                ->all();

        $tAgreed = [];
        foreach ($terms as $term):
            /* @var $term       \app\models\term */
            /* @var $enrollment \app\models\enrollment */
            /* @var $classroom  \app\models\classroom */
            /* @var $student    \app\models\student */
            $enrollment = $term->getEnrollments()->one();
            $classroom = $enrollment->getClassrooms()->orderBy('name')->one();
            $student = $enrollment->getStudents()->orderBy('name')->one();
            $hemoglobin1 = $enrollment->getHemoglobins()->where('sample = 1')->one();
            $hemoglobin2 = $enrollment->getHemoglobins()->where('sample = 2')->one();
            $hemoglobin3 = $enrollment->getHemoglobins()->where('sample = 3')->one();

            if (isset($tAgreed[$classroom->name])) {
                $tAgreed[$classroom->name] = array_merge($tAgreed[$classroom->name], [['name' => $student->name,
                'birthday' => $student->birthday,
                'hb1' => $hemoglobin1 != null ? $hemoglobin1->rate : "",
                'hb2' => $hemoglobin2 != null ? $hemoglobin2->rate : "",
                'hb3' => $hemoglobin3 != null ? $hemoglobin3->rate : ""
                    ]
                ]);
            } else {
                $tAgreed[$classroom->name] = [['name' => $student->name,
                        'birthday' => $student->birthday,
                        'hb1' => $hemoglobin1 != null ? $hemoglobin1->rate : "",
                        'hb2' => $hemoglobin2 != null ? $hemoglobin2->rate : "",
                        'hb3' => $hemoglobin3 != null ? $hemoglobin3->rate : ""
                ]];
            }
        endforeach;
        foreach ($tAgreed as $cName => $students) {
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


            foreach ($students as $s) {
                $sName = $s['name'];
                $sBirthday = $s['birthday'];
                $sHb1 = $s['hb1'];
                $sHb2 = $s['hb2'];
                $sHb3 = $s['hb3'];
                $body .= "<tr>"
                        . "<td class='student'>$sName</td>"
                        . "<td class='birthday'>" . date("d/m/Y", strtotime($sBirthday)) . "</td>"
                        . "<td class='rate'>" . ($sHb1 == null ? '' : $sHb1 . 'g/dL') . "</td>"
                        . "<td class='rate'>" . ($sHb2 == null ? '' : $sHb2 . 'g/dL') . "</td>"
                        . "<td class='rate'>" . ($sHb3 == null ? '' : $sHb3 . 'g/dL') . "</td>"
                        . "</tr>";
            }
            $footer = "</table>"
                    . "</div>";

            if (end($tAgreed) !== $students) {
                $footer .= "<pagebreak type='NEXT-ODD' resetpagenum='1' pagenumstyle='i' suppress='off' />";
            }

            $html .= $header . $body . $footer;
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
        $mpdf = new mPDF();
        $css1 = file_get_contents(__DIR__ . '/../vendor/bower/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        //$mpdf->setHeader('{PAGENO}');

        if (isset($campaignID)) {
            $schools = array();
            /* @var $campaign \app\models\campaign */
            $campaign = campaign::find()->where('id = :sid', ['sid' => $campaignID])->one();
            $terms = $campaign->getTerms()->all();

            foreach ($terms as $term):
                /* @var $term       \app\models\term */
                /* @var $enrollment \app\models\enrollment */
                /* @var $classroom  \app\models\classroom */
                /* @var $student    \app\models\student */
                $enrollment = $term->getEnrollments()->one();
                $classroom = $enrollment->getClassrooms()->orderBy('name')->one();
                $school = $classroom->getSchools()->orderBy('name')->one();
                $student = $enrollment->getStudents()->orderBy('name')->one();

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
                $mpdf->WriteHTML("&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> ");
                $mpdf->WriteHTML("<p class='page-white'> Escola: " . $sName . "</p> ");
                $mpdf->WriteHTML("<pagebreak suppress='off' />");
                
                foreach ($classrooms as $j => $classroom):
                    $cName = $classroom['name'];
                    $students = $classroom['students'];
                    //Turma
                    $mpdf->WriteHTML("&nbsp;<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br> ");
                    $mpdf->WriteHTML("<p class='page-white'> Turma: " . $cName . "</p> ");
                    $mpdf->WriteHTML("<pagebreak suppress='off' />");

                    foreach ($students as $k => $student):
                        $sName = $student['name'];
                        $sMother = $student['nameMother'];
                        $sFather = $student['nameFather'];


                        //========================================================  

                        $html = '
                        <div class="report">
                            <div class="report-content">
                                <div class="report-head">  
                                    <p align="center"> 
                                        <img src="/images/reporters/prefeitura.png" width="260" height="80">
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
                                        <td>[ ] - Nome da Mãe: ' . $sMother . '</td>
                                        <td rowspan="4" class="dedinho-term-report">
                                            <img src="/images/reporters/dedinho.png">
                                        </td>
                                    </tr>
                                    <tr><td class="answer-line"></td></tr>
                                    <tr><td><br>[ ] - Nome do Pai: ' . $sFather . '</td></tr>
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
                                . "<pagebreak  suppress='off' />"; 
                        $mpdf->WriteHTML($html);
                    endforeach;
                endforeach;
            endforeach;
            $mpdf->Output('terms.pdf', 'I');
            exit;
        }
    }

    public function actionGetConsultationLetter() {
        $letter = isset($_POST['consultation-letter-form']) ? $_POST['consultation-letter-form'] : null;
        $sid = isset($letter['campaign-student']) && !empty($letter['campaign-student']) ? $letter['campaign-student'] : null;
        $date = isset($letter['consult-date']) && !empty($letter['consult-date']) ? $letter['consult-date'] : "____/____/____";
        $time = isset($letter['consult-time']) && !empty($letter['consult-time']) ? $letter['consult-time'] : "____:____";
        $place = isset($letter['consult-location']) && !empty($letter['consult-location']) ? $letter['consult-location'] : "____________________________________";

        $student = ($sid != null) ? \app\models\student::find()->where("id = :sid", ['sid' => $sid])->one() : null;
        /* @var $student \app\models\student */
        $name = $student != null ? $student->name : "____________________________________________________________________";
        $gender = $student->gender;
        echo $this->actionGetConsultationLetterRaw($sid, $date, $time, $place);
    }
    
    public function actionGetConsultationLetterRaw($name, $gender, $date, $time, $place){
        $sex = $student == null ? true : ($gender == "male" ? true : false); /* male or female */

        $html =  "Prezados Pais,"
        . "<br/>"
        . "<br/>"
        . "<p>Como é do conhecimento de vocês, realizamos, a partir de uma gotinha de sangue tirada do dedo "
        . ($sex ? "do seu filho" : "da sua filha")
        . " <b><u>"
        . $name
        . "</u></b>, um exame que diagnostica a anemia.</p>"
        . "<p>Ficamos preocupados, pois o resultado mostrou que "
        . ($sex ? "ele" : "ela")
        . " encontra-se com anemia. Vocês deverão levar "
        . ($sex ? "seu filho" : "sua filha")
        . " à consulta médica, para que ele receba o tratamento:</p>"
        . "<b>Dia da Consulta:</b>"
        . " <b><u>"
        . $date
        . "</u></b><br/>"
        . "<b>Hora da Consulta:</b>"
        . " <b><u>"
        . $time
        . "</u></b><br/>"
        . "<b>Local da Consulta:</b>"
        . " <b><u>"
        . $place
        . "</u></b><br/>"
        . "<p>Gostaríamos de pedir a vocês para já prestarem atenção na alimentação da "
        . ($sex ? "seu filho" : "sua filha")
        . ", principalmente nestes pontos:<br/><br/>"
        . "   <b>1 – Devemos oferecer às crianças, sempre que possível, carnes (de boi, frango ou peixe), feijão e folhas escuras, como couve e brócolis;<br/><br/>"
        . "      2 – Devemos oferecer às crianças, logo após as refeições, sucos de frutas, principalmente as cítricas, como laranja e limão;<br/><br/>"
        . "      3 – Não devemos deixar as crianças tomarem refrigerantes, chá ou café junto das refeições;<br/><br/>"
        . "      4 – Lembrem-se também que leite faz muito bem, mas não junto das refeições. É melhor deixar passar duas horas após a refeição para dar leite às crianças.<br/></b><p/>"
        . "Com estas medidas podemos ajudar as nossas crianças a ficarem sempre saudáveis e alegres.<br/><br/>";
        
        return $html;
        
    }

}
