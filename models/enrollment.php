<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "enrollment".
 *
 * @property integer $id
 * @property integer $student
 * @property integer $classroom
 *
 * @property term $terms
 * @property classroom $classrooms
 * @property student $students
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
            [['id','student', 'classroom'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'student' => Yii::t('app', 'Student'),
            'classroom' => Yii::t('app', 'Classroom'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassrooms()
    {
        return $this->hasOne(classroom::class, ['id' => 'classroom']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(student::class, ['id' => 'student']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this->hasMany(term::class, ['enrollment' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHemoglobins()
    {
        return $this->hasMany(hemoglobin::class, ['agreed_term' => 'id'])
            ->via("terms");
    }
}
