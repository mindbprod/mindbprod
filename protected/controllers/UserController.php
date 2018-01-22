<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
//	public $layout='//layouts/column2';
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
	public function filters()
	{
		return array(
                    'enforcelogin',
//                    'accessControl', // perform access control for CRUD operations
//                    'postOnly + delete', // we only allow deletion via POST request
                        
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
//	public function accessRules()
//	{
//		return array(
//			array('allow',  // allow all users to perform 'index' and 'view' actions
//				'actions'=>array('index','view','registerUser', 'changeState', 'listUsers', 'changePassword'),
//				'users'=>array('*'),
//			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
//			array('deny',  // deny all users
//				'users'=>array('*'),
//			),
//		);
//	}

        
        
        
        
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView(){
            $get=Yii::app()->request->getQuery("iduser");
            $conn=Yii::app()->db;
            $sql="SELECT p.*,u.username,u.active_user,u.id_user FROM user AS u LEFT JOIN person AS p ON u.id_sperson=p.id_sperson WHERE u.username=:iduser";
            $query=$conn->createCommand($sql);
            $query->bindParam(":iduser",$get);
            $read=$query->query();
            $res=$read->read();
            $read->close();
//            print_r($res);exit();
		$this->render('view',array(
			'model'=>$res,
		));
	}
        public function actionViewuser(){
            $id=Yii::app()->request->getQuery("id");
            echo $id.'--------------------'.print_r($_GET);exit();
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_user));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_user));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id){
            $sql="SELECT p.*,u.username,u.active_user,u.id_user FROM user AS u LEFT JOIN person AS p ON u.id_sperson=p.id_sperson WHERE u.username=:iduser";
		$model=User::model()->findBySql($sql,array(":iduser"=>$id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
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
}
