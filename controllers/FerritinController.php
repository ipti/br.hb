<?php

namespace app\controllers;

use Yii;
use app\models\Ferritin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\consultation;
use mPDF;

/**
 * FerritinController implements the CRUD actions for Ferritin model.
 */
class FerritinController extends Controller
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
     * Lists all  models.
     * @return mixed
     */
    public function actionIndex($c)
    {
        $campaign = \app\models\campaign::find()->where("id = :c1", ["c1" => $c])->one();
        $q = $campaign->getFerritin()
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
        ]);
    }

    /**
     * Get a list with terms agreeded by classroom.
     * 
     * @param integer $cid
     * @return json
     */
    public function actionGetAgreedTerms($clid, $cid)
    {
        /* @var $classroom \app\models\classroom */
        /* @var $term \app\models\term */
        $classroom = \app\models\classroom::find()->where("id = :clid", ["clid" => $clid])->one();
        $terms = $classroom->getTerms()->where("agreed = true and campaign = :cid", ['cid' => $cid])->all();

        $response = [];
        foreach ($terms as $term) {
            $frt = $term->getFerritin()->count();
            if ($frt == 0)
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
    public function actionGetAttendedConsults($clid, $cid, $samp)
    {
        /* @var $classroom \app\models\classroom */
        /* @var $consult \app\models\consultation */
        $classroom = \app\models\classroom::find()->where("id = :clid", ["clid" => $clid])->one();
        $terms = $classroom->getTerms()->where("campaign = :cid", ['cid' => $cid])->all();

        $consults = [];
        foreach ($terms as $term) {
            $frt = $term->getFerritin()->count();
            if ($frt == 0) {
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

    public function actionCreate($cid)
    {
        if (Yii::$app->request->post() != null) {
            $ferritins = Yii::$app->request->post()['ferritin'];
            foreach ($ferritins as $term => $rate) {
                $model = new ferritin();
                if (!empty($rate)) {
                    $model->agreed_term = $term;
                    $model->rate = $rate;
                    $model->date = date('Y/m/d');
                    $model->save();
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

                    if ($isAnemic) {
                        //Cadastra a Consulta
                        $modelConsultation = new consultation();
                        $modelConsultation->term = $term;
                        $modelConsultation->save();
                    }
                }
            }
            return $this->redirect(['index', 'c' => $cid]);
        } else {
            $model = new Ferritin();
            $campaign = \app\models\campaign::find()->where("id=:id", ['id' => $cid])->one();

            return $this->render('create', [
                'model' => $model,
                'campaign' => $campaign,
            ]);
        }
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $term = $model->agreed_term;
            $rate = $model->rate;

            //Se anêmica cadastrar a consulta
            /* @var $objTerm \app\models\term */
            $objTerm = \app\models\term::find()->where("id = :a", ["a" => $term])->one();
            $enrollment = \app\models\enrollment::find()->where("id = :a", ["a" => $objTerm->enrollment])->one();
            $student = \app\models\student::find()->where("id = :a", ["a" => $enrollment->student])->one();


            /* @var $consult \app\models\consultation */
            $consult = $objTerm->getConsults()->one();
            if ($consult != null)
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

            if ($isAnemic) {
                //Cadastra a Consulta
                $modelConsultation = new consultation();
                $modelConsultation->term = $term;
                $modelConsultation->save();
            }

            return $this->redirect(['index', 'c' => $model->agreedTerm->campaigns->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ferritin model.
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
     * Finds the ferritin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ferritin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ferritin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
