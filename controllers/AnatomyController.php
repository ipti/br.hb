<?php

namespace app\controllers;

use Yii;
use app\models\anatomy;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AnatomyController implements the CRUD actions for anatomy model.
 */
class AnatomyController extends Controller
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
     * Lists all anatomy models.
     * @return mixed
     */
    public function actionIndex($cid)
    {
        
        $campaign = \app\models\campaign::find()->where("id = :c1",["c1"=>$cid])->one();
        $searchModel = new \app\models\enrollmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'campaign'=>$campaign,
        ]);
    }

    /**
     * Displays a single anatomy model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($cid)
    {
        return $this->render('view', [
            'model' => $this->findModel($cid),
        ]);
    }

    /**
     * Creates a new anatomy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cid)
    {
        $model = new anatomy();
        $campaign = \app\models\campaign::find()->where("id=:id",['id'=>$cid])->one();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh();
            
            return $this->redirect(['index', 'cid' => $cid]);
        }
        return $this->renderAjax('create',['model'=>$model,'campaign'=>$campaign]);
    }

    /**
     * Updates an existing anatomy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($cid)
    {
        $model = $this->findModel($cid);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh();
            
            return $this->redirect(['index', 'cid' => $cid]);
        }
        return $this->renderAjax('create',['model'=>$model,'campaign'=>$campaign]);
    }

    /**
     * Deletes an existing anatomy model.
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
     * Finds the anatomy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return anatomy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = anatomy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
}
