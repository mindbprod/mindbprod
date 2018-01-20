<?php

/**
 * This is the model class for table "person".
 *
 * The followings are the available columns in table 'person':
 * @property integer $id_sperson
 * @property string $person_id
 * @property string $person_name
 * @property string $person_lastname
 * @property string $person_email
 *
 * The followings are the available model relations:
 * @property User[] $users
 */
class Person extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'person';
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
			array('person_id, person_name, person_lastname, person_email', 'required'),
			array('person_id, person_name, person_lastname, person_email', 'length', 'max'=>50),
			array('person_email', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_sperson, person_id, person_name, person_lastname, person_email', 'safe', 'on'=>'search'),
                        array('person_id','validatepersonid'),
                        array('person_email','validatepersonemail'),
                    
		);
	}
        /**
	 * 	al momento de registrar el usuario en el sistema, éste verifica si ya existe un usuario con el id digitado en campo person_id.
	 */
	public function validatepersonid(){
//            if(!$this->hasErrors()){
		if(Yii::app()->controller->action->id=="registerUser"){
                    $personData=Yii::app()->request->getPost("Person");
                    if(isset($personData["person_id"])){
                        $modelPerson=  Person::model()->findByAttributes(array("person_id"=>$personData["person_id"]));
                        if(!empty($modelPerson)){
                                $this->addError('person_id',"The person id exists in database, type other person id.");
                        }
                    }	
		}
//            }
	}
        /**
	 * 	al momento de registrar el usuario en el sistema, éste verifica si ya existe un usuario con el id digitado en campo person_id.
	 */
	public function validatepersonemail(){
//            if(!$this->hasErrors()){
		if(Yii::app()->controller->action->id=="registerUser"){
                    $personData=Yii::app()->request->getPost("Person");
                    if(isset($personData["person_email"])){
                        $modelPerson=  Person::model()->findByAttributes(array("person_email"=>$personData["person_email"]));
                        if(!empty($modelPerson)){
                                $this->addError('person_email',"The person email exists in database, type other email.");
                        }
                    }	
		}
//            }
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'users' => array(self::HAS_MANY, 'User', 'id_sperson'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_sperson' => 'Id Sperson',
			'person_id' => 'Person ID',
			'person_name' => 'Person Name',
			'person_lastname' => 'Person Lastname',
			'person_email' => 'Person Email',
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

		$criteria->compare('id_sperson',$this->id_sperson);
		$criteria->compare('person_id',$this->person_id,true);
		$criteria->compare('person_name',$this->person_name,true);
		$criteria->compare('person_lastname',$this->person_lastname,true);
		$criteria->compare('person_email',$this->person_email,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Person the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
