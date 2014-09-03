<?php

/**
 * This is the model class for table "address".
 *
 * The followings are the available columns in table 'address':
 * @property integer $id
 * @property string $state
 * @property string $city
 * @property string $neighborhood
 * @property string $street
 * @property string $number
 * @property string $complement
 * @property string $postal_code
 *
 * The followings are the available model relations:
 * @property Event[] $events
 * @property Person[] $people
 * @property Route[] $routes
 * @property School[] $schools
 * @property Student[] $students
 */
class Address extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Address the static model class
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
		return 'address';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('state, city, neighborhood, street, number, postal_code', 'required'),
			array('state', 'length', 'max'=>2),
			array('city', 'length', 'max'=>60),
			array('neighborhood', 'length', 'max'=>30),
			array('street, complement', 'length', 'max'=>100),
			array('number', 'length', 'max'=>10),
			array('postal_code', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, state, city, neighborhood, street, number, complement, postal_code', 'safe', 'on'=>'search'),
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
			'events' => array(self::HAS_MANY, 'Event', 'address'),
			'people' => array(self::HAS_MANY, 'Person', 'address'),
			'routes' => array(self::HAS_MANY, 'Route', 'address'),
			'schools' => array(self::HAS_MANY, 'School', 'address'),
			'students' => array(self::HAS_MANY, 'Student', 'address'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'state' => Yii::t('default', 'State'),
			'city' => Yii::t('default', 'City'),
			'neighborhood' => Yii::t('default', 'Neighborhood'),
			'street' => Yii::t('default', 'Street'),
			'number' => Yii::t('default', 'Number'),
			'complement' => Yii::t('default', 'Complement'),
			'postal_code' => Yii::t('default', 'Postal Code'),
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
		$criteria->compare('state',$this->state,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('neighborhood',$this->neighborhood,true);
		$criteria->compare('street',$this->street,true);
		$criteria->compare('number',$this->number,true);
		$criteria->compare('complement',$this->complement,true);
		$criteria->compare('postal_code',$this->postal_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
    public function beforeValidate(){
        $this->postal_code = str_replace('-','',$this->postal_code);
        return parent::beforeValidate();
    }
}