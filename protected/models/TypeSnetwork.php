<?php

/**
 * This is the model class for table "type_snetwork".
 *
 * The followings are the available columns in table 'type_snetwork':
 * @property integer $id_typesnetwork
 * @property string $typesnetwork_code
 * @property string $typesnetwork_name
 *
 * The followings are the available model relations:
 * @property SocialNetwork[] $socialNetworks
 */
class TypeSnetwork extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'type_snetwork';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('typesnetwork_code, typesnetwork_name', 'required'),
			array('typesnetwork_code, typesnetwork_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_typesnetwork, typesnetwork_code, typesnetwork_name', 'safe', 'on'=>'search'),
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
			'socialNetworks' => array(self::HAS_MANY, 'SocialNetwork', 'id_typesnetwork'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_typesnetwork' => 'Id Typesnetwork',
			'typesnetwork_code' => 'Typesnetwork Code',
			'typesnetwork_name' => 'Typesnetwork Name',
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

		$criteria->compare('id_typesnetwork',$this->id_typesnetwork);
		$criteria->compare('typesnetwork_code',$this->typesnetwork_code,true);
		$criteria->compare('typesnetwork_name',$this->typesnetwork_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TypeSnetwork the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
