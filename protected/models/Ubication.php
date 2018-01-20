<?php

/**
 * This is the model class for table "ubication".
 *
 * The followings are the available columns in table 'ubication':
 * @property integer $id_ubication
 * @property integer $id_company
 * @property integer $id_state
 * @property integer $id_city
 * @property integer $id_continent
 * @property integer $id_country
 * @property string $latlong
 */
class Ubication extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ubication';
	}
    public function behaviors(){
        return array(
            'AuditFieldBehavior' => array(
                // Path to AuditFieldBehavior class.
                'class' => 'audit.components.AuditFieldBehavior',

                // Set to false if you just want to use getDbAttribute and other methods in this class.
                // If left unset the value will come from AuditModule::enableAuditField
//                'enableAuditField' => null,

                // Any additional models you want to use to write model and model_id audits to.  If this array is not empty then
                // each field modifed will result in an AuditField being created for each additionalAuditModels.
//                'additionalAuditModels' => array(
//                    'Post' => 'post_id',
//                ),

                // A list of fields to be ignored on update and delete
//                'ignoreFields' => array(
//                    'insert' => array('modified', 'modified_by', 'deleted', 'deleted_by'),
//                    'update' => array('created', 'created_by', 'modified'),
//                ),

                // A list of values that will be treated as if they were null.
//            'ignoreValues' => array('0', '0.0', '0.00', '0.000', '0.0000', '0.00000', '0.000000', '0000-00-00', '0000-00-00 00:00:00'),
            ),
        );
    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_company', 'required'),
			array('id_company, id_state, id_city, id_continent, id_country', 'numerical', 'integerOnly'=>true),
			array('latlong', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_ubication, id_company, id_state, id_city, id_continent, id_country, latlong', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_ubication' => 'Id Ubication',
			'id_company' => 'Id Company',
			'id_state' => 'Id State',
			'id_city' => 'Id City',
			'id_continent' => 'Id Continent',
			'id_country' => 'Id Country',
			'latlong' => 'Latlong',
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

		$criteria->compare('id_ubication',$this->id_ubication);
		$criteria->compare('id_company',$this->id_company);
		$criteria->compare('id_state',$this->id_state);
		$criteria->compare('id_city',$this->id_city);
		$criteria->compare('id_continent',$this->id_continent);
		$criteria->compare('id_country',$this->id_country);
		$criteria->compare('latlong',$this->latlong,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ubication the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
