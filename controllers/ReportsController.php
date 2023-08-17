<?php

namespace app\controllers;
use Yii;
use app\models\campaign;
use app\models\term;
use app\models\enrollment;
use app\models\classroom;
use app\models\school;
use app\models\student;
use app\models\Report;
use app\components\AnamnesePdfWidget;
use app\components\AnamneseWidget;
use app\components\TermPdfWidget;
use app\components\TermWidget;

class ReportsController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionConsultationLetter($sid = null, $eid, $cid) {
        $options = $sid == null ? [] : ['student' => \app\models\student::find()->where('id = :sid', ['sid' => $sid])->one(), 'eronllment'=>$eid, 'campaign' => $cid];
        return $this->render('consultationLetter', $options );
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
        
        $mpdf = new \mPDF();

        $css1 = file_get_contents(__DIR__ . '/../vendor/bower-asset/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        $i = 1;
        foreach($hemoglobins as $hemoglobin){
            if($hemoglobin->isAnemic()){
                $term = $hemoglobin->getAgreedTerm()->one();
                $enrollment = $term->getEnrollments()->one();
                $prescription = $this->actionPrescription($cid, $enrollment->id, false);
                $name = $prescription['name'];
                $sulfato = $prescription['sulfato'];
                $vermifugo = $prescription['vermifugo'];
                $report = new Report();
                $report->cid = $cid;
                $report->eid = $enrollment->id;
                $data = $report->getAnamnese();
                $mpdf->WriteHTML(AnamnesePdfWidget::widget(['data' => $data ]));
                $mpdf->WriteHTML('<div class="">'.$i.' </div>');
                if($i % 3 == 0 )
                    $mpdf->WriteHTML ("<pagebreak />");
                $i++;
            }
        }
        $mpdf->Output('MultiplePrescriptions.pdf', 'I');
    }
    public function actionPrescription($cid, $eid,$render=True) {
        /* @var $enrollment \app\models\enrollment */
        /* @var $student \app\models\student */
        /* @var $anatomy \app\models\anatomy */


        $enrollment = $eid != null ? \app\models\enrollment::find()->where("id = :eid", [ 'eid' => $eid])->one() : null;
        $student = $enrollment != null ? $enrollment->students : null;
        $term = $eid != null ? \app\models\term::find()->where("enrollment = :eid and campaign = :cid", ['eid' => $eid, 'cid' => $cid])->one() : null;
        $hb1 = $term != null ? $term->getHemoglobins()->where("sample = 1")->one() : null;
        $anatomy = $student != null ? $student->getAnatomies()->orderBy("date desc")->one() : null;



        $name = $student != null ? $student->name : "";
        $anatomy = $student->getAnatomies()->orderBy("date desc")->one();
        $birthday = $student != null ? date("d/m/Y", strtotime($student->birthday)) : "";
        $b = $student != null ? $student->birthday : "";
        $today = $student != null ? new \DateTime(date("Y-m-d")) : "";
        $age = $student != null ? $today->diff(new \DateTime($b))->format("%y") . " " . \yii::t('app', 'years old') : "";
        $sex = $student != null ? \yii::t('app', $student->gender) : "";
        $weight = $anatomy != null ? $anatomy->weight . "kg" : "";
        $height = $anatomy != null ? $anatomy->height . "m" : "";
        $imc = $anatomy != null ? number_format($anatomy->weight / pow($anatomy->height, 2), 2) : "";
        $rate1 = $hb1 != null ? $hb1->rate . "g/dL" : "";

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
            $vermifugo = "<b>Albendazol</b> em comprimido, (pode dissolver em água ou suco).";
        }



        $data_student=[
            'name' => $name,
            'age' => $age,
            'birthday' => $birthday,
            'sex' => $sex,
            'height' => $height,
            'weight' => $weight,
            'imc' => $imc,
            'rate1' => $rate1
        ];


        $options = [
            "student" => $data_student,
            "sulfato" => $sulfato,
            "vermifugo" => $vermifugo
        ];

