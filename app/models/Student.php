<?php

/**
 * This is the model class for table "student".
 *
 * The followings are the available columns in table 'student':
 * @property integer $id
 * @property string $fid
 * @property string $name
 * @property integer $address
 * @property string $birthday
 * @property string $gender
 * @property string $responsible
 *
 * The followings are the available model relations:
 * @property Anatomy[] $anatomies
 * @property Consultation[] $consultations
 * @property Classroom[] $classrooms
 * @property PersonExternal[] $personExternals
 * @property Address $address0
 * @property Term[] $terms
 */
class Student extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Student the static model class
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
		return 'student';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, birthday, gender', 'required'),
			array('address', 'numerical', 'integerOnly'=>true),
			array('fid', 'length', 'max'=>45),
			array('name, responsible', 'length', 'max'=>150),
			array('gender', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fid, name, address, birthday, gender, responsible', 'safe', 'on'=>'search'),
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
			'anatomies' => array(self::HAS_MANY, 'Anatomy', 'student'),
			'consultations' => array(self::HAS_MANY, 'Consultation', 'student'),
			'classrooms' => array(self::MANY_MANY, 'Classroom', 'enrollment(student, classroom)'),
			'personExternals' => array(self::MANY_MANY, 'PersonExternal', 'kinship(student, responsible)'),
			'addressFK' => array(self::BELONGS_TO, 'Address', 'address'),
			'terms' => array(self::HAS_MANY, 'Term', 'student'),
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
			'name' => Yii::t('default', 'Name'),
			'address' => Yii::t('default', 'Address'),
			'birthday' => Yii::t('default', 'Birthday'),
			'gender' => Yii::t('default', 'Gender'),
			'responsible' => Yii::t('default', 'Responsible'),
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
		$criteria->compare('fid',$this->fid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('responsible',$this->responsible,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}