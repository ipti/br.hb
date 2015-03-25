<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hemoglobin".
 *
 * @property integer $id
 * @property integer $agreed_term
 * @property double $rate
 * @property integer $sample
 *
 * @property Term $agreedTerm
 */
class hemoglobin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hemoglobin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agreed_term', 'rate'], 'required'],
            [['agreed_term', 'sample'], 'integer'],
            [['rate'], 'number']
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
            'sample' => Yii::t('app', 'Sample'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAgreedTerm()
    {
        return $this->hasOne(term::className(), ['id' => 'agreed_term']);
    }
    
    /** 
     * @param integer $sample
     * @return \yii\db\ActiveRecord
     */
    public function getHemoglobin($sample)
    {
        if($sample == $this->sample){
            return $this;
        }else{
            return $this->hasOne(hemoglobin::className(), ['agreed_term' => 'agreed_term'])->where('sample = :s', ["s"=>$sample])->one();
        }
        
    }   
    
    public function isAnemic(){
        $student = $this->agreedTerm->enrollments->students;
        $birthday = new \DateTime($student->birthday);
        $today = new \DateTime(date("Y-m-d"));
        $dif = $today->diff($birthday);
        $months = $dif->format("%y")*12 + $dif->format("%m");
        
        if($months >= 24 && $months < 60) {
            return $this->rate < 11;
        }else if($months >= 60 && $months < 144) {
            return $this->rate < 11.5;
        }else if($months >= 144 && $months < 180) {
            return $this->rate < 12;
        }else if($months >= 180 && $student->gender == "male") {
            return $this->rate < 13;
        }else if($months >= 24 && $student->gender == "female") {
            return $this->rate < 12;
        }else {
            return null;
        }
        
    }
    
}
