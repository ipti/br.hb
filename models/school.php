<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school".
 *
 * @property integer $id
 * @property string $fid
 * @property string $name
 * @property string $phone
 * @property integer $address
 * @property integer $principal
 *
 * @property CampaignHasSchool[] $campaignHasSchools
 * @property Campaign[] $campaigns
 * @property Classroom[] $classrooms
 * @property Address $address0
 * @property PersonExternal $principal0
 * @property SchoolHasEvent[] $schoolHasEvents
 * @property Event[] $events
 */
class school extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'school';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'required'],
            [['address', 'principal'], 'integer'],
            [['fid'], 'string', 'max' => 45],
            [['name'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fid' => Yii::t('app', 'Fid'),
            'name' => Yii::t('app', 'Name'),
            'phone' => Yii::t('app', 'Phone'),
            'address' => Yii::t('app', 'Address'),
            'principal' => Yii::t('app', 'Principal'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassrooms()
    {
        return $this->hasMany(classroom::class, ['school' => 'id'])->orderBy('name asc');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollments()
    {
        return $this->hasMany(enrollment::class, ['classroom' => 'id'])
            ->via("classrooms");
    } 
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this->hasMany(term::class, ['enrollment' => 'id'])
            ->via("enrollments");
    } 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasOne(address::class, ['id' => 'address']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrincipals()
    {
        return $this->hasOne(personExternal::class, ['id' => 'principal']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolHasEvents()
    {
        return $this->hasMany(schoolHasEvent::class, ['school' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(event::class, ['id' => 'event'])
                ->viaTable('school_has_event', ['school' => 'id']);
    }
}
