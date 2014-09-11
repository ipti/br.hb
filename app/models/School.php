<?php

/**
 * This is the model class for table "school".
 *
 * The followings are the available columns in table 'school':
 * @property integer $id
 * @property string $fid
 * @property string $name
 * @property string $phone
 * @property integer $address
 * @property integer $principal
 *
 * The followings are the available model relations:
 * @property Campaign[] $campaigns
 * @property Classroom[] $classrooms
 * @property Address $address0
 * @property PersonExternal $principal0
 * @property Event[] $events
 */
class School extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return School the static model class
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
		return 'school';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address', 'required'),
			array('address, principal', 'numerical', 'integerOnly'=>true),
			array('fid', 'length', 'max'=>45),
			array('name', 'length', 'max'=>200),
			array('phone', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fid, name, phone, address, principal', 'safe', 'on'=>'search'),
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
			'campaigns' => array(self::MANY_MANY, 'Campaign', 'campaign_has_school(school, campaign)'),
			'classrooms' => array(self::HAS_MANY, 'Classroom', 'school'),
			'address0' => array(self::BELONGS_TO, 'Address', 'address'),
			'principal0' => array(self::BELONGS_TO, 'PersonExternal', 'principal'),
			'events' => array(self::MANY_MANY, 'Event', 'school_has_event(school, event)'),
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
			'phone' => Yii::t('default', 'Phone'),
			'address' => Yii::t('default', 'Address'),
			'principal' => Yii::t('default', 'Principal'),
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address);
		$criteria->compare('principal',$this->principal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}