<?php

/**
 * This is the model class for table "telephone".
 *
 * The followings are the available columns in table 'telephone':
 * @property integer $id_telephone
 * @property integer $id_typetelephone
 * @property integer $id_company
 * @property string $telephone_number
 *
 * The followings are the available model relations:
 * @property Company $idCompany
 * @property TypeTelephone $idTypetelephone
 */
class Telephone extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'telephone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_typetelephone, id_company', 'numerical', 'integerOnly'=>true),
			array('telephone_number', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_telephone, id_typetelephone, id_company, telephone_number', 'safe', 'on'=>'search'),
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
			'idCompany' => array(self::BELONGS_TO, 'Company', 'id_company'),
			'idTypetelephone' => array(self::BELONGS_TO, 'TypeTelephone', 'id_typetelephone'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_telephone' => 'Id Telephone',
			'id_typetelephone' => 'Id Typetelephone',
			'id_company' => 'Id Company',
			'telephone_number' => 'Telephone Number',
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

		$criteria->compare('id_telephone',$this->id_telephone);
		$criteria->compare('id_typetelephone',$this->id_typetelephone);
		$criteria->compare('id_company',$this->id_company);
		$criteria->compare('telephone_number',$this->telephone_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Telephone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
