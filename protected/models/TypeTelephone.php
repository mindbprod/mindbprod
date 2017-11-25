<?php

/**
 * This is the model class for table "type_telephone".
 *
 * The followings are the available columns in table 'type_telephone':
 * @property integer $id_typetelephone
 * @property string $typetel_code
 * @property string $typetel_name
 *
 * The followings are the available model relations:
 * @property Telephone[] $telephones
 */
class TypeTelephone extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'type_telephone';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typetel_code, typetel_name', 'required'),
			array('typetel_code, typetel_name', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_typetelephone, typetel_code, typetel_name', 'safe', 'on'=>'search'),
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
			'telephones' => array(self::HAS_MANY, 'Telephone', 'id_typetelephone'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_typetelephone' => 'Id Typetelephone',
			'typetel_code' => 'Typetel Code',
			'typetel_name' => 'Typetel Name',
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

		$criteria->compare('id_typetelephone',$this->id_typetelephone);
		$criteria->compare('typetel_code',$this->typetel_code,true);
		$criteria->compare('typetel_name',$this->typetel_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TypeTelephone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
