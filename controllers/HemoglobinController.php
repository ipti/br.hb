<?php

namespace app\controllers;

use Yii;
use app\models\hemoglobin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\consultation;

/**
 * HemoglobinController implements the CRUD actions for hemoglobin model.
 */
class HemoglobinController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
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
    public function actionIndex($c, $s) {
        $campaign = \app\models\campaign::find()->where("id = :c1", ["c1" => $c])->one();
        /* @var $campaign \app\models\campaign */
        $q = $campaign->getHemoglobins()
                ->where('sample = :s', ['s' => $s])
                ->innerJoin('term', 'agreed_term = term.id')
                ->innerJoin('enrollment as en', 'term.enrollment = en.id')
                ->innerJoin('student as s', 's.id = en.student')
                ->orderBy('s.name ASC');
        
        $dataProvider = new ActiveDataProvider([
            'query' => $q
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'campaign' => $campaign,
                    'sample' => $s
        ]);
    }

    /**
     * Displays a single hemoglobin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Get a list with terms agreeded by classroom.
     * 
     * @param integer $cid
     * @return json
     */
    public function actionGetAgreedTerms($clid, $cid, $samp) {
        /* @var $classroom \app\models\classroom */
        /* @var $term \app\models\term */
        $classroom = \app\models\classroom::find()->where("id = :clid", ["clid" => $clid])->one();
        $terms = $classroom->getTerms()->where("agreed = true and campaign = :cid", ['cid' => $cid])->all();

        $response = [];
        foreach ($terms as $term) {
            $hbs = $term->getHemoglobins()->where("sample = :samp", ["samp" => $samp])->count();
            if ($hbs == 0)
                $response[$term->enrollments->students->name] = $term->id;
        }

        echo \yii\helpers\Json::encode($response);
        exit;
    }

    /**
     * Get a list with consults attended by classroom.
     * 
     * @param integer $cid
     * @return json
     */
    public function actionGetAttendedConsults($clid, $cid, $samp) {
        /* @var $classroom \app\models\classroom */
        /* @var $consult \app\models\consultation */
        $classroom = \app\models\classroom::find()->where("id = :clid", ["clid" => $clid])->one();
        $terms = $classroom->getTerms()->where("campaign = :cid", ['cid' => $cid])->all();
        
        $consults = [];
        foreach ($terms as $term) {
            $hbs = $term->getHemoglobins()->where("sample = :samp", ["samp" => $samp])->count();
            if ($hbs == 0) {
                $consult = $term->getConsults()->where("attended = true")->one();
                if ($consult != null)
                    $consults = array_merge($consults, [$consult]);
            }
        }
        $response = [];
        foreach ($consults as $consult) {
                $response[$consult->terms->enrollments->students->name] = $consult->terms->id;
        }
        echo \yii\helpers\Json::encode($response);
        exit;
    }

    /**
     * Creates a new hemoglobin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cid, $s) {
        if (Yii::$app->request->post() != null) {
            $clid = Yii::$app->request->post()['classroom'];
            $hemoglobins = Yii::$app->request->post()['hemoglobin'];
            $sample = $s;
            foreach ($hemoglobins as $term => $rate) {
                $model = new hemoglobin();
                if (!empty($rate)) {
                    $model->agreed_term = $term;
                    $model->rate = $rate;
                    $model->sample = $sample;
                    $model->save();
                    if($sample == 1){
                        //Se anêmica cadastrar a consulta
                        $objTerm = \app\models\term::find()->where("id = :a", ["a" => $term])->one();
                        $enrollment = \app\models\enrollment::find()->where("id = :a", ["a" => $objTerm->enrollment])->one();
                        $student = \app\models\student::find()->where("id = :a", ["a" => $enrollment->student])->one();

                        $genderStudent = $student->gender;
                        $ageStudent = (time() - strtotime($student->birthday)) / (60 * 60 * 24 * 30);

                        $isAnemic = false;
                        if (($ageStudent > 24) && ($ageStudent < 60)) {
                            $isAnemic = !($rate >= 11);
                        } else if (($ageStudent >= 60) && ($ageStudent < 144)) {
                            $isAnemic = !($rate >= 11.5);
                        } else if (($ageStudent >= 144) && ($ageStudent < 180)) {
                            $isAnemic = !($rate >= 12);
                        } else if ($ageStudent >= 180) {

                            if ($genderStudent == "male") {
                                $isAnemic = !($rate >= 13);
                            } else {
                                //female
                                $isAnemic = !($rate >= 12);
                            }
                        }

                        if($isAnemic){
                            //Cadastra a Consulta
                             $modelConsultation = new consultation();
                             $modelConsultation->term = $term;
                             $modelConsultation->save();
                        }
                    }
                }
            }
            return $this->redirect(['index', 'c' => $cid, 's' => $s]);
        } else {
            $model = new hemoglobin();
            $campaign = \app\models\campaign::find()->where("id=:id", ['id' => $cid])->one();

            return $this->render('create', [
                        'model' => $model,
                        'campaign' => $campaign,
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
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
        
            if($model->sample == 1){
                $term = $model->agreed_term;
                $rate = $model->rate;
                $model->save();

                //Se anêmica cadastrar a consulta
                /* @var $objTerm \app\models\term */
                $objTerm = \app\models\term::find()->where("id = :a", ["a" => $term])->one();
                $enrollment = \app\models\enrollment::find()->where("id = :a", ["a" => $objTerm->enrollment])->one();
                $student = \app\models\student::find()->where("id = :a", ["a" => $enrollment->student])->one();


                /* @var $consult \app\models\consultation */
                $consult = $objTerm->getConsults()->one();
                if($consult != null)
                    $consult->delete();

                $genderStudent = $student->gender;
                $ageStudent = (time() - strtotime($student->birthday)) / (60 * 60 * 24 * 30);

                $isAnemic = false;
                if (($ageStudent > 24) && ($ageStudent < 60)) {
                    $isAnemic = !($rate >= 11);
                } else if (($ageStudent >= 60) && ($ageStudent < 144)) {
                    $isAnemic = !($rate >= 11.5);
                } else if (($ageStudent >= 144) && ($ageStudent < 180)) {
                    $isAnemic = !($rate >= 12);
                } else if ($ageStudent >= 180) {

                    if ($genderStudent == "male") {
                        $isAnemic = !($rate >= 13);
                    } else {
                        //female
                        $isAnemic = !($rate >= 12);
                    }
                }

                if($isAnemic){
                    //Cadastra a Consulta
                    $modelConsultation = new consultation();
                    $modelConsultation->term = $term;
                    $modelConsultation->save();
                }
            }
            
            return $this->redirect(['index', 'c' => $model->agreedTerm->campaigns->id, 's' => $model->sample]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionAnemicsLists() {

        $cid = $_GET['cid'];
        $sample = $_GET['s'];


        $campaign = \app\models\campaign::find()->where("id = :c1", ["c1" => $cid])->one();
        /* @var $campaign \app\models\campaign */
        $terms = \app\models\term::find()->where("campaign = :c1 AND agreed = 1", ["c1" => $cid])
                ->innerJoin('enrollment as en', 'enrollment = en.id')
                ->innerJoin('student as s', 's.id = en.student')
                ->innerJoin('classroom as c', 'c.id = en.classroom')
                ->orderBy('c.name ASC, s.name ASC')
                ->all();

        $schoolsAnemics = array();

        foreach ($terms AS $termAgreed):
            // Somente possui uma hemoglobin por termo
            $hemoglobin = \app\models\hemoglobin::find()->where("agreed_term = :a AND sample = :s", ["a" => $termAgreed->id, "s" => $sample])->one();

            if (isset($hemoglobin)) {
                //Então pesquisa o student atravez do $termAgreed

                $enrollment = \app\models\enrollment::find()->where("id = :a", ["a" => $termAgreed->enrollment])->one();
                $student = \app\models\student::find()->where("id = :a", ["a" => $enrollment->student])->one();
                $classroom = \app\models\classroom::find()->where("id = :a", ["a" => $enrollment->classroom])->one();
                $school = \app\models\school::find()->where("id = :a", ["a" => $classroom->school])->one();

                $rate = $hemoglobin->rate;
                $nameStudent = $student->name;
                $genderStudent = $student->gender;
                $ageStudent = (strtotime($campaign->end) - strtotime($student->birthday)) / (60 * 60 * 24 * 30);


                $isAnemic = false;
                if (($ageStudent > 24) && ($ageStudent < 60)) {
                    $isAnemic = !($rate >= 11);
                } else if (($ageStudent >= 60) && ($ageStudent < 144)) {
                    $isAnemic = !($rate >= 11.5);
                } else if (($ageStudent >= 144) && ($ageStudent < 180)) {
                    $isAnemic = !($rate >= 12);
                } else if ($ageStudent >= 180) {

                    if ($genderStudent == "male") {
                        $isAnemic = !($rate >= 13);
                    } else {
                        //female
                        $isAnemic = !($rate >= 12);
                    }
                }

                if ($isAnemic) {
                    //Se for anêmico, dá push no array
                    $schoolsAnemics[$school->id]['name'] = $school->name;
                    $schoolsAnemics[$school->id]['classrooms'][$classroom->id]['name'] = $classroom->name;
                    $schoolsAnemics[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['name'] = $nameStudent;
                    $schoolsAnemics[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['rate'] = $rate;
                    $schoolsAnemics[$school->id]['classrooms'][$classroom->id]['students'][$student->id]['gender'] = $genderStudent;
                }
            }

        endforeach;


        $html = $this->renderPartial('anemics', ['data' => [
            'schoolAnemics' => $schoolsAnemics
        ]]);


        $mpdf = new \mPDF();

        $css1 = file_get_contents(__DIR__ . '/../vendor/bower-asset/bootstrap/dist/css/bootstrap.css');
        $mpdf->WriteHTML($css1, 1);

        $css2 = file_get_contents(__DIR__ . '/../web/css/reports.css');
        $mpdf->WriteHTML($css2, 1);

        $mpdf->WriteHTML($html);

        $mpdf->Output('ListAnemicsStudents.pdf', 'I');
        exit;
    }

    /**
     * Deletes an existing hemoglobin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
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
    protected function findModel($id) {
        if (($model = hemoglobin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
