<?php

/**
 * This is the model class for table "email".
 *
 * The followings are the available columns in table 'email':
 * @property integer $id_email
 * @property integer $id_company
 * @property string $email
 *
 * The followings are the available model relations:
 * @property Company $idCompany
 */
class Email extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'email';
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
			array('email', 'required'),
			array('id_company', 'numerical', 'integerOnly'=>true),
			array('email', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_email, id_company, email', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_email' => 'Id Email',
			'id_company' => 'Id Company',
			'email' => 'Email e.g.: aaa@bbb.com',
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

		$criteria->compare('id_email',$this->id_email);
		$criteria->compare('id_company',$this->id_company);
		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Email the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
