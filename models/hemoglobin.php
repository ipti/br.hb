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
        return $this->hasOne(Term::className(), ['id' => 'agreed_term']);
    }
}
