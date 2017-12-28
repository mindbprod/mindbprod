<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id_user
 * @property integer $id_sperson
 * @property integer $id_typeuser
 * @property string $username
 * @property string $password
 * @property integer $active_user
 *
 * The followings are the available model relations:
 * @property Company[] $companies
 * @property Person $idSperson
 * @property TypeUser $idTypeuser
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
        public $confirm_password;
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_sperson, id_typeuser, username, password, active_user', 'required'),
			array('id_sperson, id_typeuser, active_user', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_user, id_sperson, id_typeuser, username, password, active_user, confirm_password', 'safe', 'on'=>'search'),
                        array('password','confirmPassword'),
                        array('username','confirmUsername'),
		);
	}
        /**
	 * 	al momento de registrar el usuario en el sistema, éste verifica si la clave digitada coincide con el campo de verificación de clave.
	 */
	public function confirmUsername(){
		if(Yii::app()->controller->action->id=="registerUser"){
                    $paramsUser=Yii::app()->request->getPost("User");
                    if(isset($paramsUser["username"])){
                        $modelUser=  User::model()->findByAttributes(array("username"=>$paramsUser["username"]));
                        if(!empty($modelUser)){
                                $this->addError('username',"The username exists in database, type another username");
                        }
                    }	
		}
	}
        /**
	 * 	al momento de registrar el usuario en el sistema, éste verifica si la clave digitada coincide con el campo de verificación de clave.
	 */
	public function confirmPassword(){
		if(Yii::app()->controller->action->id=="registerUser"){
                    $paramsUser=Yii::app()->request->getPost("User");
			if(isset($paramsUser["password"])){
                            if($this->password!=$paramsUser["confirm_password"]){
                                    $this->addError('password',"Passowrds do not match");
                            }elseif(strlen($this->password) < 6){
				  $this->addError('password',"The password has to contain at least 6 caracters");
			   }elseif(strlen($this->password) > 16){
				  $this->addError('password',"The password can not be longer than 16 characters");
			   }elseif (!preg_match('`[a-z]`',$this->password)){
				  $this->addError('password',"The password must have at least one lower case letter");
			   }elseif (!preg_match('`[A-Z]`',$this->password)){
				  $this->addError('password',"The password must have at least one upper case letter");
			   }elseif (!preg_match('`[0-9]`',$this->password)){
				  $this->addError('password',"The password must have at least one numeric caracter");
			   }
			}	
		}
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'companies' => array(self::MANY_MANY, 'Company', 'register_company(id_user, id_company)'),
			'idSperson' => array(self::BELONGS_TO, 'Person', 'id_sperson'),
			'idTypeuser' => array(self::BELONGS_TO, 'TypeUser', 'id_typeuser'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_user' => 'Id User',
			'id_sperson' => 'Id Sperson',
			'id_typeuser' => 'Id Typeuser',
			'username' => 'Username',
			'password' => 'Password',
			'active_user' => 'Active User',
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

		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('id_sperson',$this->id_sperson);
		$criteria->compare('id_typeuser',$this->id_typeuser);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('active_user',$this->active_user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
