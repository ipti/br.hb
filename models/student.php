<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student".
 *
 * @property integer $id
 * @property string $fid
 * @property string $name
 * @property integer $address
 * @property string $birthday
 * @property string $gender
 * @property string $mother
 * @property string $father
 *
 * @property Anatomy[] $anatomies
 * @property Consultation[] $consultations
 * @property Enrollment[] $enrollments
 * @property Classroom[] $classrooms
 * @property Kinship[] $kinships
 * @property PersonExternal[] $responsibles
 * @property Address $address0
 * @property Term[] $terms
 */
class student extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'birthday', 'gender'], 'required'],
            [['address'], 'integer'],
            [['birthday', 'name'], 'safe'],
            [['gender'], 'string'],
            [['fid'], 'string', 'max' => 45],
            [['name', 'mother', 'father'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'fid' => Yii::t('app', 'Fid'),
            'name' => Yii::t('app', 'Name'),
            'address' => Yii::t('app', 'Address'),
            'birthday' => Yii::t('app', 'Birthday'),
            'gender' => Yii::t('app', 'Gender'),
            'mother' => Yii::t('app', 'Mother'),
            'father' => Yii::t('app', 'Father'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnatomies() {
        return $this->hasMany(anatomy::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultations() {
        return $this->hasMany(Consultation::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollments() {
        return $this->hasMany(Enrollment::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassrooms() {
        return $this->hasMany(Classroom::class, ['id' => 'classroom'])->viaTable('enrollment', ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKinships() {
        return $this->hasMany(Kinship::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsibles() {
        return $this->hasMany(PersonExternal::class, ['id' => 'responsible'])->viaTable('kinship', ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress0() {
        return $this->hasOne(address::class, ['id' => 'address']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms() {
        return $this->hasMany(term::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaings() {
        return $this->hasMany(campaign::class, ['id' => 'campaing'])
                        ->viaTable(term::class, ['student' => 'id']);
    }

}
