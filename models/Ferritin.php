<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hemoglobin".
 *
 * @property integer $id
 * @property integer $agreed_term
 * @property double $rate
 * @property string $date
 *
 * @property Term $agreedTerm
 */
class Ferritin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ferritin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agreed_term', 'rate'], 'required'],
            [['agreed_term'], 'integer'],
            [['rate'], 'number'],
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
            'agreed_term' => Yii::t('app', 'Agreed Term'),
            'rate' => Yii::t('app', 'Rate'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgreedTerm()
    {
        return $this->hasOne(term::class, ['id' => 'agreed_term']);
    }

    /** 
     * @return \yii\db\ActiveRecord
    */
    public function getFerritin() {
        return $this->hasOne(Ferritin::class, ['agreed_term' => 'agreed_term'])->one();
    }   
    
    // public function isAnemic(){
    //    /*  $student = $this->agreedTerm->enrollments->students;
    //     $birthday = new \DateTime($student->birthday);
    //     $today = new \DateTime(date("Y-m-d"));
    //     $dif = $today->diff($birthday);
    //     $months = $dif->format("%y")*12 + $dif->format("%m");
        
    //     if($months >= 6 && $months < 60) {
    //         return $this->rate < 11;
    //     }else if($months >= 60 && $months < 144) {
    //         return $this->rate < 11.5;
    //     }else if($months >= 144 && $months < 180) {
    //         return $this->rate < 12;
    //     }else if($months >= 180 && $student->gender == "male") {
    //         return $this->rate < 13;
    //     }else if($months >= 180 && $student->gender == "female") {
    //         return $this->rate < 12;
    //     }else {
    //         return null;
    //     } */
        
    // }
    
}
