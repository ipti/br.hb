<?php


namespace app\controllers;


use app\models\school;
use app\models\classroom;
use app\models\student;
use app\models\enrollment;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class LoadController extends Controller
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

    /**
     * Get Schools by school from TAG
     * 
     * @param string $inep
     * @return array
     */
    private function getSchoolTAG($inep){
        /** HB              TAG
         * school       to  school_identification
         * id               inep_id
         * fid              inep_id
         * name             name
         * phone            phone_number
         * address          1
         * principal        null
         */
        $query = "select inep_id as id, inep_id as fid, name, phone_number as phone, 1 as address "
            . "from school_identification "
            . "where inep_id = ".$inep;
        $result = Yii::$app->tag->createCommand($query);
        return $result->queryAll();

    } 

    /**
     * Get classrooms by school from TAG
     * 
     * @param string $school
     * @return array
     */
    private function getClassroomsTAG($school,$year)
    {
        /** HB              TAG
         * classroom  to    classroom
         * id               id
         * fid              id
         * school           school_inep_fk
         * name             name
         * shift            turn 
         * year             school_year
         */
        $query = "select 'null' as id, id as fid, `name`, school_inep_fk as school,
		if(turn = 'M', 'morning', if(turn = 'T', 'afternoon', if(turn = 'N', 'night','day' ))) as shift,
		school_year as `year` "
            . "from classroom "
            . "where school_inep_fk = " . $school . " "
            . "and school_year = " . $year;
        $result = Yii::$app->tag->createCommand($query);
        return $result->queryAll();
    }

    /**
     * Get Students by school from TAG
     * 
     * @param string $school
     * @return array
     */
    private function getStudentsTAG($id){
        /** HB              TAG
         * student  to  student_identification
         * id           id
         * fid          id
         * name         name
         * address      null
         * birthday     birthday
         * gender       gender if(1, 'male', 'female')
         * mother       mother_name
         * father       father_name
         * 
         */
        $query = "select 'null' as id, id as fid, `name`, 'null' as address, str_to_date(birthday, '%d/%m/%Y') as birthday, 
		if(sex = 1, 'male', 'female') as gender, 
		filiation_1 as mother, filiation_2 as father "
            . "from student_identification "
            . "where id = " . $id;
        $result = Yii::$app->tag->createCommand($query);
        return $result->queryOne();
    }

    /**
     * Get Enrollments by school from TAG
     * 
     * @param string $school
     * @return array
     */
    private function getEnrollmentsTAG($classroom, $year){
        /** HB              TAG
         * enrollment  to   student_enrollment
         * id               null
         * student          student_fk
         * classroom        classroom_fk
         */
        $query = "select 'null' as id, student_enrollment.student_fk as student, student_enrollment.classroom_fk as classroom "
        . "from student_enrollment "
        ."join student_identification  on student_identification.id = student_enrollment.student_fk "
        ."join classroom on classroom.id =  student_enrollment.classroom_fk "
        . "where classroom.id = " . $classroom . " and classroom.school_year = ".$year." and (student_enrollment.status = 1 or student_enrollment.status is null)";

        $result = Yii::$app->tag->createCommand($query);
        return $result->queryAll();
    }

    /**
     * Get a classrooms.
     * 
     * @param integer $clid
     * @param integer $cid
     * @return json
     */
    public function actionGetClassrooms($clid, $cid)
    {
        $classrooms = $this->getClassroomsTAG($clid, $cid);

        $response = [];
        foreach ($classrooms as $class) {
            $response[$class['name']] = $class['year'];
        }

        echo \yii\helpers\Json::encode($response);
        exit;
    }

    /**
     * @return array
     */
    public function getArraySchoolsTAG() {
        $query = "select * from school_identification";
        $result = Yii::$app->tag->createCommand($query);
        $schools = $result->queryAll();
        $result = [];
        foreach($schools as $school){
            $result[$school['inep_id']] = $school['name'];
        }
        return $result;
    }
    
    /**
     * @return array
     */
    public function getArrayYearsTAG() {
        $query = "select school_year from classroom order by school_year desc";
        $result = Yii::$app->tag->createCommand($query);
        $years = $result->queryAll();
        $result = [];
        foreach($years as $year){
            $result[$year['school_year']] = $year['school_year'];
        }
        return $result;
    }

    public function actionIndex() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $schools = $this->getArraySchoolsTAG();
        $years = $this->getArrayYearsTAG();
        return $this->render('_form', ['schools' => $schools, 'years' => $years]);
    }

    /**
     * Import TAG data
     * @param integer $clid
     * @param integer $cid
     * @return json
     */
    public function actionTag($clid, $cid) {
        set_time_limit(0);
        
        $schools = $this->getSchoolTAG($clid);
        $classrooms = $this->getClassroomsTAG($clid, $cid);

        $response = [];

        $i = $j = $k = $l = 0;
        foreach ($schools as $school){
            $newSchool = school::find()->where('id = :id', ['id' => $school['id']])->one();
            if(!isset($newSchool)){
                $newSchool = new school();
            }
            $newSchool->id = $school['id'];
            $newSchool->fid = $school['fid'];
            $newSchool->name = $school['name'];
            $newSchool->phone = $school['phone'];
            $newSchool->address = 1;
            $newSchool->save();

            $response[$newSchool->name] = $newSchool->fid;
        }

        foreach ($classrooms as $classroom) {
            $classroomModel = classroom::find(['fid' => $classroom['fid']]);
            if(!isset($classroomModel)) {
                $classroomModel = new classroom();
            }
            $classroomModel->id = $classroom['id'];
            $classroomModel->fid = $classroom['fid'];
            $classroomModel->school = $classroom['school'];
            $classroomModel->name = $classroom['name'];
            $classroomModel->shift = $classroom['shift'];
            $classroomModel->year = $classroom['year'];
            $classroomModel->save();
            $response[$newClassroom->name] = $newClassroom->id;
            if ($newClassroom['fid'] != null) {
                $enrollments = $this->getEnrollmentsTAG($newClassroom->fid, $cid);
                foreach ($enrollments as $enrollment) {
                    $student = $this->getStudentsTAG($enrollment['student']);

                    $studentModel = student::find(['fid' => $student['fid']]);
                    if(!isset($studentModel)) {
                        $studentModel = new student();
                        $studentModel->id = $student['id'];
                        $studentModel->fid = $student['fid'];
                        $studentModel->name = $student['name'];
                        $studentModel->address = 1;
                        $studentModel->birthday = $student['birthday'];
                        $studentModel->gender = $student['gender'];
                        $studentModel->mother = $student['mother'];
                        $studentModel->father = $student['father'];
                        
                        $studentModel->save();
                    }

                    $enrollmentModel = enrollment::find(['student' => $studentModel->id, 'classroom' => $classroomModel->id]);
                    if(!isset($enrollmentModel)) {
                        $newEnrollment = new enrollment();
                        $newEnrollment->student = $studentModel->id;
                        $newEnrollment->classroom = $classroomModel->id;
                        $newEnrollment->save();
                    }
                }  
            }
        }
        set_time_limit(30);

        echo \yii\helpers\Json::encode($response);
        exit;
    }
}
