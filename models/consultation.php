<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consultation".
 *
 * @property integer $id
 * @property integer $doctor
 * @property integer $student
 * @property integer $attended
 * @property integer $delivered
 *
 * @property PersonDoctor $doctor0
 * @property Student $student0
 * @property Prescription[] $prescriptions
 * @property Stock[] $stocks
 */
class consultation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'consultation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doctor', 'student', 'attended', 'delivered'], 'integer'],
            [['student'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'doctor' => Yii::t('app', 'Doctor'),
            'student' => Yii::t('app', 'Student'),
            'attended' => Yii::t('app', 'Attended'),
            'delivered' => Yii::t('app', 'Delivered'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctor0()
    {
        return $this->hasOne(PersonDoctor::className(), ['id' => 'doctor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent0()
    {
        return $this->hasOne(Student::className(), ['id' => 'student']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrescriptions()
    {
        return $this->hasMany(Prescription::className(), ['consultation' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(Stock::className(), ['id' => 'stock'])->viaTable('prescription', ['consultation' => 'id']);
    }
}
