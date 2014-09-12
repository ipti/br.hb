<?php

/**
 * This is the model class for table "classroom".
 *
 * The followings are the available columns in table 'classroom':
 * @property integer $id
 * @property integer $fid
 * @property integer $school
 * @property string $name
 * @property string $shift
 *
 * The followings are the available model relations:
 * @property School $school0
 * @property Event[] $events
 * @property Student[] $students
 */
class Classroom extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Classroom the static model class
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
		return 'classroom';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('school, name, shift', 'required'),
			array('fid, school', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('shift', 'length', 'max'=>9),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fid, school, name, shift', 'safe', 'on'=>'search'),
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
			'school0' => array(self::BELONGS_TO, 'School', 'school'),
			'events' => array(self::MANY_MANY, 'Event', 'classroom_has_event(classroom, event)'),
			'students' => array(self::MANY_MANY, 'Student', 'enrollment(classroom, student)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'fid' => Yii::t('default', 'Fid'),
			'school' => Yii::t('default', 'School'),
			'name' => Yii::t('default', 'Name'),
			'shift' => Yii::t('default', 'Shift'),
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
		$criteria->compare('fid',$this->fid);
		$criteria->compare('school',$this->school);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('shift',$this->shift,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}