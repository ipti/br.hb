<?php

class HemoglobinController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'GetSampleByStudent'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Hemoglobin;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Hemoglobin'])) {
            $model->attributes = $_POST['Hemoglobin'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Hemoglobin'])) {
            $model->attributes = $_POST['Hemoglobin'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Hemoglobin');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Hemoglobin('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Hemoglobin']))
            $model->attributes = $_GET['Hemoglobin'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionGetSampleByStudent($id = null) {
        $model = new Hemoglobin();
        if (isset($_POST['Hemoglobin'])) {
            $model->attributes = $_POST['Hemoglobin'];
        } else {
            if($id != null){
                $model = $this->loadModel($id);
            }else{
                throw new HttpRequestException;
            }
        }

        $hemoglobins = $model->agreedTerm->hemoglobins;
        $has = array(1 => false, 2 => false, 3 => false);

        foreach ($hemoglobins as $hb) {
            $has[$hb->sample] = true;
        }
        $consultations = $model->agreedTerm->studentFK->consultations;
        $consultation = null;
        if (count($consultations) > 0)
            $consultation = $consultations[count($consultations) - 1];
        $consult = $consultation != null && $consultation->attended;

        $done = yii::t('default', 'done');
        $todo = yii::t('default', 'to do');
        $miss = yii::t('default', 'missed');
        
        $opt = ($has[1]) ? 'disabled=disabled' : '';
        $msg = ($has[1]) ? $done : $todo;
        echo '<option value="1" ' . $opt . '>1 - ' . $msg . '</option>';

        $opt = ($has[2] || $has[3] || !$consult) ? 'disabled=disabled' : '';
        $msg = ($has[2]) ? $done : (($has[3]) ? $miss : $todo );
        echo '<option value="2" ' . $opt . '>2 - ' . $msg . '</option>';

        $opt = ($has[3] || !$consult) ? 'disabled=disabled' : '';
        $msg = ($has[3]) ? $done : $todo;
        echo '<option value="3" ' . $opt . '>3 - ' . $msg . '</option>';
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Hemoglobin the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Hemoglobin::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Hemoglobin $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'hemoglobin-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function beforeAction($action) {
        //$action = new CAction();
        if (parent::beforeAction($action)) {
            /* @var $cs CClientScript */
            $cs = Yii::app()->clientScript;
            
            if ($action->getId() == 'create') {
                $cs->registerScript('triggers', ''
                        . '$("#Hemoglobin_agreed_term").trigger("change");'
                        , CClientScript::POS_LOAD);
            }
            
            if ($action->getId() == 'update') {
                $model = $this->loadModel($_GET['id']);
                $cs->registerScript('triggers', " 
                        $.ajax({
                            'type':'POST',
                            'url':'/index.php?r=hemoglobin/getSampleByStudent&id=".$_GET['id']."',
                            'success':function(html){
                                $('#Hemoglobin_agreed_term option:not(:selected)').attr('disabled',true);
                                $('#Hemoglobin_sample').html(html);
                                $('#Hemoglobin_sample [value=".$model->sample."]').attr('disabled',false);
                                $('#Hemoglobin_sample [value=".$model->sample."]').attr('selected',true);
                            }
                        });"
                        , CClientScript::POS_LOAD);
            }

            return true;
        }
        return false;
    }

}
