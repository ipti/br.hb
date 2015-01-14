<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $id
 * @property string $state
 * @property string $city
 * @property string $neighborhood
 * @property string $street
 * @property string $number
 * @property string $complement
 * @property string $postal_code
 *
 * @property Event[] $events
 * @property Person[] $people
 * @property Route[] $routes
 * @property School[] $schools
 * @property Student[] $students
 */
class address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state'], 'string', 'max' => 2],
            [['city'], 'string', 'max' => 60],
            [['neighborhood'], 'string', 'max' => 30],
            [['street', 'complement'], 'string', 'max' => 100],
            [['number'], 'string', 'max' => 10],
            [['postal_code'], 'string', 'max' => 8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'state' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'neighborhood' => Yii::t('app', 'Neighborhood'),
            'street' => Yii::t('app', 'Street'),
            'number' => Yii::t('app', 'Number'),
            'complement' => Yii::t('app', 'Complement'),
            'postal_code' => Yii::t('app', 'Postal Code'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['address' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['address' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoutes()
    {
        return $this->hasMany(Route::className(), ['address' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchools()
    {
        return $this->hasMany(School::className(), ['address' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudents()
    {
        return $this->hasMany(Student::className(), ['address' => 'id']);
    }
}
