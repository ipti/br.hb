<?php


namespace app\controllers;


use app\models\school;
use app\models\classroom;
use app\models\student;
use app\models\enrollment;
use Yii;

class LoadForm extends \yii\base\Model
{
    public $items = [];

    public function rules()
    {
        return [];
    }
}

class LoadController extends \yii\web\Controller
{
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
    private function getEnrollmentsTAG($classroom){
        /** HB              TAG
         * enrollment  to   student_enrollment
         * id               null
         * student          student_fk
         * classroom        classroom_fk
         */
        $query = "select 'null' as id, student_fk as student, classroom_fk as classroom "
        . "from student_enrollment "



        ."join student_identification  on student_identification.id = student_enrollment.student_fk "
        . "where classroom_fk = " . $classroom;

        $result = Yii::$app->tag->createCommand($query);
        return $result->queryAll();
    }

    /**
     * Get a list with terms agreeded by classroom.
     * 
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
        $query = "select school_year from classroom";
        $result = Yii::$app->tag->createCommand($query);
        $years = $result->queryAll();
        $result = [];
        foreach($years as $year){
            $result[$year['school_year']] = $year['school_year'];
        }
        return $result;
    }

    public function actionIndex() {
        $schools = $this->getArraySchoolsTAG();
        $years = $this->getArrayYearsTAG();
        return $this->render('_form', ['schools' => $schools, 'years' => $years]);
    }

    /**
     * Get a list with consults attended by classroom.
     *
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
            $newClassroom = new classroom();
            $newClassroom->id = $classroom['id'];
            $newClassroom->fid = $classroom['fid'];
            $newClassroom->school = $classroom['school'];
            $newClassroom->name = $classroom['name'];
            $newClassroom->shift = $classroom['shift'];
            $newClassroom->year = $classroom['year'];
            $newClassroom->save();

            $response[$newClassroom->name] = $newClassroom->id;
            try {
                if (!is_null($newClassroom['fid'])) {
                    $enrollments = $this->getEnrollmentsTAG($newClassroom->fid);
                    foreach ($enrollments as $enrollment) {
                        $student = $this->getStudentsTAG($enrollment['student']);
        
                         $newStudent = new student();
                        $newStudent->id = $student['id'];
                        $newStudent->fid = $student['fid'];
                        $newStudent->name = $student['name'];
                        $newStudent->address = null;
                        $newStudent->birthday = $student['birthday'];
                        $newStudent->gender = $student['gender'];
                        $newStudent->mother = $student['mother'];
                        $newStudent->father = $student['father'];
            
                        $newStudent->save(); 
                $newStudent->save();
                        $newStudent->save(); 
                $newStudent->save();
                        $newStudent->save(); 
                $newStudent->save();
                        $newStudent->save(); 
                $newStudent->save();
                        $newStudent->save(); 
                $newStudent->save();
                        $newStudent->save(); 

                        echo "Student[" . $k++ . "]: " . $newStudent->name . " saved<br>";

                        $newEnrollment = new enrollment();
                        $newEnrollment->student = $newStudent->id;
                        $newEnrollment->classroom = $newClassroom->id;
                        $newEnrollment->save();

                        echo "Enrollment[" . $l++ . "]: " . $newEnrollment->id . " saved<br>";
                    }
                }
               
            } catch (\Exception $e) {
                VarDumper::dump($e->getTrace());
            }
        }
        set_time_limit(30);

        echo \yii\helpers\Json::encode($response);
        exit;
    }
}
