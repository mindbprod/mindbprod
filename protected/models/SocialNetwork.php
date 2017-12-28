<?php

/**
 * This is the model class for table "social_network".
 *
 * The followings are the available columns in table 'social_network':
 * @property integer $id_snetwork
 * @property integer $id_company
 * @property integer $id_typesnetwork
 * @property string $snetwork
 *
 * The followings are the available model relations:
 * @property Company $idCompany
 * @property TypeSnetwork $idTypesnetwork
 */
class SocialNetwork extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'social_network';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('snetwork,id_typesnetwork', 'required'),
			array('id_company, id_typesnetwork', 'numerical', 'integerOnly'=>true),
			array('snetwork', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_snetwork, id_company, id_typesnetwork, snetwork', 'safe', 'on'=>'search'),
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
			'idTypesnetwork' => array(self::BELONGS_TO, 'TypeSnetwork', 'id_typesnetwork'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_snetwork' => 'Id Snetwork',
			'id_company' => 'Id Company',
			'id_typesnetwork' => 'Id Typesnetwork',
			'snetwork' => 'Snetwork',
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

		$criteria->compare('id_snetwork',$this->id_snetwork);
		$criteria->compare('id_company',$this->id_company);
		$criteria->compare('id_typesnetwork',$this->id_typesnetwork);
		$criteria->compare('snetwork',$this->snetwork,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SocialNetwork the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
