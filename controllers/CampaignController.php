<?php

namespace app\controllers;

use Yii;
use app\models\campaign;
use app\models\classroom;
use app\models\school;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/**
 * CampaignController implements the CRUD actions for Campaign model.
 */
class CampaignController extends Controller {

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
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Campaign::find(),
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Campaign model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    
    /**
     * Get the Schools.
     * 
     * @return string
     */
    public function actionGetSchoolsList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $cid = end($_POST['depdrop_parents']);
            if (!empty($cid)) {
                $campaign = campaign::find()->where('id = :cid',['cid'=>$cid])->one();
                /** @var \app\models\campaign  $campaign */
                $schools = $campaign->getSchools()->asArray()->all();

                foreach ($schools as $i => $school) {
                    $out[] = ['id' => $school['id'], 'name' => $school['name']];
                }
            }
            // echo Json::encode(['output' => $out, 'selected' => '']);
            return Json::encode(['output' => $out, 'selected' => '']);;
        }
        return  Json::encode(['output' => '', 'selected' => '']);
    }
    /**
     * Get the classrooms.
     * 
     * @return string
     */
    public function actionGetClassroomsList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $sids = end($_POST['depdrop_parents']);
            if (!is_array($sids) && !empty($sids)) {
                $sids = [$sids];
            }
            if(is_array($sids)){
                foreach ($sids as $sid) {
                    $school = school::find()->where('id = :sid',['sid'=>$sid])->one();
                    /** @var \app\models\school $school  */
                    $classrooms = $school->getClassrooms()->where('`year`= :year',[ 'year'=>(date("Y"))])->asArray()->all();
                    foreach ($classrooms as $i => $classroom) {
                        $out[] = ['id' => $classroom['id'], 'name' => $classroom['name']];
                    }
                }
            }
            return Json::encode(['output' => $out, 'selected' => '']);
            // return;
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }

    /**
     * Get the students.
     * 
     * @return Json
     */
    public function actionGetStudentsList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $cid = end($_POST['depdrop_parents']);
            if (!empty($cid)) {
                $classroom = classroom::find()->where('id = :cid',['cid'=>$cid])->one();
                /* @var $classroom \app\models\classroom */
                $students = $classroom->getStudents()->asArray()->all();

                foreach ($students as $i => $student) {
                    $out[] = ['id' => $student['id'], 'name' => $student['name']];
                }
            }
            echo Json::encode(['output' => $out, 'selected' => '']);
            return;
        }
        echo Json::encode(['output' => '', 'selected' => '']);
    }
    
    /**
     * Get the enrollments.
     * 
     * @return Json
     */
    public function actionGetEnrollmentsList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $cid = end($_POST['depdrop_parents']);
            if (!empty($cid)) {
                $classroom = classroom::find()->where('id = :cid',['cid'=>$cid])->one();
                /* @var $classroom \app\models\classroom */
                $enrollments = $classroom->getEnrollments()->all();

                foreach ($enrollments as $i => $enrollment) {
                    /* @var $enrollment \app\models\enrollment*/
                    $out[] = ['id' => $enrollment->id , 'name' => $enrollment->students->name];
                }
            }
            return Json::encode(['output' => $out, 'selected' => '']);
           
        }
        return Json::encode(['output' => '', 'selected' => '']);
    }
    
    /**
     * Creates a new Campaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new campaign();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh();
            // VarDumper::dump($_POST['classrooms']);
            if (isset($_POST['classrooms'])) {
                foreach ($_POST['classrooms'] as $cid) {
                    if (!empty($cid)) {
                        $classroom = \app\models\classroom::find()->where('id = :cid',['cid'=>$cid])->one();
                        /* @var $classroom \app\models\classroom */
                        $enrollments = $classroom->getEnrollments()->asArray()->all();

                        foreach ($enrollments as $enrollment) {
                            /* @var $enrollment array */
                            $term = new \app\models\term();
                            $term->campaign = $model->id;
                            $term->enrollment = $enrollment['id'];
                            $term->agreed = 0;
                            $term->save();
                        }
                    }
                }
            }

            return $this->redirect(['/']);
        }
        return $this->renderAjax('create', ['model' => $model]);
    }

    /**
     * Updates an existing Campaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh();
            
            return $this->redirect(['/']);
        }
        return $this->renderAjax('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Campaign model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Campaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
