<?php

class ImportController extends Controller {

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
    
    public function actionFromTAG() {
        $schools = Yii::app()->db2->createCommand("SELECT inep_id as fid, `name` from school_identification;")->queryAll();
        $schools_address = Yii::app()->db2->createCommand("
            SELECT inep_id as school_id, uf.acronym as state, city.`name` as city, address_neighborhood as neighborhood, address as street, address_number as number, address_complement as complement, cep as postal_code from school_identification
                JOIN edcenso_uf as uf on uf.id = edcenso_uf_fk
                JOIN edcenso_city as city on city.id = edcenso_city_fk;")->queryAll();
        $classroom = Yii::app()->db2->createCommand("SELECT id as fid, `name`, IF(turn='M', 'morning',IF(turn='T','afternoom',IF(turn='N','night','day')))  as shift from classroom 
                WHERE school_year = DATE_FORMAT(NOW(),'%Y');")->queryAll();

        $enrollment = Yii::app()->db2->createCommand("SELECT student_fk as student, classroom_fk as classroom FROM student_enrollment;")->queryAll();

        $student = Yii::app()->db2->createCommand("SELECT id as fid, `name`, birthday,IF(sex=1, 'male','female') as gender, IF(mother_name IS NULL,father_name,mother_name) as responsible FROM TAG_SGE.student_identification;")->queryAll();
        $student_address = Yii::app()->db2->createCommand("
            SELECT sda.id as student_id, uf.acronym as state, city.`name` as city, neighborhood as neighborhood, address as street, number as number, complement as complement, cep as postal_code FROM TAG_SGE.student_documents_and_address as sda
                JOIN edcenso_uf as uf on uf.id = edcenso_uf_fk
                JOIN edcenso_city as city on city.id = edcenso_city_fk;")->queryAll();
        
        
        $this->render('fromTAG', array(
            'schools'=>$schools, 
            'schools_address'=>$schools_address, 
            'classroom'=>$classroom, 
            'enrollment'=>$enrollment, 
            'student'=>$student, 
            'student_address'=>$student_address)
        );
    }

    public function actionIndex() {
        $this->render('index');
    }

    /**
     * Salva no banco a Array de import vinda do $_POST, seguindo o modelo. 
     * É possível importar de qualquer banco que siga a mesma estrutura, apenas
     * necessário seguir a estrutura do banco do HB e preencher a matriz abaixo.
     * Uma vez preenchida e enviada para este método, todos os seus dados serão
     * salvos no banco de dados.
     * 
     * @param $_POST['import'] array Matriz que segue o modelo abaixo:
     * 
     * $_POST['import']
     * $_POST['import'][schoolID]['Info'] = new School
     * $_POST['import'][schoolID]['Address'] = new Address
     * $_POST['import'][schoolID]['Classrooms'][classroomID]['Info'] = new Classroom
     * $_POST['import'][schoolID]['Classrooms'][classroomID]['Students'][studentID]['Info'] = new Student
     * $_POST['import'][schoolID]['Classrooms'][classroomID]['Students'][studentID]['Address'] = new Address
     * 
     * @throws Exception
     */
    public function actionToHB() {
        $allokay = true;
        if (isset($_POST['import'])) {
            $import = json_decode($_POST['import'], true);
            foreach ($import as $schoolID => $school) {
                $schoolInfos = $school['Info'];
                $schoolAddress = $school['Address'];
                $classrooms = $school['Classrooms'];

                $s = new School();
                $s->attributes = $schoolInfos;
                $sa = new Address();
                $sa->attributes = $schoolAddress;
                if ($sa->validate()) {
                    $sa->save();
                    $s->address = $sa->id;
                    if ($s->validate()) {
                        $s->save();
                        foreach($classrooms as $classroomID => $classroom){
                            $classroomInfos = $classroom['Info'];
                            $students = $classroom['Students'];
                            $c = new Classroom();
                            $c->attributes = $classroomInfos;
                            $c->school = $s->id;
                            if ($c->validate()) {
                                $c->save();
                                foreach($students as $studentID => $student){
                                    $studentInfos = $student['Info'];
                                    $studentAddress = $student['Address'];
                                    $sta = new Address();
                                    $sta->attributes = $studentAddress;
                                    $st = new Student();
                                    $st->attributes = $studentInfos;
                                    $e = new Enrollment();
                                    $e->classroom = $c->id;
                                    if ($sta->validate()) {  
                                        $sta->save();
                                        $st->address = $sta->id;
                                        if($st->validate()){
                                            $st->save();
                                            $e->student = $st->id;
                                            if($e->validate()){
                                                $e->save();
                                                
                                            }else{$allokay &= false;}
                                        }else{$allokay &= false;}
                                    }else{$allokay &= false;}
                                }
                            }else{$allokay &= false;}
                        }
                    }else{$allokay &= false;}
                }else{$allokay &= false;}
            }
            
            if (!$allokay) {
                throw new Exception();
            }

        }
    }

}
