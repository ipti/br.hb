<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper; 

/**
 * This is the model class for table "campaign".
 *
 * @property integer $id
 * @property integer $coordinator
 * @property string $name
 * @property string $begin
 * @property string $end
 *
 * @property PersonUser $coordinator0
 * @property CampaignHasDriver[] $campaignHasDrivers
 * @property PersonDriver[] $drivers
 * @property CampaignHasSchool[] $campaignHasSchools
 * @property School[] $schools
 * @property CampaignHasVehicle[] $campaignHasVehicles
 * @property Vehicle[] $vehicles
 * @property Event[] $events
 * @property Route[] $routes
 * @property Stock[] $stocks
 * @property Team[] $teams
 * @property Term[] $terms
 */
class campaign extends \yii\db\ActiveRecord {

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
            //['begin', 'date', 'format' => 'php:Y-m-d', 'timestampAttribute' => 'begin'],
            //['begin', 'compare', 'type' => 'string', 'compareValue' => date("Y-m-d"), 'operator' => '>',
            //    'message'=>'{value} must be greater than {compareValue}.'],
            [['name'], 'string', 'max' => 20]
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
        return $this->hasOne(personUser::className(), ['id' => 'coordinator']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignHasDrivers() {
        return $this->hasMany(campaignHasDriver::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers() {
        return $this->hasMany(personDriver::className(), ['id' => 'driver'])->viaTable('campaign_has_driver', ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignHasVehicles() {
        return $this->hasMany(campaignHasVehicle::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles() {
        return $this->hasMany(vehicle::className(), ['id' => 'vehicle'])->viaTable('campaign_has_vehicle', ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents() {
        return $this->hasMany(event::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes() {
        return $this->hasMany(route::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks() {
        return $this->hasMany(stock::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams() {
        return $this->hasMany(team::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms() {
        return $this->hasMany(term::className(), ['campaign' => 'id']);
    }
    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents() {
        return $this->hasMany(student::className(), ['id' => 'student'])
                        ->via('enrollments');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollments() {
        return $this->hasMany(enrollment::className(), ['id' => 'enrollment'])
                        ->via('terms');
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollmentsWithoutTerms() {

        $query = <<<EOT
        SELECT e.id, name as `students.name`  FROM enrollment e 
            JOIN student s on e.student = s.id 
            WHERE (not exists (select * from term as t where e.id = t.enrollment))
        EOT;

        $result = Yii::$app->db->createCommand($query)->queryAll();
        // Yii::error($result);
        return $result;
 
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassrooms() {
        return $this->hasMany(classroom::className(), ['id' => 'classroom'])
                        ->via('enrollments');
    }
    
    /**
     * @return array
     */
    public function getClassroomsWithAgreedTerms() {
        /* @var $term \app\models\term*/
        $terms = $this->getTerms()->where("agreed")->all();
        
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
        $consults = $this->getConsults()->where("attended")->all();
        
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
        return $this->hasMany(school::className(), ['id' => 'school'])
                ->via('classrooms');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentsAnatomies() {
        $anatomies = $this->hasMany(anatomy::className(), ['student' => 'id'])
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
        return $this->hasMany(hemoglobin::className(), ['agreed_term'=>'id'])
                ->via('terms')->groupBy('agreed_term');
    }

    /**
     * @return \yii\db\ActiveQuery  
     */
    public function getFerritin(){   
        return $this->hasMany(ferritin::className(), ['agreed_term'=>'id'])
                ->via('terms')->groupBy('agreed_term');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHemoglobinsWithoutConsult(){
        return $this->hasMany(hemoglobin::className(), ['agreed_term'=>'id'])
                ->via('terms')
                ->where("sample = 1 and not exists (select * from consultation as c where agreed_term = c.term)");
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsults(){
        return $this->hasMany(consultation::className(), ['term'=>'id'])
                ->via('terms');
    }
    
}
