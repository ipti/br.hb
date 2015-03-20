<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enrollment".
 *
 * @property integer $student
 * @property integer $classroom
 *
 * @property Classroom $classrooms
 * @property Student $students
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
    public function getClassrooms()
    {
        return $this->hasOne(classroom::className(), ['id' => 'classroom']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(student::className(), ['id' => 'student']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this->hasOne(term::className(), ['enrollment' => 'id']);
    }
}
