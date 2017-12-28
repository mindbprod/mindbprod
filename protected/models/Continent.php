<?php

/**
 * This is the model class for table "continent".
 *
 * The followings are the available columns in table 'continent':
 * @property integer $id_continent
 * @property string $continent_code
 * @property string $continent_name
 *
 * The followings are the available model relations:
 * @property Country[] $countries
 */
class Continent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'continent';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('continent_code, continent_name', 'required'),
			array('continent_code, continent_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
//			array('id_continent', 'safe'),
                        array('id_continent', 'safe'),
			array('continent_code, continent_name', 'safe', 'on'=>'search'),
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
			'countries' => array(self::HAS_MANY, 'Country', 'id_continent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_continent' => 'Id Continent',
			'continent_code' => 'Continent Code',
			'continent_name' => 'Continent Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id_continent',$this->id_continent);
		$criteria->compare('continent_code',$this->continent_code,true);
		$criteria->compare('continent_name',$this->continent_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Continent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
