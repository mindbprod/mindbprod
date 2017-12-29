<?php

class UserController extends Controller{
    /**
    * Acción que se ejecuta en segunda instancia para verificar si el usuario tiene sesión activa.
    * En caso contrario no podrá acceder a los módulos del aplicativo y generará error de acceso.
    */
    public function filterEnforcelogin($filterChain){
        if(Yii::app()->user->isGuest){
            if(isset($_POST) && !empty($_POST)){
                $response["status"]="nosession";
                echo CJSON::encode($response);
                exit();
            }
            else{
                Yii::app()->user->returnUrl = array("site/login");                                                          
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $filterChain->run();
    }
    /**
     * @return array action filters
     */
    public function filters(){
        return array(
                'enforcelogin',                      
        );
    }
    public function actionRegisterUser(){
        $modelPerson=new Person();
        $modelUser=new User();
        if(empty($_POST)){
            $typeUser=  TypeUser::model()->findAll();
            $users=$this->listUsers();
            $this->render('registerUser',array(
                'modelPerson'=>$modelPerson,
                'modelUser'=>$modelUser,
                'typeUser'=>$typeUser,
                'users'=>$users
            ));
        }
        else{
            $modelPerson->attributes=Yii::app()->request->getPost("Person");
            $modelUser->attributes=Yii::app()->request->getPost("User");
            $modelUser->id_sperson=0;
            $modelUser->active_user=2;
            $opciones = [
                        'cost' => 9
                    ];
            $passworCrypt=password_hash($modelUser->password, PASSWORD_BCRYPT, $opciones);
            $this->performAjaxValidation(array($modelPerson,$modelUser),"userreg-form");
            if($modelPerson->validate()&&$modelUser->validate()){ 
                $modelUser->password=$passworCrypt;
                $transaction=Yii::app()->db->beginTransaction();
                try{
                    $modelPerson->save();
                    $modelUser->id_sperson=$modelPerson->getPrimaryKey();
                    if($modelUser->save()){
                        $response["status"]="exito";
                        $transaction->commit();
                    }
                    else{
                        $transaction->rollback();
                        $response["status"]="noexito";
                    }
                }
                catch(ErrorException $e){
                    $transaction->rollback();
                    throw new CHttpException($e->get,$e->getMessage());
                }
                echo CJSON::encode($response);
                    
            }
            else{
                echo CActiveForm::validate(array($modelPerson,$modelUser));
            }
        }
    }
     public function actionChangeState(){
        $state=Yii::app()->request->getPost("state");
        $personid=Yii::app()->request->getPost("personid");
        $person=  Person::model()->findByAttributes(array("person_id"=>$personid));
        $user=  User::model()->findByAttributes(array("id_sperson"=>$person->id_sperson));
        $idUser=$user->id_user;
        if($user->updateByPk($idUser,array('active_user'=>$state))){
            $response["status"]="exito";
            $response["msg"]="State has changed";
        }
        else{
            $response["status"]="noexito";
            $response["msg"]="Without changes";
        }
        echo CJSON::encode($response);
    }
    
    public function listUsers(){
        $selfUsername=Yii::app()->user->getState('nombreUsuario');
        $conn=Yii::app()->db;
        $sql="SELECT person_id,person_name,person_lastname,person_email,username,active_user,typeuser_name,c.id_typeuser FROM person AS a "
                . "LEFT JOIN user AS b ON b.id_sperson=a.id_sperson "
                . "LEFT JOIN type_user as c on c.id_typeuser=b.id_typeuser "
                . "WHERE b.username<>:username";
        $query=$conn->createCommand($sql);
        $query->bindParam(":username", $selfUsername);
        $read=$query->query();
        $res=$read->readAll();
        $read->close();
        return $res;
    }
    public function actionListUsers(){
        $selfUsername=Yii::app()->user->getState('nombreUsuario');
        $conn=Yii::app()->db;
        $sql="SELECT person_id,person_name,person_lastname,person_email,username,active_user,typeuser_name,c.id_typeuser FROM person AS a "
                . "LEFT JOIN user AS b ON b.id_sperson=a.id_sperson "
                . "LEFT JOIN type_user as c on c.id_typeuser=b.id_typeuser "
                . "WHERE b.username<>:username";
        $query=$conn->createCommand($sql);
        $query->bindParam(":username", $selfUsername);
        $read=$query->query();
        $res=$read->readAll();
        $read->close();
        echo CJSON::encode($res);
    }
    
    public function actionChangePassword(){
        $modelUser= User::model();
        if(empty($_POST)){
            $this->render("changepassword",array('modelUser'=>$modelUser));
        }
        else{
            $username=Yii::app()->user->id;
            $criteria = new CDbCriteria;
            $criteria->select = 'id_user, id_sperson,id_typeuser,active_user'; // select fields which you want in output
            $criteria->condition = 'username = :username';
            $criteria->params = array(':username'=>$username);
            $passwords=Yii::app()->request->getPost("User");
            $modelUser=$modelUser->findAll($criteria)[0];
            $modelUser->username=$username;
            $opciones = [
                        'cost' => 9
                    ];
            $passworCrypt=password_hash($passwords["password"], PASSWORD_BCRYPT, $opciones);
            $modelUser->password=$passworCrypt;
            $this->performAjaxValidation($modelUser,"changepass-form");
            if($modelUser->validate()){ 
                $modelUser->password=$passworCrypt;
                $transaction=Yii::app()->db->beginTransaction();
                try{
                    if($modelUser->updateByPk($modelUser->id_user,array("password"=>$passworCrypt))){
                        $response["status"]="exito";
                        $transaction->commit();
                    }
                    else{
                        $transaction->rollback();
                        $response["status"]="noexito";
                    }
                }
                catch(ErrorException $e){
                    $transaction->rollback();
                    throw new CHttpException($e->get,$e->getMessage());
                }
                echo CJSON::encode($response);
                    
            }
            else{
                echo CActiveForm::validate($modelUser);
            }
        }
    }
    /**
    * Valida los modelos.
    *
    * @param type $titulos captura el string digitado para realizar filtro por ciudades de oficinas
    *
    * @return $display_json Listado de titulos en formato json
    */
    protected function performAjaxValidation($model,$nameForm){
        if(isset($_POST['ajax']) && $_POST['ajax']==$nameForm){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    } 
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}



