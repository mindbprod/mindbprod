<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $id_company
 * @property integer $id_city
 * @property string $company_number
 * @property string $company_name
 * @property string $company_address
 * @property string $company_fest_desc
 * @property string $company_observations
 *
 * The followings are the available model relations:
 * @property City $idCity
 * @property TypeCompany[] $typeCompanies
 * @property Email[] $emails
 * @property Observation[] $observations
 * @property User[] $users
 * @property SocialNetwork[] $socialNetworks
 * @property Telephone[] $telephones
 * @property Web[] $webs
 */
class Company extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'company';
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
			array('company_name, company_fest_desc', 'required'),
			array('id_city', 'numerical', 'integerOnly'=>true),
			array('company_number', 'length', 'max'=>50),
			array('company_name, company_address', 'length', 'max'=>500),
			array('company_observations', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_company, id_city, company_number, company_name, company_address, company_fest_desc, company_observations', 'safe', 'on'=>'search'),
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
			'idCity' => array(self::BELONGS_TO, 'City', 'id_city'),
			'typeCompanies' => array(self::MANY_MANY, 'TypeCompany', 'company_tcompany(id_company, id_typecompany)'),
			'emails' => array(self::HAS_MANY, 'Email', 'id_company'),
			'observations' => array(self::HAS_MANY, 'Observation', 'id_company'),
			'users' => array(self::MANY_MANY, 'User', 'register_company(id_company, id_user)'),
			'socialNetworks' => array(self::HAS_MANY, 'SocialNetwork', 'id_company'),
			'telephones' => array(self::HAS_MANY, 'Telephone', 'id_company'),
			'webs' => array(self::HAS_MANY, 'Web', 'id_company'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_company' => 'Id Company',
			'id_city' => 'Id City',
			'company_number' => 'Company Number',
			'company_name' => 'Company Name',
			'company_address' => 'Company Address',
			'company_fest_desc' => 'Company Fest Desc',
			'company_observations' => 'Company Observations',
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

		$criteria->compare('id_company',$this->id_company);
		$criteria->compare('id_city',$this->id_city);
		$criteria->compare('company_number',$this->company_number,true);
		$criteria->compare('company_name',$this->company_name,true);
		$criteria->compare('company_address',$this->company_address,true);
		$criteria->compare('company_fest_desc',$this->company_fest_desc,true);
		$criteria->compare('company_observations',$this->company_observations,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Company the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
