<?php

namespace app\controllers;

use Yii;
use app\models\hemoglobin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * HemoglobinController implements the CRUD actions for hemoglobin model.
 */
class HemoglobinController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all hemoglobin models.
     * @return mixed
     */
    public function actionIndex($c, $s)
    {
        $campaign = \app\models\campaign::find()->where("id = :c1",["c1"=>$c])->one();
        /* @var $campaign \app\models\campaign */
        $q = $campaign->getHemoglobins()->where('sample = :s',['s'=>$s]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $q
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'campaign'=>$campaign,
            'sample'=>$s
        ]);
    }

    /**
     * Displays a single hemoglobin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new hemoglobin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cid, $s)
    {
        $model = new hemoglobin();
        $campaign = \app\models\campaign::find()->where("id=:id",['id'=>$cid])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'c' => $cid, 's'=>$s]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'campaign'=> $campaign,
                'sample' => $s
            ]);
        }
    }

    /**
     * Updates an existing hemoglobin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'c' => $model->agreedTerm->campaigns->id, 's' => $model->sample]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    
    
    public function actionAnemicsLists(){
        
        var_dump($_GET['cid']);exit();
        
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
                                        <img src="/images/reporters/boquim/prefeitura.jpg" width="260" height="120">
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
                                    Caso o senhor concorde, por favor assine este termo.
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
    

    /**
     * Deletes an existing hemoglobin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the hemoglobin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return hemoglobin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = hemoglobin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
