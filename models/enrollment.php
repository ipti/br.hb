<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enrollment".
 *
 * @property integer $student
 * @property integer $classroom
 *
 * @property Classroom $classroom0
 * @property Student $student0
 */
class enrollment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'enrollment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student', 'classroom'], 'required'],
            [['student', 'classroom'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'student' => Yii::t('app', 'Student'),
            'classroom' => Yii::t('app', 'Classroom'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassroom0()
    {
        return $this->hasOne(Classroom::className(), ['id' => 'classroom']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent0()
    {
        return $this->hasOne(Student::className(), ['id' => 'student']);
    }
}
