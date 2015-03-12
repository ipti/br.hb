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
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
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
