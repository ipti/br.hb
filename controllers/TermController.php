<?php

namespace app\controllers;

use Yii;
use app\models\term;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TermController implements the CRUD actions for term model.
 */
class TermController extends Controller
{
    public function behaviors()
    {
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
     * Lists all term models.
     * @return mixed
     */
    public function actionIndex($c)
    {
        $searchModel = new \app\models\enrollmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'campaign'=>$c,
        ]);
    }

    /**
     * Displays a single term model.
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
     * Creates a new term model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($c)
    {
        $model = new term();
        $model->campaign = $c;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->refresh();
            
            return $this->redirect(['index', 'c' => $c]);
        }
        return $this->renderAjax('create',['model'=>$model, "campaign"=>$c]);
    }
    
    public function actionAdd($eid){
        $model = new term();
        $model->enrollment = $eid;
        $model->agreed = 0;
        
        if (!$model->save()) {
            throw new Exception("Não salvo", "0001");
        }
    }
    
    public function actionUp($id){
        $model = $this->findModel($id);
        $model->agreed = $model->agreed == 0 ? 1 : 0;
        
        if (!$model->save()) {
            throw new Exception("Não atualizado", "0002");
        }
    }


    /**
     * Updates an existing term model.
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
            return ['message' => Yii::t('app','Success Update!'), 'id'=>$model->id];
        }
        return $this->renderAjax('update',['model'=>$model]);
    }

    /**
     * Deletes an existing term model.
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
     * Finds the term model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return term the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = term::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
