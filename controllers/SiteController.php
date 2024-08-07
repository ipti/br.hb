<?php

namespace app\controllers;

use app\models\campaign;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\helpers\VarDumper;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $year = Yii::$app->session->get('year');
        if(!isset($year)){
            $year = date("Y");
        }
        
        $date_end = $year . '-01-01';

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }

        $model = new campaign();
        $result = $model->getCampaignsResume($date_end);
        $campaigns = [];

        foreach ($result as $row) {
            $campaing['Name'] = $row['campaing_name'];
            $campaing['Id'] = $row['campaing_id'];
            $campaing['begin'] = $row['campaing_begin'];
            $campaing['end'] = $row['campaing_end'];


            $terms['Total'] = $row["terms_total"];
            $terms['Agreed'] = $row["terms_agreed"];
            $terms['UnAgreed'] = $terms['Total']-$terms['Agreed'];

            $anatomies['Total'] = $row["anatomy_total"];
            $anatomies['Updated'] = $row["anatomy_updated"];
            $anatomies['Unknown'] = $terms['Total']-$anatomies['Total'];
            $anatomies['OutOfDate'] = $terms['Total']-$anatomies['Updated']-$anatomies['Unknown'];

            $hb1['Total'] = $terms['Agreed'];
            $hb1['Done'] = $row['total_h1'];
            $hb1['UnDone'] = $hb1['Total'] - $hb1['Done'];

            $consults['Total'] =  $row['consultation_total'];
            $consults['Attended'] =  $row['consultation_attended'];
            $consults['NotAttended'] = $consults['Total']-$consults['Attended'];

            $hb2['Total'] = $consults['Attended'];
            $hb2['Done'] = $row['total_h2'];
            $hb2['UnDone'] = $hb2['Total'] - $hb2['Done'];

            $hb3['Total'] = $consults['Attended'];
            $hb3['Done'] = $row['total_h3'];
            $hb3['UnDone'] = $hb3['Total'] - $hb3['Done'];

            $ferritin['Total'] = $terms['Agreed'];
            $ferritin['Done'] = $row['total_ferritin'];
            $ferritin['UnDone'] = $ferritin['Total'] - $ferritin['Done'];

            array_push($campaigns, [
                'campaing' => $campaing,
                'terms' =>  $terms,
                'anatomies' => $anatomies,
                'hb1' => $hb1,
                'consults' => $consults,
                'hb2' => $hb2,
                'hb3' => $hb3,
                'ferritin' => $ferritin,
            ]);
        }

        return $this->render('index', ['campaigns' => $campaigns, 'year' => $year]);
    }

    public function actionLogin()
    {
      
        $this->layout = "login";

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        
      

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
    
    public function actionChangeYear()
    {
        Yii::$app->session->set("year", Yii::$app->request->post("year"));

        return json_encode(array('success' => 0));
    }
}
