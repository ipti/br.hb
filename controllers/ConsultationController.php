<?php

namespace app\controllers;

use Yii;
use app\models\consultation;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConsultationController implements the CRUD actions for consultation model.
 */
class ConsultationController extends Controller
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
     * Lists all consultation models.
     * @return mixed
     */
    public function actionIndex($c)
    {
        if($c == null){
            $q = consultation::find();
        }else{
            $campaign = \app\models\campaign::find()->where("id = :c1",["c1"=>$c])->one();
            $q = $campaign->getConsults();
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $q
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'campaign' => $campaign, 
       ]);
    }

    /**
     * Displays a single consultation model.
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
     * Creates a new consultation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cid)
    {
        $model = new consultation();
        $campaign = \app\models\campaign::find()->where("id = :c1",["c1"=>$cid])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id, 'c' => $cid]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'campaign' => $campaign,
            ]);
        }
    }

    /**
     * Updates an existing consultation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing consultation model.
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
     * Finds the consultation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return consultation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = consultation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
