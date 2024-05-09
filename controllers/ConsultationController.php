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
class ConsultationController extends Controller {

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
     * Lists all consultation models.
     * @return mixed
     */
    public function actionIndex($c) {
        $campaign = \app\models\campaign::find()->where("id = :c1", ["c1" => $c])->one();
        $searchModel = new \app\models\enrollmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
		$dataProvider->pagination->pageSize=20;
		
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'campaign' => $c,
        ]);
    }

    /**
     * Displays a single consultation model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new consultation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cid) {
        $model = new consultation();
        $campaign = \app\models\campaign::find()->where("id = :c1", ["c1" => $cid])->one();

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
    public function actionUpdate($id) {
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
     * Updates an existing consultation model on Attended or Delivered attribute.
     * 
     * @param integer $t    Type, 1 = Attended; 2 = Delivered;
     * @param integer $id   Consultation ID
     * 
     */
    public function actionUp($t, $id) {
        $model = $this->findModel($id);

        if ($t == 1) {
            ($model->attended == 1) ? $model->attended = 0 : $model->attended = 1;
        } elseif ($t == 2) {
            ($model->delivered == 1) ? $model->delivered = 0 : $model->delivered = 1;
        }

        if (!$model->save()) {
            throw new Exception("Não atualizado", "0004");
        }
    }

    /**
     * Deletes an existing consultation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
    }

    /**
     * Finds the consultation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return consultation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = consultation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
