<?php

class ImportController extends Controller
{    
    
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array(),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('fromtag', 'tohb'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

	public function actionFromTAG()
	{
		$this->render('fromTAG');
	}

	public function actionIndex()
	{
		$this->render('index');
	}
        
        public function actionToHB(){
            if(isset($_POST['import'])){
                $import = json_decode($_POST['import'],true);
                foreach ($import as $schoolID => $school){
                    $schoolInfos = $school['Info'];
                    $schoolAddress = $school['Address'];
                    
                    $s = new School();
                    $s->attributes = $schoolInfos;
                    
                    $sa = new Address();
                    $sa->attributes = $schoolAddress;
                    if($sa->validate()){
                        $sa->save();
                        $s->address = $sa->id;
                        var_dump($s->attributes);
                        if($s->validate()){
                            $s->save();
                            
                            
                            /*
                             * Continua no próximo episódio!
                             * Onde veremos as turmas serem cadastradas, junto 
                             * com as matrículas, seus respectivos alunos e endereços.
                             * 
                             * Até mais amigos! \o
                             */
                            
                            
                            $s->delete();
                        }
                        $sa->delete();
                    }
                    
                }
                //var_dump($import);
                    //import[schoolID]['Address']
                    //import[schoolID][classroomID][studentID]['Info']
                    //import[schoolID][classroomID][studentID]['Address'] 
            }
        }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}