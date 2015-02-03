<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "term".
 *
 * @property integer $id
 * @property integer $student
 * @property integer $campaign
 * @property integer $agreed
 *
 * @property Hemoglobin[] $hemoglobins
 * @property Campaign $campaign0
 * @property Student $student0
 */
class term extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'term';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student', 'agreed'], 'required'],
            [['student', 'campaign', 'agreed'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'student' => Yii::t('app', 'Student'),
            'campaign' => Yii::t('app', 'Campaign'),
            'agreed' => Yii::t('app', 'Agreed'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHemoglobins()
    {
        return $this->hasMany(Hemoglobin::className(), ['agreed_term' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign0()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent0()
    {
        return $this->hasOne(Student::className(), ['id' => 'student']);
    }
}
