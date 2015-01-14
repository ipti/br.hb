<?php

namespace app\controllers;

use Yii;
use app\models\enrollment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnrollmentController implements the CRUD actions for enrollment model.
 */
class EnrollmentController extends Controller
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
     * Lists all enrollment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => enrollment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single enrollment model.
     * @param integer $student
     * @param integer $classroom
     * @return mixed
     */
    public function actionView($student, $classroom)
    {
        return $this->render('view', [
            'model' => $this->findModel($student, $classroom),
        ]);
    }

    /**
     * Creates a new enrollment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new enrollment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'student' => $model->student, 'classroom' => $model->classroom]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing enrollment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $student
     * @param integer $classroom
     * @return mixed
     */
    public function actionUpdate($student, $classroom)
    {
        $model = $this->findModel($student, $classroom);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'student' => $model->student, 'classroom' => $model->classroom]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing enrollment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $student
     * @param integer $classroom
     * @return mixed
     */
    public function actionDelete($student, $classroom)
    {
        $this->findModel($student, $classroom)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the enrollment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $student
     * @param integer $classroom
     * @return enrollment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($student, $classroom)
    {
        if (($model = enrollment::findOne(['student' => $student, 'classroom' => $classroom])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
