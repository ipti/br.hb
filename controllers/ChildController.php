<?php

namespace app\controllers;

use Yii;
use app\models\student;
use app\models\studentSearch;
use app\models\enrollment;
use app\models\enrollmentSearch;
use app\models\classroom;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ChildController extends Controller
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
     * Lists all student models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new studentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single student model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new student();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setFlashMessage('success', 'Aluno cadastrado com sucesso');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->setFlashMessage('success', 'Aluno salvo com sucesso');
            return $this->redirect(['index']);
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            $this->setFlashMessage('success', 'Aluno excluído com sucesso');
            return $this->redirect(['index']);
        }

        throw new \yii\web\ServerErrorHttpException('Ocorreu um erro ao excluir o estudante.');
    }

    protected function findModel($id)
    {
        $model = Student::findOne($id);
        
        if (!$model) {
            throw new NotFoundHttpException('O estudante não foi encontrado.');
        }
        
        return $model;
    }

    protected function setFlashMessage($type, $message)
    {
        Yii::$app->session->setFlash($type, $message);
    }
}