        if($render){
            return $this->render('prescription', $options);
        }else{
            return $options;
        }
    }
    public function actionAllPrescription($cid) {
        $terms = \app\models\term::find()->where("campaign = :cid", ['cid' => $cid])->all(); 
        
        $sulfatoComprimidos = 0;
        $sulfatoGota = 0;
        $vermifugo = 0;
        foreach($terms as $term){
            $student = $term->getStudents()->one();
            $anatomy = $student != null ? $student->getAnatomies()->orderBy("date desc")->one() : null;

            if($anatomy != null) {
                $peso = $anatomy->weight;
    
                $concentracaoPorML = 25;
                $gotasPorML = 20;
                $concentracaoPorGota = $concentracaoPorML / $gotasPorML;
    
                $posologia = ceil($peso / $concentracaoPorGota);
    
                if ($peso > 30) {
                    $sulfatoComprimidos++;
                } else {
                    $sulfatoGota+= $posologia;
                }
                $vermifugo++;
            }
        }
        var_dump("sulfato comprimidos: ".$sulfatoComprimidos . "<br>");
        var_dump("sulfato gotas: ".$sulfatoGota. "<br>");
        var_dump("vermifugo comprimidos: ".$vermifugo. "<br>");
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

        $mpdf = new \mPDF();

        $css1 = file_get_contents(__DIR__ . '/../vendor/bower-asset/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        $i = 1;
        $html = "";
        foreach($hemoglobins as $hemoglobin){
            if($hemoglobin->isAnemic()){
                $term = $hemoglobin->getAgreedTerm()->one();
                $enrollment = $term->getEnrollments()->one();
                $student = $enrollment->getStudents()->one();
                
                $eid = $enrollment->id;
                $name = $student != null ? $student->name : "____________________________________________________________________";
                $gender = $student->gender;
                $report = new Report();
                $report->cid = $cid;
                $report->eid = $eid;
                $data = $report->getAnamnese();
                //$html = $this->actionGetAnamneseRaw($cid, $eid, false);

                //$mpdf->WriteHTML ('<div class="none">'.$i.' </div>');
                //$mpdf->WriteHTML(AnamnesePdfWidget::widget(['data' => $data ]));
                //$mpdf->WriteHTML ("<pagebreak />");
                //$mpdf->WriteHTML ('<div class="none">'.$i.' </div>'.$this->actionGetConsultationLetterRaw($name, $gender, $date, $time, $place));
                //$mpdf->WriteHTML ("<pagebreak />");
                //$i++;
                $html .= AnamneseWidget::widget(['data' => $data ]);
            }
        }
        //$mpdf->Output('LetterAndAnamnese.pdf', 'I');
        return $this->render('letterAndAnamnese', ['html' => $html]);
    }

    public function actionAnamnese($cid, $eid = null) {
        $options = $eid == null ? ['campaign' => $cid] : ['enrollment' => \app\models\enrollment::find()->where('id = :eid', ['eid' => $eid])->one(), 'campaign' => $cid];

        return $this->render('anamnese', $options);
    }

    public function actionGetAnamnese() {
        $anamnese = isset($_POST['anamnese-form']) ? $_POST['anamnese-form'] : null;
        $cid = isset($anamnese['campaign']) && !empty($anamnese['campaign']) ? $anamnese['campaign'] : null;
        $eid = isset($anamnese['campaign-enrollment']) && !empty($anamnese['campaign-enrollment']) ? $anamnese['campaign-enrollment'] : null;
        
        return $this->actionGetAnamneseRaw($cid, $eid);
    }
    
    public function actionGetAnamneseRaw($cid=null, $eid=null, $json=true){
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
        $imc = $anatomy != null ? number_format($anatomy->weight / pow($anatomy->height, 2), 2) : "";
        $rate1 = $hb1 != null ? $hb1->rate . "g/dL" : "";
        $sulfato ='';
        $vermifugo ='';

        if ($anatomy == null) {
            $sulfato = "<br>";
            $vermifugo = "<br>";
        } else {

            $concentracaoPorML = 25;
            $gotasPorML = 20;
            $concentracaoPorGota = $concentracaoPorML / $gotasPorML;

            $posologia = ceil($anatomy->weight / $concentracaoPorGota);


//            $gotasPor3 = $concentracaoPorGota/3;
//            $gotasPorPeso = ceil($gotasPor3 * $peso);

            if ($weight > 30) {
                $sulfato = "<b>Sulfato Ferroso</b> em comprimido, <b>1 Comprimido a cada 12h</b>.";
            } else {
                $sulfato = "<b>Sulfato Ferroso</b> em gotas, <b>$posologia gotas</b>, três vezes ao dia.";
            }
            $vermifugo = "<b>Albendazol</b> em comprimido, (pode dissolver em água ou suco).";
        }

        $html['prescription'] =
        '<h2 class="report-title">'.$name.'</h2>'
        .'<p class="no-indent">'.$sulfato.'</p>'
        .'<p class="no-indent">'.$vermifugo.'</p>';

        $html['student'] = $this->renderPartial('blocks/student',[ 'data' => [
            'name' => $name,
            'birthday' => $birthday,
            'age' => $age,
            'sex' => $sex,
            'weight' => $weight,
            'height' => $height,
            'imc' => $imc,
            'rate1' => $rate1
        ]]);

        if($json){
            return \Yii::createObject([
                'class' => 'yii\web\Response',
                'format' => \yii\web\Response::FORMAT_JSON,
                'data' => [
                    'student' => $html['student'],
                    'prescription' => $html['prescription']
                ],
            ]);
        }
        else{
            return $html;
        }
    }
    
    public function actionAgreedTerms($cid, $sid) {
        /* @var $campaign campaign */
        /* @var $school school */

        $school = school::find()->where("id = :sid", ['sid' => $sid])->one();
        $terms = $school->getTerms()
                ->where("term.campaign = :cid and term.agreed = true", ['cid' => $cid])
                ->innerJoin("enrollment e", "term.enrollment = e.id")
                ->innerJoin("student s", "e.student = s.id")
                ->orderBy("s.name ASC")
                ->all();

        $tAgreed = [];

        foreach ($terms as $term){
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
                $tAgreed[$classroom->name] = array_merge(
                    $tAgreed[$classroom->name], 
                    [
                        [
                            'name' => $student->name,
                            'birthday' => $student->birthday,
                            'hb1' => $hemoglobin1 != null ? sprintf('%0.1f', $hemoglobin1->rate) : "",
                            'hb2' => $hemoglobin2 != null ? sprintf('%0.1f', $hemoglobin2->rate) : "",
                            'hb3' => $hemoglobin3 != null ? sprintf('%0.1f', $hemoglobin3->rate) : ""
                        ]
                    ]
                );
            } else {
                $tAgreed[$classroom->name] = [['name' => $student->name,
                        'birthday' => $student->birthday,
                        'hb1' => $hemoglobin1 != null ? sprintf('%0.1f', $hemoglobin1->rate) : "",
                        'hb2' => $hemoglobin2 != null ? sprintf('%0.1f', $hemoglobin2->rate) : "",
                        'hb3' => $hemoglobin3 != null ? sprintf('%0.1f', $hemoglobin3->rate) : ""
                ]];
            }
        }

        $html = $this->renderPartial('agreedTerms', ['terms' => $tAgreed, 'school' => $school->name ]);

        $mpdf = new \mPDF();

        $css1 = file_get_contents(__DIR__ . '/../vendor/bower/bower-asset/dist/css/bootstrap.css');
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
        $mpdf = new \mPDF();
        $css1 = file_get_contents(__DIR__ . '/../vendor/bower-asset/bootstrap/dist/css/bootstrap.css');
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
                        $sFather = ($student['nameFather'] == 'NAO DECLARADO' ? '' : $student['nameFather']);


                        //========================================================  
                        $html = TermPdfWidget::widget([
                            'data'=>[
                                'sName'=> $sName,
                                'cName'=> $cName,
                                'mother'=> $sMother,
                                'father'=> $sFather
                            ]
                        ]);
                        $mpdf->WriteHTML("<pagebreak  suppress='off' />");
                        $mpdf->WriteHTML($html);
                    endforeach;
                endforeach;
            endforeach;
            $mpdf->Output('terms.pdf', 'I');
            exit;
        }
    }

    /**
     * Build Terms
     * 
     * @return Json
     */
    public function actionBuildTermsHtml($cid) {
        $campaignID = $cid;
        $html = "";

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

            return $this->render('buildTerm',['schools' => $schools]);
        }
    }

    public function actionGetConsultationLetter() {
        $letter = isset($_POST['consultation-letter-form']) ? $_POST['consultation-letter-form'] : null;
        $eid = isset($letter['student-erollment']) && !empty($letter["student-erollment"]) ? $letter["student-erollment"] : null;
        $cid = isset($letter['campaign']) && !empty($letter["campaign"]) ? $letter["campaign"] : null;
        $sid = isset($letter['campaign-student']) && !empty($letter['campaign-student']) ? $letter['campaign-student'] : null;
        $date = isset($letter['consult-date']) && !empty($letter['consult-date']) ? $letter['consult-date'] : "____/____/____";
        $time = isset($letter['consult-time']) && !empty($letter['consult-time']) ? $letter['consult-time'] : "____:____";
        $place = isset($letter['consult-location']) && !empty($letter['consult-location']) ? $letter['consult-location'] : "____________________________________";
        $term = $eid != null ? \app\models\term::find()->where("enrollment = :eid and campaign = :cid", ['eid' => $eid, 'cid' => $cid])->one() : null;
        $hb1 = $term != null ? $term->getHemoglobins()->where("sample = 1")->one() : null;
        $student = ($sid != null) ? \app\models\student::find()->where("id = :sid", ['sid' => $sid])->one() : null;
        /* @var $student \app\models\student */
        $name = $student != null ? $student->name : "____________________________________________________________________";
        $gender = $student->gender;  
        $consultationLetter = $this->actionGetConsultationLetterRaw($name, $gender, $date, $time, $place, $hb1["rate"]);
      
        Yii::$app->response->content = $consultationLetter;
    }
   
    public function actionGetConsultationLetterRaw($name, $gender, $date, $time, $place, $hb1){
        $sex = $gender == null ? true : ($gender == "male" ? true : false); /* male or female */

        $html =  "Prezados Pais,"
        . "<br/>"
        . "<br/>"
        . "<p>Como é do conhecimento de vocês, realizamos, a partir de uma gotinha de sangue tirada do dedo "
        . ($sex ? "do seu filho" : "da sua filha")
        . " <b><u>"
        . $name
        . "</u></b>, um exame que diagnostica a anemia.</p>"
        ."<p>O nível de hemoglobina encontrada no exame foi "
        .$hb1
        ."</p>"
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
        . "<p>Gostaríamos de pedir a vocês para já prestarem atenção na alimentação "
        . ($sex ? "do seu filho" : "da sua filha")
        . ", principalmente nestes pontos:<br/><br/>"
        . "   <b>1 – Devemos oferecer às crianças, sempre que possível, carnes (de boi, frango ou peixe), feijão e folhas escuras, como couve e brócolis;<br/><br/>"
        . "      2 – Devemos oferecer às crianças, logo após as refeições, sucos de frutas, principalmente as cítricas, como laranja e limão;<br/><br/>"
        . "      3 – Não devemos deixar as crianças tomarem refrigerantes, chá ou café junto das refeições;<br/><br/>"
        . "      4 – Lembrem-se também que leite faz muito bem, mas não junto das refeições. É melhor deixar passar duas horas após a refeição para dar leite às crianças.<br/></b><p/>"
        . "Com estas medidas podemos ajudar as nossas crianças a ficarem sempre saudáveis e alegres.<br/><br/>";
        
        return $html;
        
    }


    public function actionWeightHeight($cid) {

        $campaign = \app\models\campaign::find()->where("id = :c1", ["c1" => $cid])->one();
        /* @var $campaign \app\models\campaign */
        $terms = \app\models\term::find()->where("campaign = :c1", ["c1" => $cid])
            ->innerJoin('enrollment as en', 'enrollment = en.id')
            ->innerJoin('student as s', 's.id = en.student')
            ->innerJoin('classroom as c', 'c.id = en.classroom')
            ->leftJoin('anatomy as a', 's.id = a.student')
            ->groupBy('s.id')
            ->orderBy('c.name ASC, s.name ASC')
            ->all();

        $students = array();

        foreach ($terms as $term):

            $enrollment = \app\models\enrollment::find()->where("id = :a", ["a" => $term->enrollment])->one();
            $student = \app\models\student::find()->where("id = :a", ["a" => $enrollment->student])->one();
            $classroom = \app\models\classroom::find()->where("id = :a", ["a" => $enrollment->classroom])->one();
            $school = \app\models\school::find()->where("id = :a", ["a" => $classroom->school])->one();
            $anatomy = \app\models\anatomy::find()->where("student = :a", ["a" => $student->id])->one();

            $students[$school->id]['name'] = $school->name;
            $students[$school->id]['classrooms'][$classroom->id]['name'] = $classroom->name;
            $students[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['name'] = $student['name'];
            $students[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['weight'] = $anatomy['weight'];
            $students[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['height'] = $anatomy['height'];

        endforeach;
        
        $html = $this->renderPartial('weight-height',['data' => [
            'school' => $school['name'],
            'classroom' => $classroom['name'],
            'students' => $students
        ]]);

        $mpdf = new \mPDF();

        $css1 = file_get_contents(__DIR__ . '/../vendor/bower-asset/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        $mpdf->WriteHTML($html);

        $mpdf->Output('HB - Lista de pesos e alturas.pdf', 'I');
        exit;
    }

    public function actionHealth($year = null) {
        if(!isset($year)){
            $year = date("Y");
        }
        return $this->render("health", [
            'year' => $year
        ]);
    }
}

