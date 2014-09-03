<?php

/**
 * This is the model class for table "consultation".
 *
 * The followings are the available columns in table 'consultation':
 * @property integer $id
 * @property integer $doctor
 * @property integer $student
 * @property integer $attended
 * @property integer $delivered
 *
 * The followings are the available model relations:
 * @property PersonDoctor $doctor0
 * @property Student $student0
 * @property Stock[] $stocks
 */
class Consultation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Consultation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'consultation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student', 'required'),
			array('doctor, student, attended, delivered', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, doctor, student, attended, delivered', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'doctor0' => array(self::BELONGS_TO, 'PersonDoctor', 'doctor'),
			'student0' => array(self::BELONGS_TO, 'Student', 'student'),
			'stocks' => array(self::MANY_MANY, 'Stock', 'prescription(consultation, stock)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'doctor' => Yii::t('default', 'Doctor'),
			'student' => Yii::t('default', 'Student'),
			'attended' => Yii::t('default', 'Attended'),
			'delivered' => Yii::t('default', 'Delivered'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('doctor',$this->doctor);
		$criteria->compare('student',$this->student);
		$criteria->compare('attended',$this->attended);
		$criteria->compare('delivered',$this->delivered);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}