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
class Campaign extends \yii\db\ActiveRecord {

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
            ['begin', \yii\validators\CompareValidator::className(),
                'type' => 'string', 
                'compareValue'=>Yii::$app->formatter->asDate('now', 'yyyy-MM-dd'),
                'operator' => '>',
                'message'=>'{value} must be greater than {compareValue}.'],
//            ['begin', 
//                'compare', 
//                'type'=>'string',
//                'compareValue'=>date("Y-m-j"),
//                'operator'=>'>',
//                //'message'=>'{value} must be greater than {compareValue}.'
//                ],
//            ['end', 'compare', 'compareAttribute'=>'begin','operator'=>'>','message'=>'{value} must be greater than {compareValue}.'],
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
        return $this->hasOne(PersonUser::className(), ['id' => 'coordinator']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignHasDrivers() {
        return $this->hasMany(CampaignHasDriver::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers() {
        return $this->hasMany(PersonDriver::className(), ['id' => 'driver'])->viaTable('campaign_has_driver', ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignHasSchools() {
        return $this->hasMany(CampaignHasSchool::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchools() {
        return $this->hasMany(School::className(), ['id' => 'school'])->viaTable('campaign_has_school', ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignHasVehicles() {
        return $this->hasMany(CampaignHasVehicle::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles() {
        return $this->hasMany(Vehicle::className(), ['id' => 'vehicle'])->viaTable('campaign_has_vehicle', ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents() {
        return $this->hasMany(Event::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes() {
        return $this->hasMany(Route::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks() {
        return $this->hasMany(Stock::className(), ['campaign' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeams() {
        return $this->hasMany(Team::className(), ['campaign' => 'id']);
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
                        ->via('terms');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentsAnatomies() {
        return $this->hasMany(anatomy::className(), ['student' => 'id'])
                        ->via('students');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHemoglobins(){
        return $this->hasMany(hemoglobin::className(), ['id'=>'agreed'])
                ->via('terms');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsults(){
        return $this->hasMany(consultation::className(), ['term'=>'id'])
                ->via('terms');
    }
    
}
