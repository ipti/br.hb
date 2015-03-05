<?php

namespace app\controllers;

use Yii;
use app\models\campaign;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * CampaignController implements the CRUD actions for Campaign model.
 */
class CampaignController extends Controller
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
     * Lists all Campaign models.
     * @return mixed
     */
    public function actionIndex()
    {
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
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Get the classrooms.
     * 
     * @return Json
     */
    public function actionGetClassroomsList() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $schools = end($_POST['depdrop_parents']);
            
            foreach ($schools as $sid){
                $school = \app\models\school::find($sid)->one();
                /* @var $school \app\models\school */
                $classrooms = $school->getClassrooms()->asArray()->all();
                foreach($classrooms as $i => $classroom){
                    $out[] = ['id'=> $classroom['id'], 'name'=>$school->name.' - '.$classroom['name']];
                }
            }
            echo Json::encode(['output' => $out, 'selected'=>'']);
            return;
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }
    
    
    

    /**
     * Creates a new Campaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {    
        $model = new campaign();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh();
            Yii::$app->response->format = 'json';
            
            if(isset($_POST['classrooms'])){
                foreach ($_POST['classrooms'] as $cid){
                    if(!empty($cid )){
                        $classroom = \app\models\classroom::find($cid)->one();
                        /* @var $classroom \app\models\classroom */
                        $enrollments = $classroom->getEnrollments()->asArray()->all();
                        
                        foreach ($enrollments as $enrollment){
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
            
            return ['message' => Yii::t('app','Success Created!'), 'id'=>$model->id];
        } 
        return $this->renderAjax('create',['model'=>$model]);
    }

    /**
     * Updates an existing Campaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {    
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh();
            Yii::$app->response->format = 'json';
            return ['message' => Yii::t('app','Success Updated!'), 'id'=>$model->id];
        } 
        return $this->renderAjax('update',['model'=>$model]);
    }

    /**
     * Deletes an existing Campaign model.
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
     * Finds the Campaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Campaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Campaign::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
