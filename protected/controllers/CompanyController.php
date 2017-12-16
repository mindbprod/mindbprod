<?php

class CompanyController extends Controller{
    
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
    public function actionIndex(){
            $this->render('index');
    }
    
    public function actionRegisterCompany(){
        if(empty($_POST)){
            $modelCompany=new Company();
            $modelTelephone=new Telephone();
            $modeloEmail=new Email();
            $modelTypeEnt=new CompanyTcompany();
            $typeCompany=  TypeCompany::model()->findAll();
            $modelWeb=new Web();
            $modelSNetw=new SocialNetwork();
            $typeSNetwork=  TypeSnetwork::model()->findAll();
            $modelCountry=new Country();
            $modelState=new State();
            $modelCity=new City();
            $this->render('registercompany',array(
                'modelCompany'=>$modelCompany,
                'modelTelephone'=>$modelTelephone,
                'modeloEmail'=>$modeloEmail,
                'modelTypeEnt'=>$modelTypeEnt,
                'typeCompany'=>$typeCompany,
                'modelWeb'=>$modelWeb,
                'modelSNetw'=>$modelSNetw,
                'typeSNetwork'=>$typeSNetwork,
                'modelCountry'=>$modelCountry,
                'modelState'=>$modelState,
                'modelCity'=>$modelCity
            ));
        }
        else{
            print_r($_POST);
        }
        
    }
//    public function actionRegisterCompany(){
//        print_r($_POST);
//    }
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