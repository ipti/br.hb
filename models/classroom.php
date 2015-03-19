<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "classroom".
 *
 * @property integer $id
 * @property integer $fid
 * @property integer $school
 * @property string $name
 * @property string $shift
 * @property string $year
 *
 * @property School $school0
 * @property ClassroomHasEvent[] $classroomHasEvents
 * @property Event[] $events
 * @property Enrollment[] $enrollments
 * @property Student[] $students
 */
class classroom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classroom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid', 'school','year'], 'integer'],
            [['school', 'name', 'shift','year'], 'required'],
            [['shift'], 'string'],
            [['name'], 'string', 'max' => 20]
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
            'school' => Yii::t('app', 'School'),
            'name' => Yii::t('app', 'Name'),
            'shift' => Yii::t('app', 'Shift'),
            'year' => Yii::t('app', 'Year'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchools()
    {
        return $this->hasOne(school::className(), ['id' => 'school']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassroomHasEvents()
    {
        return $this->hasMany(classroomHasEvent::className(), ['classroom' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(event::className(), ['id' => 'event'])
                ->viaTable('classroom_has_event', ['classroom' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollments()
    {
        return $this->hasMany(enrollment::className(), ['classroom' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(student::className(), ['id' => 'student'])
                ->viaTable('enrollment', ['classroom' => 'id']);
    }
}
