<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "campaign".
 *
 * @property integer $id
 * @property integer $coordinator
 * @property string $name
 * @property string $begin
 * @property string $end
 *
 * @property School[] $schools
 * @property Term[] $terms
 */
class campaign extends \yii\db\ActiveRecord {

    public $countTerms = 0;
    public $countTermsAccepted = 0;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['coordinator'], 'integer'],
            [['name', 'begin', 'end'], 'required'],
            [['begin', 'end'], 'safe'],
            [['begin', 'end'], 'string'],
            [['name'], 'string', 'max' => 20],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'coordinator' => Yii::t('app', 'Coordinator'),
            'name' => Yii::t('app', 'Name'),
            'begin' => Yii::t('app', 'Begin'),
            'end' => Yii::t('app', 'End'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCoordinator0() {
        return $this->hasOne(personUser::class, ['id' => 'coordinator']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignHasDrivers() {
        return $this->hasMany(campaignHasDriver::class, ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers() {
        return $this->hasMany(personDriver::class, ['id' => 'driver'])->viaTable('campaign_has_driver', ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignHasVehicles() {
        return $this->hasMany(campaignHasVehicle::class, ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles() {
        return $this->hasMany(vehicle::class, ['id' => 'vehicle'])->viaTable('campaign_has_vehicle', ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents() {
        return $this->hasMany(event::class, ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes() {
        return $this->hasMany(route::class, ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks() {
        return $this->hasMany(stock::class, ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams() {
        return $this->hasMany(team::class, ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms() {
        return $this->hasMany(term::class, ['campaign' => 'id']);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents() {
        return $this->hasMany(student::class, ['id' => 'student'])
                        ->via('enrollments');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollments() {
        return $this->hasMany(enrollment::class, ['id' => 'enrollment'])
                        ->via('terms');
    }
    /**
     * @return []
     */
    public function getEnrollmentsWithoutTerms() {

        $query = "
        SELECT e.id, name as `students.name`  FROM enrollment e 
            JOIN student s on e.student = s.id 
            WHERE (not exists (select * from term as t where e.id = t.enrollment))";

        $result = Yii::$app->db->createCommand($query)->queryAll();
                
        return $result;
 
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassrooms() {
        return $this->hasMany(classroom::class, ['id' => 'classroom'])
                        ->via('enrollments');
    }
    
    /**
     * @return array
     */
    public function getClassroomsWithAgreedTerms() {

        $terms = $this->getTerms()->with('enrollments.classrooms')->where("agreed")->all();        
        
        $result = [];                
        
        foreach($terms as $term){
            $result[$term->enrollments->classrooms->id] = $term->enrollments->classrooms->name;
        }
        
        return $result;
    }    
    /**
     * @return array
     */
    public function getClassroomsWithAttendedConsults() {
        /* @var $consult \app\models\consult*/
        $consults = $this->getConsults()->with('terms.enrollments.classrooms')->where("attended")->all();
        
        $result = [];
        foreach($consults as $consult){
            $result[$consult->terms->enrollments->classrooms->id] = $consult->terms->enrollments->classrooms->name;
        }
        return $result;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchools() {
        return $this->hasMany(school::class, ['id' => 'school'])
                ->via('classrooms');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentsAnatomies() {
        $anatomies = $this->hasMany(anatomy::class, ['student' => 'id'])
                ->via('students')
                ->from(['(SELECT * from anatomy order by date DESC, id DESC) as anatomy'])
                ->select('anatomy.*')
                ->groupBy('student');
        return $anatomies;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHemoglobins(){   
        return $this->hasMany(hemoglobin::class, ['agreed_term'=>'id'])
                ->via('terms')->groupBy('agreed_term');
    }

    /**
     * @return \yii\db\ActiveQuery  
     */
    public function getFerritin(){   
        return $this->hasMany(ferritin::class, ['agreed_term'=>'id'])
                ->via('terms')->groupBy('agreed_term');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHemoglobinsWithoutConsult(){
        return $this->hasMany(hemoglobin::class, ['agreed_term'=>'id'])
                ->via('terms')
                ->where("sample = 1 and not exists (select * from consultation as c where agreed_term = c.term)");
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsults(){
        return $this->hasMany(consultation::class, ['term'=>'id'])
                
                ->via('terms');
    }

    public function getCampaignsResume(){
        $result = Yii::$app->db->createCommand("
        SELECT 
            c.name as campaing_name,
            c.id as campaing_id,
            c.begin as campaing_begin,
            c.end as campaing_end,
            COUNT(t.id) AS terms_total,
            SUM(IF(t.agreed = 1, 1, 0)) AS terms_agreed,
            sum((select count(1) from hemoglobin h1 where h1.agreed_term = t.id AND h1.sample = 1)) as total_h1,
            sum((select count(1) from hemoglobin h2 where h2.agreed_term = t.id AND h2.sample = 2)) as total_h2,
            sum((select count(1) from hemoglobin h3 where h3.agreed_term = t.id AND h3.sample = 3)) as total_h3,
            sum((select count(1) from ferritin fer where fer.agreed_term = t.id)) as total_ferritin,
            sum((select count(1) from consultation c2 where c2.term = t.id)) as consultation_total,
            sum((select count(1) from consultation c2 where c2.term = t.id and c2.attended = 1)) as consultation_attended,
            sum((SELECT count(1) from anatomy a2 WHERE a2.student = s.id GROUP by a2.student)) as anatomy_total,
            sum((SELECT count(1) from anatomy a2 WHERE a2.student = s.id and a2.`date` >= c.`begin` GROUP by a2.student)) as anatomy_updated
        FROM campaign c 
            left join term t on t.campaign = c.id 
            left join enrollment e on e.id = t.enrollment
            left join student s on s.id = e.student
            left join hemoglobin h1 on h1.agreed_term = t.id AND  h1.sample = 1
            left join hemoglobin h2 on h2.agreed_term = t.id AND  h1.sample = 2
            left join hemoglobin h3 on h3.agreed_term = t.id AND  h1.sample = 3
            left join ferritin fer on fer.agreed_term = t.id
        group by c.id
        order by c.end desc
        ")->queryAll();

        return $result;
    }
    
}
