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
     * Get a list with terms agreeded by classroom.
     * 
     * @param integer $cid
     * @return json
     */
    public function actionGetAgreedTerms($clid, $cid,$samp) {
        /* @var $classroom \app\models\classroom */
        /* @var $term \app\models\term */
        $classroom = \app\models\classroom::find()->where("id = :clid",["clid"=>$clid])->one();
        $terms = $classroom->getTerms()->where("agreed = true and campaign = :cid", ['cid'=>$cid])->all();
        
        $response = [];
        foreach($terms as $term){
            $hbs = $term->getHemoglobins()->where("sample = :samp",["samp"=>$samp])->count();
            if($hbs == 0)
                $response[$term->enrollments->students->name] = $term->id;
        }
        
        echo \yii\helpers\Json::encode($response);
        exit;
    }
    /**
     * Get a list with consults attended by classroom.
     * 
     * @param integer $cid
     * @return json
     */
    public function actionGetAttendedConsults($clid, $cid,$samp) {
        /* @var $classroom \app\models\classroom */
        /* @var $consult \app\models\consultation */
        $classroom = \app\models\classroom::find()->where("id = :clid",["clid"=>$clid])->one();
        $consults = $classroom->getConsults()->where("attended = true and campaign = :cid", ['cid'=>$cid])->all();
        
        $response = [];
        foreach($consults as $consult){
            $response[$consult->terms->enrollments->students->name] = $consult->terms->id;
        }
        echo \yii\helpers\Json::encode($response);
        exit;
    }
    /**
     * Creates a new hemoglobin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($cid, $s)
    {
        if(Yii::$app->request->post() != null){
            $clid = Yii::$app->request->post()['classroom'];
            $hemoglobins = Yii::$app->request->post()['hemoglobin'];
            $sample = $s;
            foreach($hemoglobins as $term => $rate){
                $model = new hemoglobin();
                if(!empty($rate)){
                    $model->agreed_term = $term;
                    $model->rate = $rate;
                    $model->sample = $sample;
                    $model->save();
                }
            }
            return $this->redirect(['index', 'c' => $cid, 's'=>$s]);
        } else {
            $model = new hemoglobin();
            $campaign = \app\models\campaign::find()->where("id=:id",['id'=>$cid])->one();
            
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
            return $this->redirect(['index', 'c' => $model->agreedTerm->campaigns->id, 's' => $model->sample]);
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
