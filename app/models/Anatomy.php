<?php

/**
 * This is the model class for table "anatomy".
 *
 * The followings are the available columns in table 'anatomy':
 * @property integer $id
 * @property integer $student
 * @property double $weight
 * @property double $height
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Student $student0
 */
class Anatomy extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Anatomy the static model class
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
		return 'anatomy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, date', 'required'),
			array('student', 'numerical', 'integerOnly'=>true),
			array('weight, height', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student, weight, height, date', 'safe', 'on'=>'search'),
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
			'studentFK' => array(self::BELONGS_TO, 'Student', 'student'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'student' => Yii::t('default', 'Student'),
			'weight' => Yii::t('default', 'Weight'),
			'height' => Yii::t('default', 'Height'),
			'date' => Yii::t('default', 'Date'),
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
		$criteria->compare('student',$this->student);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('height',$this->height);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}