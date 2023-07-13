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
 * @property Student $students
 */
class anatomy extends \yii\db\ActiveRecord
{
    const DESNUTRIDO    = -1;
    const NORMAL        = 0;
    const SOBREPESO     = 1;
    const OBESIDADE     = 2;
    const OBESIDADE_MORBIDA = 3;
    
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
            [['student','weight', 'height', 'date'], 'required'],
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
        return $this->hasOne(student::class, ['id' => 'student']);
    }
    
    public function IMC(){
        return round($this->weight/($this->height*$this->height), 2);
    }
    
    public function IMCSituation(){
        if($this->IMC() <  19) return anatomy::DESNUTRIDO;
        else if($this->IMC() >= 19 && $this->IMC() < 24.9) return anatomy::NORMAL;
        else if($this->IMC() >= 25 && $this->IMC() < 29.9) return anatomy::SOBREPESO;
        else if($this->IMC() >= 30 && $this->IMC() < 39.9) return anatomy::OBESIDADE;
        else if($this->IMC() >= 40) return anatomy::OBESIDADE_MORBIDA;
        else return null;
    }
}
