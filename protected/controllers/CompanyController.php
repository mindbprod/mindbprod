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
    
    
    /**
    * Devuelve el listado de paises halla según lo digitado en el campo.
    *
    * @param type $country captura el string digitado para realizar filtro por paises
    *
    * @return $display_json Listado de countries en formato json
    */
    public function actionSearchCountry(){
        $stringCountry=Yii::app()->request->getPost("stringcountry");
        $json_arr=[];
        $display_json=[];
//        $model= Beca::model();
        $countries=$this->searchCountryScript($stringCountry);//->searchCountryScript($_POST["stringtitulo"]);
        if(!empty($countries)){
            foreach($countries as $country){
                $json_arr["id"] = $country["id_country"];
                $json_arr["value"] = $country["country_name"];
                $json_arr["label"] = $country["country_name"];
                array_push($display_json, $json_arr);
            }
        }
        else{
            $json_arr["id"] = "#";
            $json_arr["value"] = $stringCountry;
            $json_arr["label"] = "No hay resultados, desea agregar ".$stringCountry."?";
            array_push($display_json, $json_arr);
        }
        echo CJSON::encode($display_json);
    }
    
    /**
    * Devuelve el listado de títulos de grado de las becas.
    *
    * @param type $country variable del modelo que guarda el string digitado en campo en vista beca.php
    *
    * @return $result array de títulos de grado
    */
    public function searchCountryScript($country){
        $conect= Yii::app()->db;
        $searchItem=  strtoupper($country);
        $sql="SELECT * FROM country WHERE (country_name LIKE :param1)
            or (country_name LIKE :param2)
            or (country_name LIKE :param3)
            or (country_name LIKE :param4) order by country_name asc";
        $query=$conect->createCommand($sql);
        $param1='%%'.$searchItem.'%%';
        $param2='%%'.$searchItem;
        $param3=$searchItem.'%%';
        $query->bindParam(':param1',$param1,PDO::PARAM_STR);
        $query->bindParam(':param2',$param2,PDO::PARAM_STR);
        $query->bindParam(':param3',$param3,PDO::PARAM_STR);
        $query->bindParam(':param4',$searchItem,PDO::PARAM_STR);
        $read=$query->query();
        $result=$read->readAll();
        $read->close();			
        return $result;
    }
        
    /**
    * Devuelve el listado de estados o departamentos que halla según lo digitado en el campo.
    *
    * @param type $state captura el string digitado para realizar filtro por estados o departamentos
    *
    * @return $display_json Listado de states en formato json
    */
    public function actionSearchState(){
        $stringState=Yii::app()->request->getPost("stringstate");
        $idcountry=Yii::app()->request->getPost("idcountry");
        $json_arr=[];
        $display_json=[];
//        $model= Beca::model();
        $states=$this->searchStateScript($stringState,$idcountry);//->searchCountryScript($_POST["stringtitulo"]);
        if(!empty($states)){
            foreach($states as $state){
                $json_arr["id"] = $state["id_state"];
                $json_arr["value"] = $state["state_name"];
                $json_arr["label"] = $state["state_name"];
                array_push($display_json, $json_arr);
            }
        }
        else{
            $json_arr["id"] = "#";
            $json_arr["value"] = $stringState;
            $json_arr["label"] = "No hay resultados, desea agregar ".$stringState."?";
            array_push($display_json, $json_arr);
        }
        echo CJSON::encode($display_json);
    }    
    /**
    * Devuelve el listado de estados o departamentos.
    *
    * @param $searchItem,$conditionItem
    *
    * @return $result array de ciudades de grado
    */
    public function searchStateScript($searchItem,$conditionItem){
        $conect= Yii::app()->db;
        $item=  strtoupper($searchItem);
        $sql="SELECT * FROM state WHERE id_country=:idcountry AND ((state_name LIKE :param1)
            OR (state_name LIKE :param2)
            OR (state_name LIKE :param3)
            OR (state_name LIKE :param4)) ORDER BY state_name asc";
        $query=$conect->createCommand($sql);
        $param1='%%'.$item.'%%';
        $param2='%%'.$item;
        $param3=$item.'%%';
        $query->bindParam(':idcountry',$conditionItem,PDO::PARAM_INT);
        $query->bindParam(':param1',$param1,PDO::PARAM_STR);
        $query->bindParam(':param2',$param2,PDO::PARAM_STR);
        $query->bindParam(':param3',$param3,PDO::PARAM_STR);
        $query->bindParam(':param4',$item,PDO::PARAM_STR);
        $read=$query->query();
        $result=$read->readAll();
        $read->close();			
        return $result;
    }  
 /**
    * Devuelve el listado de estados o departamentos que halla según lo digitado en el campo.
    *
    * @param type $state captura el string digitado para realizar filtro por estados o departamentos
    *
    * @return $display_json Listado de states en formato json
    */
    public function actionSearchCity(){
        $stringCity=Yii::app()->request->getPost("stringcity");
        $idstate=Yii::app()->request->getPost("idstate");
        $json_arr=[];
        $display_json=[];
//        $model= Beca::model();
        $cities=$this->searchCityScript($stringCity,$idstate);//->searchCountryScript($_POST["stringtitulo"]);
        if(!empty($cities)){
            foreach($cities as $city){
                $json_arr["id"] = $city["id_city"];
                $json_arr["value"] = $city["city_name"];
                $json_arr["label"] = $city["city_name"];
                array_push($display_json, $json_arr);
            }
        }
        else{
            $json_arr["id"] = "#";
            $json_arr["value"] = $stringCity;
            $json_arr["label"] = "No hay resultados, desea agregar ".$stringCity."?";
            array_push($display_json, $json_arr);
        }
        echo CJSON::encode($display_json);
    }    
    /**
    * Devuelve el listado de estados o departamentos.
    *
    * @param $searchItem,$conditionItem
    *
    * @return $result array de ciudades de grado
    */
    public function searchCityScript($searchItem,$conditionItem){
        $conect= Yii::app()->db;
        $item=  strtoupper($searchItem);
        $sql="SELECT * FROM city WHERE id_state=:idstate AND ((city_name LIKE :param1)
            OR (city_name LIKE :param2)
            OR (city_name LIKE :param3)
            OR (city_name LIKE :param4)) ORDER BY city_name asc";
        $query=$conect->createCommand($sql);
        $param1='%%'.$item.'%%';
        $param2='%%'.$item;
        $param3=$item.'%%';
        $query->bindParam(':idstate',$conditionItem,PDO::PARAM_INT);
        $query->bindParam(':param1',$param1,PDO::PARAM_STR);
        $query->bindParam(':param2',$param2,PDO::PARAM_STR);
        $query->bindParam(':param3',$param3,PDO::PARAM_STR);
        $query->bindParam(':param4',$item,PDO::PARAM_STR);
        $read=$query->query();
        $result=$read->readAll();
        $read->close();			
        return $result;
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