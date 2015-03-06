<?php

namespace app\controllers;

class ReportsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLetter()
    {
        return $this->render('letter');
    }

    public function actionPrescription()
    {
        return $this->render('prescription');
    }

    public function actionTerms()
    {
        return $this->render('terms');
    }

    public function actionAnamnese()
    {
        return $this->render('anamnese');
    }

}
