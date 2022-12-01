<?php

namespace app\controllers;

use Yii;
use app\models\Ferritin;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\consultation;
use mPDF;

/**
 * FerritinController implements the CRUD actions for hemoglobin model.
 */
class FerritinController extends Controller
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
     * Lists all  models.
     * @return mixed
     */
    public function actionIndex($c)
    {
        $campaign = \app\models\campaign::find()->where("id = :c1", ["c1" => $c])->one();
        $q = $campaign->getFerritin()
            ->innerJoin('term', 'agreed_term = term.id')
            ->innerJoin('enrollment as en', 'term.enrollment = en.id')
            ->innerJoin('student as s', 's.id = en.student')
            ->orderBy('s.name ASC');

        $dataProvider = new ActiveDataProvider([
            'query' => $q
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'campaign' => $campaign,
        ]);
    }
    public function actionCreate($cid) {
        if (Yii::$app->request->post() != null) {  
            return $this->redirect(['index', 'c' => $cid]);
        } else {
            $model = new Ferritinw();
            $campaign = \app\models\campaign::find()->where("id=:id", ['id' => $cid])->one();

            return $this->render('create', [
                        'model' => $model,
                        'campaign' => $campaign,
            ]);
        }
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        return $this->redirect(['index', 'c' => $model->agreedTerm->campaigns->id]);
    }
}
