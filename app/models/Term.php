<?php

/**
 * This is the model class for table "term".
 *
 * The followings are the available columns in table 'term':
 * @property integer $id
 * @property integer $student
 * @property integer $campaign
 * @property integer $agreed
 *
 * The followings are the available model relations:
 * @property Hemoglobin[] $hemoglobins
 * @property Student $student0
 * @property Campaign $campaign0
 */
class Term extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Term the static model class
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
		return 'term';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, agreed', 'required'),
			array('student, campaign, agreed', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student, campaign, agreed', 'safe', 'on'=>'search'),
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
			'hemoglobins' => array(self::HAS_MANY, 'Hemoglobin', 'agreed_term'),
			'student0' => array(self::BELONGS_TO, 'Student', 'student'),
			'campaign0' => array(self::BELONGS_TO, 'Campaign', 'campaign'),
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
			'campaign' => Yii::t('default', 'Campaign'),
			'agreed' => Yii::t('default', 'Agreed'),
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
		$criteria->compare('campaign',$this->campaign);
		$criteria->compare('agreed',$this->agreed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}