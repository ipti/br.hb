<?php

namespace app\controllers;

use Yii;
use app\models\student;
use app\models\studentSearch;
use app\models\enrollment;
use app\models\address;
use app\models\campaign;
use app\models\term;
use app\models\classroom;
use app\models\school;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Html;

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
        $classrooms = classroom::find()->all();
        $schools = school::find()->all();

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

    //verifica se a campanha tem um período que engloba a data atual do sistema
    private function verifyCampaignInterval($begin, $end)
    {
        $dataAtual = date('Y-m-d');
        // Verifica se a data atual está dentro do intervalo
        if ($dataAtual >= $begin && $dataAtual <= $end) {
            return true;
        } else {
            return false;
        }
    }

    public function actionCreate()
    {
        $model = new student();
        $classrooms = classroom::find()->all();
        $schools = school::find()->all();
        $campaigns = campaign::find()->all();
        $modelEnrollment = new enrollment();
        $modelAddress = new address();
        $modelTerm = new term();
        $year = date("Y");
        $campaigns = campaign::find()->all();
        $campaigns = array_filter($campaigns, function ($c) {
            return $this->verifyCampaignInterval($c->begin, $c->end);
        });
        if ($model->load(Yii::$app->request->post())) {
            // convertendo o formato da data para o banco
            $model = $this->loadStudentUtil($model, Yii::$app->request->post());

            // carregando o model de endereço do aluno
            $modelAddress->state = Yii::$app->request->post()["state"];
            $modelAddress->city = Yii::$app->request->post()["city"];
            $modelAddress->neighborhood = Yii::$app->request->post()["neighborhood"];
            $modelAddress->street = Yii::$app->request->post()["street"];
            $modelAddress->number = Yii::$app->request->post()["number"];
            $modelAddress->complement = Yii::$app->request->post()["complement"];
            $modelAddress->postal_code = "49230000"; //cep de santa luzia

            if($modelAddress->save()) {
                $model->address = $modelAddress->id;
                if($model->save()) {
                    // verificando se o usuário selecionou alguma turma, se sim cria uma matrícula
                    if(Yii::$app->request->post()["classroom_enrollment"] != "") {
                        $modelEnrollment->student = $model->id;
                        $modelEnrollment->classroom = Yii::$app->request->post()["classroom_enrollment"];
                        if($modelEnrollment->save()) {
                            $modelTerm->enrollment = $modelEnrollment->id;
                            $modelTerm->campaign = Yii::$app->request->post()["campaign"];
                            $modelTerm->agreed = 0;
                            $modelTerm->save();
                        }
                    }
                    $this->setFlashMessage('success', 'Aluno cadastrado com sucesso');
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelEnrollment' => $modelEnrollment,
            'modelAddress' => $modelAddress,
            'modelTerm' => $modelTerm,
            'classrooms' => $classrooms,
            'schools' => $schools,
            'campaigns' => $campaigns
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelAddress = $this->findAddrees($model->address);
        $modelEnrollment = $this->findEnrollment($model->id);
        $modelTerm = $this->findTerm($modelEnrollment->id);

        if(!$modelEnrollment) {
            $modelEnrollment = new enrollment();
        }

        $classrooms = classroom::find()->all();
        $schools = school::find()->all();
        $campaigns = campaign::find()->all();
        if ($model->load(Yii::$app->request->post())) {
            // convertendo o formato da data para o banco
            $model = $this->loadStudentUtil($model, Yii::$app->request->post());
            // carregando o model de endereço do aluno
            $modelAddress->state = Yii::$app->request->post()["state"];
            $modelAddress->city = Yii::$app->request->post()["city"];
            $modelAddress->neighborhood = Yii::$app->request->post()["neighborhood"];
            $modelAddress->street = Yii::$app->request->post()["street"];
            $modelAddress->number = Yii::$app->request->post()["number"];
            $modelAddress->complement = Yii::$app->request->post()["complement"];
            $modelAddress->postal_code = "49230000"; //cep de santa luzia
            if($modelAddress->save() && $model->save()) {
                // verificando se o usuário selecionou alguma turma, se sim cria uma matrícula
                if(isset(Yii::$app->request->post()["classroom_enrollment"])) {
                    if(Yii::$app->request->post()["classroom_enrollment"] != "") {
                        $modelEnrollment = new enrollment();
                        $modelEnrollment->student = $model->id;
                        $modelEnrollment->classroom = Yii::$app->request->post()["classroom_enrollment"];
                        $modelEnrollment->save();
                    }
                }

                if(isset(Yii::$app->request->post()["campaign"])) {
                    if(Yii::$app->request->post()["campaign"] != "") {
                        $modelTerm = new term;
                        $modelTerm->enrollment = $modelEnrollment->id;
                        $modelTerm->campaign = Yii::$app->request->post()["campaign"];
                        $modelTerm->agreed = 0;
                        $modelTerm->save();
                    }
                }

                $this->setFlashMessage('success', 'Aluno salvo com sucesso');
                return $this->redirect(['index']);
            }
        }

        return $this->renderAjax('update', [
            'model' => $model,
            'modelAddress' => $modelAddress,
            'modelEnrollment' => $modelEnrollment,
            'modelTerm' => $modelTerm,
            'classrooms' => $classrooms,
            'schools' => $schools,
            'campaigns' => $campaigns
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

    public function actionDeleteEnrollment() {
        $enrollment_id = $_POST['enrollment'];
        $enrollment = enrollment::findOne($enrollment_id);
        if($enrollment->delete()) {
            echo "Matrícula deletada com sucesso";
        }else {
            throw new \yii\web\ServerErrorHttpException('Ocorreu um erro ao excluir a matrícula.');
        }
    }

    public function actionRemoveCampaignOfTerm() {
        $termId = $_POST["term"];
        $term = term::findOne($termId);
        if($term->delete()) {
            echo "Termo desvinculado com sucesso";
        }else {
            throw new \yii\web\ServerErrorHttpException('Ocorreu um erro ao desvincular o termo.');
        }
    }

    public function actionGetClassrooms()
    {
        $classrooms = classroom::findAll(["school" => $_POST["school_id"]]);
        echo Html::tag('option', "Selecione uma turma", ['value' => ""]);
        foreach($classrooms as $classroom) {
            echo Html::tag('option', Html::encode($classroom->name), ['value' => Html::encode($classroom->id)]);
        }
    }

    protected function findModel($id)
    {
        $model = Student::findOne($id);
        
        if (!$model) {
            return new student();
        }
        
        return $model;
    }

    protected function findAddrees($id)
    {
        $model = address::findOne($id);
        if (!$model) {
            return new address();
        }
        return $model;
    }

    protected function findEnrollment($id)
    {
        $model = enrollment::findOne(["student" => $id]);
        if (!$model) {
            return new enrollment();
        }
        return $model;
    }

    protected function findTerm($id)
    {
        $model = term::findOne(["enrollment" => $id]);
        if (!$model) {
            return new term();
        }
        return $model;
    }

    protected function setFlashMessage($type, $message)
    {
        Yii::$app->session->setFlash($type, $message);
    }

    private function loadStudentUtil($model, $post)
    {
        $model->responsible_1_name = $post['student']['responsible_1_name'];
        $model->responsible_1_telephone = $post['student']['responsible_1_telephone'];
        $model->responsible_1_kinship = intval($post['student']['responsible_1_kinship']);
        $model->responsible_1_email = $post['student']['responsible_1_email'];
        $model->responsible_2_name = $post['student']['responsible_2_name'];
        $model->responsible_2_telephone = $post['student']['responsible_2_telephone'];
        $model->responsible_2_kinship = intval($post['student']['responsible_2_kinship']);
        $model->responsible_2_email = $post['student']['responsible_2_email'];
        $model->allergy = intval($post['student']['allergy']);
        $model->allergy_text = $post['student']['allergy_text'];
        $model->anemia = intval($post['student']['anemia']);
        $model->anemia_text = $post['student']['anemia_text'];
        return $model;
    }
}