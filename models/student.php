<?php

namespace app\models;

use Yii;
use yii\helpers\VarDumper;

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
class student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'birthday', 'gender'], 'required'],
            [['address', 'allergy', 'anemia', 'responsible_2_kinship', 'responsible_1_kinship'], 'integer'],
            [['birthday', 'name', 'address', 'allergy', 'anemia'], 'safe'],
            [['gender', 'responsible_1_name', 'responsible_1_telephone', 'responsible_1_email', 'responsible_2_name', 'responsible_2_telephone', 'responsible_2_email', 'allergy_text', 'anemia_text'], 'string'],
            [['fid'], 'string', 'max' => 45],
            [['name', 'mother', 'father'], 'string', 'max' => 150]
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
            'name' => Yii::t('app', 'Name'),
            'address' => Yii::t('app', 'Address'),
            'birthday' => Yii::t('app', 'Birthday'),
            'gender' => Yii::t('app', 'Gender'),
            'responsible_1_name' => Yii::t('app', 'Responsible Name 1'),
            'responsible_1_telephone' => Yii::t('app', 'Responsible Telephone 1'),
            'responsible_1_kinship' => Yii::t('app', 'Responsible Kinship 1'),
            'responsible_1_email' => Yii::t('app', 'Responsible Email 1'),
            'responsible_2_name' => Yii::t('app', 'Responsible Name 2'),
            'responsible_2_telephone' => Yii::t('app', 'Responsible Telephone 2'),
            'responsible_2_kinship' => Yii::t('app', 'Responsible Kinship 2'),
            'responsible_2_email' => Yii::t('app', 'Responsible Email 2'),
            'allergy' => Yii::t('app', 'Allergy'),
            'allergy_text' => Yii::t('app', 'Allergy Text'),
            'anemia' => Yii::t('app', 'Anemia'),
            'anemia_text' => Yii::t('app', 'Anemia Text'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnatomies()
    {
        return $this->hasMany(anatomy::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultations()
    {
        return $this->hasMany(Consultation::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnrollments()
    {
        return $this->hasMany(Enrollment::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClassrooms()
    {
        return $this->hasMany(Classroom::class, ['id' => 'classroom'])->viaTable('enrollment', ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKinships()
    {
        return $this->hasMany(Kinship::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponsibles()
    {
        return $this->hasMany(PersonExternal::class, ['id' => 'responsible'])->viaTable('kinship', ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress0()
    {
        return $this->hasOne(address::class, ['id' => 'address']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerms()
    {
        return $this->hasMany(term::class, ['student' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaings()
    {
        return $this->hasMany(campaign::class, ['id' => 'campaing'])
                        ->viaTable(term::class, ['student' => 'id']);
    }


    public function isAnemic($term_id)
    {
        $rate = (new \yii\db\Query())
            ->select(['rate'])
            ->from('hemoglobin')
            ->where(['agreed_term' => $term_id, 'sample' => 1])
            ->one();

        $isAnemic = false;

        if(isset($rate["rate"])) {
            $rate = floatval($rate["rate"]);
            
            $genderStudent = $this->gender;
            $ageStudent = (time() - strtotime($this->birthday)) / (60 * 60 * 24 * 30);
            if (($ageStudent > 24) && ($ageStudent < 60)) {
                $isAnemic = !($rate >= 11);
            } elseif (($ageStudent >= 60) && ($ageStudent < 144)) {
                $isAnemic = !($rate >= 11.5);
            } elseif (($ageStudent >= 144) && ($ageStudent < 180)) {
                $isAnemic = !($rate >= 12);
            } elseif ($ageStudent >= 180) {

                if ($genderStudent == "male") {
                    $isAnemic = !($rate >= 13);
                } else {
                    //female
                    $isAnemic = !($rate >= 12);
                }
            }
        }
        return $isAnemic;
    }

}
