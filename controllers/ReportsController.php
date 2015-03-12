<?php

namespace app\controllers;

use app\models\campaign;
use app\models\term;
use app\models\enrollment;

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

    public function actionAnamnese() {
        return $this->render('anamnese');
    }

    /**
     * Build Terms
     * 
     * @return Json
     */
    public function actionBuildTerms() {
        $campaignID = $_POST['campaignID'];
        if (isset($campaignID)) {
            $shools = array();
            
            $campaign = campaign::find()->where('id = :sid',['sid'=>$campaignID])->one();
            
            $terms = term::find()->where('campaign = :scampaign',['scampaign'=>$campaign->id])->all();
            
            
            foreach($terms as $term):
                //Para cada Termo para esta Capanha
                 $enrollments = enrollment::find()->where('id = :sid',['sid'=>$term->enrollment])->one();
                 
            //CRIAR MAPEAMENTO !
            
            endforeach;
            
        }
    }

    public function actionGetConsultationLetter($student = null) {
        $letter = isset($_POST['consultation-letter-form']) ? $_POST['consultation-letter-form'] : null;
        $sid = isset($letter['campaign-student']) && !empty($letter['campaign-student']) ? $letter['campaign-student'] : null;
        $date = isset($letter['consult-date']) && !empty($letter['consult-date']) ? $letter['consult-date'] : "____/____/____";
        $time = isset($letter['consult-time']) && !empty($letter['consult-time']) ? $letter['consult-time'] : "____:____";
        $place = isset($letter['consultlocation']) && !empty($letter['consult-location']) ? $letter['consult-location'] : "____________________________________";

        $student = ($letter != null && $sid != null) ? \app\models\student::find()->where("id = :sid", ['sid' => $letter["campaign-student"]])->one() : null;
        /* @var $student \app\models\student */
        $name = $student != null ? $student->name : "____________________________________________________________________";
        $sex = $student == null ? true : ($student->gender == "male" ? true : false); /* male or female */

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
        echo "<b>Local da Consula:</b>";
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
