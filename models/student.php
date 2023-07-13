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
 * @property string $responsible_1_name
 * @property string $responsible_1_telephone
 * @property string $responsible_1_kinship
 * @property string $responsible_1_email
 * @property string $responsible_2_name
 * @property string $responsible_2_telephone
 * @property string $responsible_2_kinship
 * @property string $responsible_2_email
 * @property integer $allergy
 * @property string $allergy_text
 * @property integer $anemia
 * @property string $anemia_text
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
            [['address, allergy, anemia'], 'integer'],
            [['birthday', 'name'], 'safe'],
            [['gender, responsible_1_name, responsible_1_telephone, responsible_1_kinship, responsible_1_email, responsible_2_name, responsible_2_telephone, responsible_2_kinship, responsible_2_email, allergy_text, anemia_text'], 'string'],
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
            'responsible_1_name' => Yii::t('app', 'Responsible Name'),
            'responsible_1_telephone' => Yii::t('app', 'Responsible Telephone'),
            'responsible_1_kinship' => Yii::t('app', 'Responsible Kinship'),
            'responsible_1_email' => Yii::t('app', 'Responsible Email'),
            'responsible_2_name' => Yii::t('app', 'Responsible Name'),
            'responsible_2_telephone' => Yii::t('app', 'Responsible Telephone'),
            'responsible_2_kinship' => Yii::t('app', 'Responsible Kinship'),
            'responsible_2_email' => Yii::t('app', 'Responsible Email'),
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
