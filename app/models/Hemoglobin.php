<?php

/**
 * This is the model class for table "hemoglobin".
 *
 * The followings are the available columns in table 'hemoglobin':
 * @property integer $id
 * @property integer $agreed_term
 * @property double $rate
 * @property integer $sample
 *
 * The followings are the available model relations:
 * @property Term $agreedTerm
 */
class Hemoglobin extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Hemoglobin the static model class
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
		return 'hemoglobin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('agreed_term, rate', 'required'),
			array('agreed_term, sample', 'numerical', 'integerOnly'=>true),
			array('rate', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, agreed_term, rate, sample', 'safe', 'on'=>'search'),
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
			'agreedTerm' => array(self::BELONGS_TO, 'Term', 'agreed_term'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('default', 'ID'),
			'agreed_term' => Yii::t('default', 'Agreed Term'),
			'rate' => Yii::t('default', 'Rate'),
			'sample' => Yii::t('default', 'Sample'),
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
		$criteria->compare('agreed_term',$this->agreed_term);
		$criteria->compare('rate',$this->rate);
		$criteria->compare('sample',$this->sample);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}