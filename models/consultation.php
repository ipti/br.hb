<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consultation".
 *
 * @property integer $id
 * @property integer $doctor
 * @property integer $attended
 * @property integer $delivered
 * @property integer $term
 *
 * @property Term $terms
 * @property PersonDoctor $doctor0
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
            [['doctor', 'attended', 'delivered', 'term'], 'integer']
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
            'attended' => Yii::t('app', 'Attended'),
            'delivered' => Yii::t('app', 'Delivered'),
            'term' => Yii::t('app', 'Term'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this->hasOne(term::class, ['id' => 'term']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctors()
    {
        return $this->hasOne(personDoctor::class, ['id' => 'doctor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrescriptions()
    {
        return $this->hasMany(prescription::class, ['consultation' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStocks()
    {
        return $this->hasMany(stock::class, ['id' => 'stock'])
                ->viaTable('prescription', ['consultation' => 'id']);
    }
}
