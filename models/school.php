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
    public function getCampaignHasSchools()
    {
        return $this->hasMany(CampaignHasSchool::className(), ['school' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['id' => 'campaign'])->viaTable('campaign_has_school', ['school' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassrooms()
    {
        return $this->hasMany(Classroom::className(), ['school' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress0()
    {
        return $this->hasOne(Address::className(), ['id' => 'address']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrincipal0()
    {
        return $this->hasOne(PersonExternal::className(), ['id' => 'principal']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchoolHasEvents()
    {
        return $this->hasMany(SchoolHasEvent::className(), ['school' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['id' => 'event'])->viaTable('school_has_event', ['school' => 'id']);
    }
}
