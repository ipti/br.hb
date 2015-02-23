<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anatomy".
 *
 * @property integer $id
 * @property integer $student
 * @property double $weight
 * @property double $height
 * @property string $date
 *
 * @property Student $student0
 */
class anatomy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'anatomy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student', 'date'], 'required'],
            [['student'], 'integer'],
            [['weight', 'height'], 'number'],
            [['date'], 'safe']
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
            'weight' => Yii::t('app', 'Weight'),
            'height' => Yii::t('app', 'Height'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasOne(student::className(), ['id' => 'student']);
    }
}
