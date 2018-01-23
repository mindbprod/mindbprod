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
        $modelCompany=new Company();
        $modelTelephone=new Telephone();
        $modeloEmail=new Email();
        $modelTypeEnt=new CompanyTcompany();
        $typeCompany=  TypeCompany::model()->findAll();
        $modelWeb=Web::model();
        $modelSNetw=new SocialNetwork();
        $typeSNetwork=  TypeSnetwork::model()->findAll();
        $modelContinent=new Continent();
        $modelCountry=new Country();
        $modelState=new State();
        $modelCity=new City();
        $modelUbication=new Ubication();
        if(empty($_POST)){
            $this->render('registercompany',array(
                'modelCompany'=>$modelCompany,
                'modelTelephone'=>$modelTelephone,
                'modeloEmail'=>$modeloEmail,
                'modelTypeEnt'=>$modelTypeEnt,
                'typeCompany'=>$typeCompany,
                'modelWeb'=>$modelWeb,
                'modelSNetw'=>$modelSNetw,
                'typeSNetwork'=>$typeSNetwork,
                'modelContinent'=>$modelContinent,
                'modelCountry'=>$modelCountry,
                'modelState'=>$modelState,
                'modelCity'=>$modelCity,
                'modelUbication'=>$modelUbication
            ));
        }
        else{
            $modelCompany->attributes=Yii::app()->request->getPost("Company");
            $modelTelephone->attributes=Yii::app()->request->getPost("Telephone");
            $typeEnt=Yii::app()->request->getPost("CompanyTcompany");
            $modelWeb->attributes=Yii::app()->request->getPost("Web");
            $modelContinent->attributes=Yii::app()->request->getPost("Continent");
            $modelCountry->attributes=Yii::app()->request->getPost("Country");
            $modelState->attributes=Yii::app()->request->getPost("State");
            $modelCity->attributes=Yii::app()->request->getPost("City");
            $email=Yii::app()->request->getPost("email");
            $snetw=Yii::app()->request->getPost("snetw");
            $typeSnet=Yii::app()->request->getPost("typesnet");
            $saveContinent=Yii::app()->request->getPost("saveContinent");
            $saveCountry=Yii::app()->request->getPost("saveCountry");
            $saveState=Yii::app()->request->getPost("saveState");
            $saveCity=Yii::app()->request->getPost("saveCity");
            
            $modelSNetwReg=new SocialNetwork();
            if(!empty($typeEnt)){
                $modelTypeEnt->id_company=0;
                $modelTypeEnt->id_typecompany=0;
            }
            else{
                $modelTypeEnt->id_typecompany='';
            }
            if(!empty($email)){
                $modeloEmail->email="aux";
                $modeloEmail->id_email=0;
                $modeloEmail->id_company=0;
            }
            else{
                $modeloEmail->unsetAttributes();
            }
            if(!empty($snetw)&&!empty($typeSnet)){
                $modelSNetwReg->snetwork="aux";
                $modelSNetwReg->id_snetwork=0;
                $modelSNetwReg->id_company=0;
                $modelSNetwReg->id_typesnetwork=0;
            }
            else{
                $modelSNetwReg->unsetAttributes();
            }
            
//            print_r($modelState->attributes);exit();
            if(!empty($modelContinent->continent_name)){
                $modelContinent->continent_code=  trim(strtoupper(preg_replace('/[^A-Za-z0-9]/', "", $modelContinent->continent_name)));
                $modelContinent->continent_name=$modelContinent->continent_code;
            }
            if(!empty($modelCountry->country_name)){
                $modelCountry->country_code=  trim(strtoupper(preg_replace('/[^A-Za-z0-9]/', "", $modelCountry->country_name)));
                $modelCountry->country_name=$modelCountry->country_code;
            }
            if(!empty($modelState->state_name)){
                $modelState->state_code=trim(strtoupper(preg_replace('/[^A-Za-z0-9]/', "", $modelState->state_name)));
                $modelState->state_name= $modelState->state_code;
            }
            if(!empty($modelCity->city_name)){
                $modelCity->city_code=trim(strtoupper(preg_replace('/[^A-Za-z0-9]/', "", $modelCity->city_name)));
                $modelCity->city_name=$modelCity->city_code;
            }
            $this->performAjaxValidation(array($modelCompany,$modelTelephone,$modeloEmail,$modelTypeEnt,$modelSNetwReg),"entityreg-form");
            if($modelCompany->validate()&&$modelTelephone->validate()&&$modelTypeEnt->validate()&&$modeloEmail->validate()&&$modelSNetwReg->validate()){
//                print_r($modelContinent->attributes);
//                print_r($modelCountry->attributes);
//                print_r($modelState->attributes);
//                print_r($modelCity->attributes);
//                echo $saveContinent."<br>";
//                echo $saveCountry."<br>";
//                echo $saveState."<br>";
//                echo $saveCity."<br>";
//                exit();
                
                $transaction=Yii::app()->db->beginTransaction();
                    try{
//                        print_r($_POST);
                        $modelUbication=new Ubication();
                        if(empty($modelContinent->id_continent) && $saveContinent==1){
                            $modelContinentN=new Continent();
                            $modelContinentN->continent_code_code=$modelContinent->continent_code;
                            $modelContinentN->continent_name=$modelCountry->continent_name;
                            $modelContinentN->save();
                            $modelContinent->id_continent=$modelContinentN->getPrimaryKey();
                        }
                        $modelUbication->id_continent=$modelContinent->id_continent;
                        if(empty($modelCountry->id_country) && $saveCountry==1){
                            $modelCountryN=new Country();
                            $modelCountryN->country_code=$modelCountry->country_code;
                            $modelCountryN->country_name=$modelCountry->country_name;
                            $modelCountryN->save();
                            $modelCountry->id_country=$modelCountryN->getPrimaryKey();
                        }
                        $modelUbication->id_country=$modelCountry->id_country;
                        if(empty($modelState->id_state) && $saveState==1){
                            $modelStateN=new State();
                            $modelStateN->state_code=$modelState->state_code;
                            $modelStateN->state_name=$modelState->state_name;
                            $modelStateN->save();
                            $modelState->id_state=$modelStateN->getPrimaryKey();
                        }
                        $modelUbication->id_state=$modelState->id_state;
                        if(empty($modelCity->id_city) && $saveCity==1){
                            $modelCityN=new City();
                            $modelCityN->city_code=$modelCity->city_code;
                            $modelCityN->city_name=$modelCity->city_name;
                            $modelCityN->save();
                            $modelCity->id_city=$modelCityN->getPrimaryKey();
                        }
                        $modelUbication->id_city=$modelCity->id_city;
//                        $modelCompany->id_city=$modelCity->id_city;
                        $modelCompany->save();
                        $modelUbication->id_company=$modelCompany->getPrimaryKey();
                        $modelUbication->save();
                        
                        if(!empty($modelTelephone->telephone_number)){
                            $modelTelephone->id_company=$modelCompany->getPrimaryKey();
                            $modelTelephone->id_typetelephone=1;
                            $modelTelephone->save();
                        }
                        if(!empty($modelWeb->web)){
                            $modelWeb->id_company=$modelCompany->getPrimaryKey();
                            $modelWeb->save();
                        }
                        
                        foreach($email as $em){
                            $modelEmailN=new Email();
                            $modelEmailN->id_company=$modelCompany->getPrimaryKey();
                            $modelEmailN->email=$em;
                            $modelEmailN->save();
                        }
                        foreach($snetw as $pk=>$snet){
                            $modelSNetN=new SocialNetwork();
                            $modelSNetN->id_company=$modelCompany->getPrimaryKey();
                            $modelSNetN->id_typesnetwork=$typeSnet[$pk];
                            $modelSNetN->snetwork=$snet;
                            $modelSNetN->save();
                        }
                        foreach($typeEnt["id_typecompany"] as $tEnt){
                            $modelTCompanyN=new CompanyTcompany();
                            $modelTCompanyN->id_company=$modelCompany->getPrimaryKey();
                            $modelTCompanyN->id_typecompany=$tEnt;
                            $modelTCompanyN->save();
                        }
                        $transaction->commit();
                        $response["status"]="exito";
                    }
                    catch(ErrorException  $e){
                        $transaction->rollback();
                        throw new CHttpException($e->get,$e->getMessage());
                    }catch(CDbException  $e){
                        $transaction->rollback();
                        throw new CHttpException($e->get,$e->getMessage());
                    }
//                
                echo CJSON::encode($response);
//                print_r($_POST);
            }
            else{
                echo CActiveForm::validate(array($modelCompany,$modelTelephone,$modeloEmail,$modelTypeEnt,$modelSNetwReg));                
            }
        }
    }
    public function actionEditDataUbication(){
        $data=Yii::app()->request->getPost("DCmp");
        $dataVal=[];
        parse_str($data["valueContent"], $dataVal);
//        print_r($dataVal);
        $modelContinent=  Continent::model();
        $modelContinent->attributes=$dataVal["Continent"];
        $modelCountry=Country::model();
        $modelCountry->attributes=$dataVal["Country"];
        $modelState=State::model();
        $modelState->attributes=$dataVal["State"];
        $modelCity=City::model();
        $modelCity->attributes=$dataVal["City"];
        $modelCompany=Company::model();
        $saveContinent=$dataVal["saveContinent"];
        $saveCountry=$dataVal["saveCountry"];
        $saveState=$dataVal["saveState"];
        $saveCity=$dataVal["saveCity"];
        if(!empty($modelContinent->continent_name)){
            $modelContinent->continent_code=trim(strtoupper($this->removeAccents( $modelContinent->continent_name)));
            $modelContinent->continent_name=$modelContinent->continent_code;
        }
        if(!empty($modelCountry->country_name)){
            $modelCountry->country_code=  trim(strtoupper($this->removeAccents( $modelCountry->country_name)));
            $modelCountry->country_name= $modelCountry->country_code;
        }
        if(!empty($modelState->state_name)){
            $modelState->state_code=trim(strtoupper($this->removeAccents( $modelState->state_name)));
            $modelState->state_name=$modelState->state_code;
        }
        if(!empty($modelCity->city_name)){
            $modelCity->city_code=trim(strtoupper($this->removeAccents($modelCity->city_name)));
            $modelCity->city_name=$modelCity->city_code;
        }
//        echo $modelCity->city_code;exit();
        if(empty($modelContinent->id_continent) && $saveContinent==0){
            $modelContinent->continent_name=NULL;
        }
        if(empty($modelCountry->id_country) && $saveCountry==0){
            $modelCountry->country_name="";
        }
//            print_r($modelContinent->attributes);
        if(empty($modelState->id_state) && $saveState==0){
            $modelState->state_name="";
        }
//            print_r($modelState->attributes);exit();
//            print_r($modelCity->attributes);
        if(empty($modelCity->id_city) && $saveCity==0){
            $modelCity->city_name="";
        }
        $modelUbication=Ubication::model();
        $ubication=Ubication::model()->findByAttributes(["id_company"=>$data["idCompany"]]);
        $modelUbication->id_ubication=$ubication["id_ubication"];
        $modelUbication->id_company=$data["idCompany"];
        $transaction=Yii::app()->db->beginTransaction();
        try{
            if(empty($modelContinent->id_continent) && $saveContinent==1){
                $modelContinentN=new Continent();
                $modelContinentN->continent_code_code=$modelContinent->continent_code;
                $modelContinentN->continent_name=$modelCountry->continent_name;
                $modelContinentN->save();
                $modelContinent->id_continent=$modelContinentN->getPrimaryKey();
            }
            $modelUbication->id_continent=$modelContinent->id_continent;
            if(empty($modelCountry->id_country) && $saveCountry==1){
                $modelCountryN=new Country();
                $modelCountryN->country_code=$modelCountry->country_code;
                $modelCountryN->country_name=$modelCountry->country_name;
                $modelCountryN->save();
                $modelCountry->id_country=$modelCountryN->getPrimaryKey();
            }
            $modelUbication->id_country=$modelCountry->id_country;
            if(empty($modelState->id_state) && $saveState==1){
                $modelStateN=new State();
                $modelStateN->state_code=$modelState->state_code;
                $modelStateN->state_name=$modelState->state_name;
                $modelStateN->id_country=$modelState->state_name;
                $modelStateN->save();
                $modelState->id_state=$modelStateN->getPrimaryKey();
            }
            $modelUbication->id_state=$modelState->id_state;
            if(empty($modelCity->id_city) && $saveCity==1){
                $modelCityN=new City();
                $modelCityN->city_code=$modelCity->city_code;
                $modelCityN->city_name=$modelCity->city_name;
                $modelCityN->save();
                $modelCity->id_city=$modelCityN->getPrimaryKey();
            }
            $modelUbication->id_city=$modelCity->id_city;
//            print_r($modelUbication->attributes);
            $modelUbication->id_company=$data["idCompany"];
            if($modelUbication->save()){
                $transaction->commit();
            }
            else{
                $response["status"]="noexito";
            }
            $response["status"]="exito";
        }
        catch(ErrorException $e){
            $transaction->rollback();
            $response["status"]="noexito";
        }catch(CDbException $e){
            $transaction->rollback();
            $response["status"]="noexito";
        }
        echo CJSON::encode($response);
    }
    private function removeAccents($str) {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
        return str_replace($a, $b, $str);
    }
    /*
     * Guardar datos editados de compañía
     */
    public function actionEditDataCompany(){
        $data=Yii::app()->request->getPost("DCmp");
//        print_r($data);
        $tableName="";
        $columnName="";
        $updAct=true;
        switch ($data["tableName"]){
            case "company":
                $modelCompany= Company::model();
                $company=$modelCompany->findByPk($data["idCompany"]);
//                $modelCompany->id_company=$data["idCompany"];
                switch ($data["columnName"]){
                    case "company_name":
                        $company->company_name=$data["valueContent"];
                    break;
                    case "company_number":
                        $company->company_number=$data["valueContent"];
                    break;
                    case "company_address":
                        $company->company_address=$data["valueContent"];
                    break;
                    case "company_fest_desc":
                        $company->company_fest_desc=$data["valueContent"];
                    break;
                    case "company_observations":
                        $company->company_observations=$data["valueContent"];
                    break;
                }
                if($company->update()){
                    $msn="exito";
                }
                else{
                    $msn="noexito";
                }
                $response["status"]=$msn;
                echo CJSON::encode($response);
                exit();
            break;
            case "telephone":
                $tableName="telephone";
                $columnName="telephone_number";
                if(!empty($data["valueContent"])){
                    $modelTelephone= Telephone::model();
                    $telephone=$modelTelephone->findByAttributes(array("id_company"=>$data["idCompany"]));
                    if(empty($telephone)){
                        $modelTelephone=new Telephone();
                        $modelTelephone->id_company=$data["idCompany"];
                        $modelTelephone->telephone_number=$data["valueContent"];
                        if($modelTelephone->save()){
                            $msn="exito";
                        }
                    }
                    else{
                        $modelTelephone->id_company=$data["idCompany"];
                        $modelTelephone->telephone_number=$data["valueContent"];
                        $modelTelephone->update();
                        $msn="exito";
                    }
                } 
                else{
                    $msn="noexito";
                }
                $response["status"]=$msn;
                echo CJSON::encode($response);
                exit();
            break;
            case "web":
                $tableName="web";
                $columnName="web";
                if(!empty($data["valueContent"])){
                    $modelWeb= Web::model();
                    $web=$modelWeb->findByAttributes(array("id_company"=>$data["idCompany"]));
                    if(empty($web)){
                        $modelWeb=new Web();
                        $modelWeb->id_company=$data["idCompany"];
                        $modelWeb->web=$data["valueContent"];
                        if($modelWeb->save()){
                            $msn="exito";
                        }
                    }
                    else{
                        $web->id_company=$data["idCompany"];
                        $web->web=$data["valueContent"];
                        $web->update();
                        $msn="exito";
                    }
                }
                else{
                    $msn="noexito";
                }
                $response["status"]=$msn;
                echo CJSON::encode($response);
                exit();
            break;
            case "email":
                $tableName="email";
                $columname="email";
                $dataVal=[];
                parse_str($data["valueContent"], $dataVal);
//                print_r($dataVal);exit();
                $this->saveDataEmailSn($tableName,$columname,$data["idCompany"],$dataVal);
            break;
            case "social_network":
                $dataVal=[];
                parse_str($data["valueContent"], $dataVal);
//                print_r($dataVal,$dataVal);exit();
                $this->saveDataSnet($data["idCompany"],$dataVal);
            break;
            case "company_tcompany":
                $tableName="company_tcompany";
                $columname="id_typecompany";
                $dataVal=[];
                parse_str($data["valueContent"], $dataVal);
//                print_r($dataVal);exit();
                $this->saveDataTyCompany($data["idCompany"],$dataVal);
            break;
        }
    }
    public function saveDataEmailSn($tableName,$columname,$idCompany,$valueContent){
        if(!empty($valueContent)&&!empty($idCompany)){
            $conn=Yii::app()->db;
            $transaction=Yii::app()->db->beginTransaction();
            try{
                $sqlDel="DELETE FROM email WHERE id_company=:id_company";
                $query=$conn->createCommand($sqlDel);
                $query->bindParam(":id_company",$idCompany);
                $query->execute();
                foreach($valueContent["email"] as $val){
                    $modelEmail=new Email();
                    $modelEmail->id_company=$idCompany;
                    $modelEmail->email=$val;
                    $modelEmail->save();
                }
                $transaction->commit();
                $response["status"]="exito";
            }
            catch(ErrorException $e){
                $transaction->rollback();
                $response["status"]= "noexito";
            }
        }
        else{
            $response["status"]="noexito";
        }
        echo CJSON::encode($response);
        exit();
    }
    private function saveDataTyCompany($idCompany,$dataVal){
        if(!empty($dataVal)&&!empty($idCompany)){
            $conn=Yii::app()->db;
            $transaction=Yii::app()->db->beginTransaction();
            try{
                $sqlDel="DELETE FROM company_tcompany WHERE id_company=:id_company";
                $query=$conn->createCommand($sqlDel);
                $query->bindParam(":id_company",$idCompany);
                $query->execute();
                foreach($dataVal["company_type"] as $val){
                    $modelTyCompany=new CompanyTcompany();
                    $modelTyCompany->id_company=$idCompany;
                    $modelTyCompany->id_typecompany=$val;
                    $modelTyCompany->save();
                }
                $transaction->commit();
                $response["status"]="exito";
            }
            catch(ErrorException $e){
                $transaction->rollback();
                $response["status"]= "noexito";
            }
        }
        else{
            $response["status"]="noexito";
        }
        echo CJSON::encode($response);
        exit();
    }
    public function saveDataSnet($idCompany,$valueContent){
        if(!empty($valueContent)&&!empty($idCompany)){
            $conn=Yii::app()->db;
            $transaction=Yii::app()->db->beginTransaction();
            try{
                $sqlDel="DELETE FROM social_network WHERE id_company=:id_company";
                $query=$conn->createCommand($sqlDel);
                $query->bindParam(":id_company",$idCompany);
                $query->execute();
                $sql="INSERT INTO social_network (id_company,id_typesnetwork,snetwork) VALUES (:id_company,:typesnet,:snetwork) ";
                foreach($valueContent["snetw"] as $pk=>$val){
                    $modelSNetwork= new SocialNetwork();
                    $modelSNetwork->id_company=id_company;
                    $modelSNetwork->id_typesnetwork=$valueContent["typesnet"][$pk];
                    $modelSNetwork->snetwork=$val;
                    $modelSNetwork->save();
                }
                $transaction->commit();
                $response["status"]="exito";
            }
            catch(ErrorException $e){
                $transaction->rollback();
                $response["status"]= "noexito";
            }
        }
        else{
            $response["status"]="noexito";
        }
        echo CJSON::encode($response);
        exit();
    }
    
    public function actionShowEditcompany(){
        $modelCompany=new Company();
        $modelTelephone=new Telephone();
        $modeloEmail=new Email();
        $modelTypeEnt=new CompanyTcompany();
        $typeCompany=  TypeCompany::model()->findAll();
        $modelWeb=new Web();
        $modelSNetw=new SocialNetwork();
        $typeSNetwork=  TypeSnetwork::model()->findAll();
        $modelContinent=new Continent();
        $modelCountry=new Country();
        $modelState=new State();
        $modelCity=new City();
            $this->render('showeditcompany',array(
                'modelCompany'=>$modelCompany,
                'modelTelephone'=>$modelTelephone,
                'modeloEmail'=>$modeloEmail,
                'modelTypeEnt'=>$modelTypeEnt,
                'typeCompany'=>$typeCompany,
                'modelWeb'=>$modelWeb,
                'modelSNetw'=>$modelSNetw,
                'typeSNetwork'=>$typeSNetwork,
                'modelContinent'=>$modelContinent,
                'modelCountry'=>$modelCountry,
                'modelState'=>$modelState,
                'modelCity'=>$modelCity
            ));
        
        
    }
    public function actionSearchDataCompany(){
        $conn=Yii::app()->db;
        $data=  $_POST;
//        print_r($data);exit();
        $columns="";
        $sql="SELECT *,a.id_company FROM company AS a "
                . "LEFT JOIN ubication AS b ON b.id_company=a.id_company "
                . "LEFT JOIN telephone AS c ON c.id_company=a.id_company "
                . "LEFT JOIN web AS d ON d.id_company=a.id_company "
                . "LEFT JOIN email AS e ON e.id_company=a.id_company "
                . "LEFT JOIN social_network AS f on f.id_company=a.id_company "
                . "LEFT JOIN company_tcompany AS g on g.id_company=a.id_company "
                . "LEFT JOIN state AS h ON h.id_state=b.id_state "
                . "LEFT JOIN country AS i ON i.id_country=b.id_country "
                . "LEFT JOIN continent AS j ON j.id_continent=b.id_continent "
                . "LEFT JOIN city AS k ON k.id_city=b.id_city ";
//        if(isset($data["chCmp"])||isset($data["chTl"])||isset($data["chWeb"])||isset($data["chEm"])||isset($data["chSN"])){
            $searchCriteria=" WHERE ";
//        }
        $sql.=$searchCriteria;
        $dataSearch="";
        if(isset($data["chCmp"])&&!empty($data["chCmp"])){
            $ori=$orii=$oriii=$oriv=$orv=$orvi="";
            if(isset($data["Company"]["company_name"])&&!empty($data["Company"]["company_name"])){$dataSearch.=" a.company_name LIKE :company_name ";$ori=" AND ";}
            if(isset($data["Company"]["company_number"])&&!empty($data["Company"]["company_number"])){$dataSearch.=$ori." a.company_number LIKE :company_number ";$orii=" AND ";}
            if(isset($data["Company"]["company_address"])&&!empty($data["Company"]["company_address"])){if(!empty($ori)||!empty($orii)){$oriii=" AND ";}$dataSearch.=$oriii." a.company_address LIKE :company_address ";$oriii=" AND ";}
            if(isset($data["Company"]["company_fest_desc"])&&!empty($data["Company"]["company_fest_desc"])){if(!empty($ori)||!empty($orii)||!empty($oriii)){$oriv=" AND ";}$dataSearch.=$oriv." a.company_fest_desc LIKE :company_fest_desc ";$oriv=" AND ";}
            if(isset($data["Company"]["id_country"])&&!empty($data["Company"]["id_country"])){if(!empty($ori)||!empty($orii)||!empty($oriii)||!empty($oriv)){$orv=" AND ";}$dataSearch.=$orv." b.id_country = :id_country ";$orv=" AND ";}           
            if(isset($data["Company"]["id_city"])&&!empty($data["Company"]["id_city"])){if(!empty($ori)||!empty($orii)||!empty($oriii)||!empty($oriv)){$orvi=" AND ";}$dataSearch.=$orvi." b.id_city = :id_city ";$orvi=" AND ";}           
            if(isset($data["Company"]["company_type"])){
                foreach($data["Company"]["company_type"] as $pk=>$cptype){
                    if(!empty($ori)||!empty($orii)||!empty($oriii)||!empty($oriv)||!empty($orv)||!empty($orvi)){
                        $orvii=" AND ";
                    }
                    $var=":id_typecompani".$pk;
                    $dataSearch.=$orvii." g.id_typecompany=".$var;
                    $orvii=" AND ";
                }
            }
        }
        
        if(isset($data["chTl"])&&!empty($data["chTl"])){
            $orviii="";
            if(isset($data["Telephone"]["number"])&&!empty($data["Telephone"]["number"])){if(!empty($ori)||!empty($orii)||!empty($oriii)||!empty($oriv)||!empty($orv)||!empty($orvi)||!empty($orvii)){$orviii=" AND ";}$dataSearch.=$orviii." c.telephone_number LIKE :telephone_number ";$orviii=" AND ";}           
         }
         
         if(isset($data["chWeb"])&&!empty($data["chWeb"])){
            $orix="";
            if(isset($data["Web"]["web"])&&!empty($data["Web"]["web"])){if(!empty($ori)||!empty($orii)||!empty($oriii)||!empty($oriv)||!empty($orv)||!empty($orvi)||!empty($orvii)||!empty($orviii)){$orix=" AND ";}$dataSearch.=$orix." d.web LIKE :web ";$orix=" AND ";}           
         }
         if(isset($data["chEm"])&&!empty($data["chEm"])){
            $orx="";
            if(isset($data["Email"]["email"])&&!empty($data["Email"]["email"])){if(!empty($ori)||!empty($orii)||!empty($oriii)||!empty($oriv)||!empty($orv)||!empty($orvi)||!empty($orvii)||!empty($orviii)|!empty($orix)){$orx=" AND ";}$dataSearch.=$orx." e.email LIKE :email ";$orx=" AND ";}           
         }
         if(isset($data["chSN"])&&!empty($data["chSN"])){
            $orxi="";
            if(isset($data["Socialnetwork"]["snetwork"])&&!empty($data["Socialnetwork"]["snetwork"])){if(!empty($ori)||!empty($orii)||!empty($oriii)||!empty($oriv)||!empty($orv)||!empty($orvi)||!empty($orvii)||!empty($orviii)||!empty($orix)||!empty($orx)){$orxi=" AND ";}$dataSearch.=$orxi." f.snetwork LIKE :snetwork ";$orxi=" AND ";}           
         }
         $orFin="";
         if(!empty($ori)||!empty($orii)||!empty($oriii)||!empty($oriv)||!empty($orv)||!empty($orvi)||!empty($orvii)||!empty($orviii)||!empty($orix)||!empty($orx)||!empty($orxi)){
             $orFin=" AND ";
         }
        $sql.=$dataSearch.$orFin."  a.id_company IS NOT NULL GROUP BY a.id_company ";
//        echo $sql;exit();
//        echo $sql;exit();
        $query=$conn->createCommand($sql);
        if(isset($data["chCmp"])&&!empty($data["chCmp"])){
            if(isset($data["Company"]["company_name"])&&!empty($data["Company"]["company_name"])){$data["Company"]["company_name"]='%%'.$data["Company"]["company_name"].'%%';$query->bindParam(":company_name", $data["Company"]["company_name"]);}
            if(isset($data["Company"]["company_number"])&&!empty($data["Company"]["company_number"])){$data["Company"]["company_number"]='%%'.$data["Company"]["company_number"].'%%';$query->bindParam(":company_number", $data["Company"]["company_number"]);}
            if(isset($data["Company"]["company_address"])&&!empty($data["Company"]["company_address"])){$data["Company"]["company_address"]='%%'.$data["Company"]["company_address"].'%%';$query->bindParam(":company_address", $data["Company"]["company_address"]);}
            if(isset($data["Company"]["company_fest_desc"])&&!empty($data["Company"]["company_fest_desc"])){$data["Company"]["company_fest_desc"]='%%'.$data["Company"]["company_fest_desc"].'%%';$query->bindParam(":company_fest_desc", $data["Company"]["company_fest_desc"]);}
            if(isset($data["Company"]["id_country"])&&!empty($data["Company"]["id_country"])){$query->bindParam(":id_country", $data["Company"]["id_country"]);}
            if(isset($data["Company"]["id_city"])&&!empty($data["Company"]["id_city"])){$query->bindParam(":id_city", $data["Company"]["id_city"]);}
            if(isset($data["Company"]["company_type"])){
                foreach($data["Company"]["company_type"] as $pk=>$cptype){
                    $var=":id_typecompani".$pk;
                    $query->bindParam($var,$cptype);
                }
            }
        }
         if(isset($data["chTl"])&&!empty($data["chTl"])){
            if(isset($data["Telephone"]["number"])&&!empty($data["Telephone"]["number"])){
                $data["Telephone"]["number"]='%%'.$data["Telephone"]["number"].'%%';
                $query->bindParam(":telephone_number", $data["Telephone"]["number"]);
            }           
         }
        if(isset($data["chWeb"])&&!empty($data["chWeb"])){
            if(isset($data["Web"]["web"])&&!empty($data["Web"]["web"])){
                $data["Web"]["web"]='%%'.$data["Web"]["web"].'%%';
                $query->bindParam(":web", $data["Web"]["web"]);
            }         
         }
        if(isset($data["chEm"])&&!empty($data["chEm"])){
            if(isset($data["Email"]["email"])&&!empty($data["Email"]["email"])){
                $data["Email"]["email"]='%%'.$data["Email"]["email"].'%%';
                $query->bindParam(":email", $data["Email"]["email"]);
            }
        }
        if(isset($data["chSN"])&&!empty($data["chSN"])){
            if(isset($data["Socialnetwork"]["snetwork"])&&!empty($data["Socialnetwork"]["snetwork"])){
                $data["Socialnetwork"]["snetwork"]='%%'.$data["Socialnetwork"]["snetwork"].'%%';
                $query->bindParam(":snetwork", $data["Socialnetwork"]["snetwork"]);
            }
        }
//  if(isset($data["Telephone"]["number"])&&!empty($data["Telephone"]["number"])){$dataSearch.=" d.web LIKE :web ";$ori=" AND ";}
        
        
        $read=$query->query();
        $res=$read->readAll();
        $read->close();
        if(!empty($res)){
            foreach($res as $pk=>$row){
                $sql="SELECT email FROM email WHERE id_company=:id_company";
                $queryE=$conn->createCommand($sql);
                $queryE->bindParam(":id_company", $row["id_company"]);
                $readE=$queryE->query();
                $resE=$readE->readAll();
                $readE->close();
                $res[$pk]["emails"]=$resE;
                
                $sql="SELECT snetwork,typesnetwork_name,a.id_typesnetwork FROM social_network AS a LEFT JOIN type_snetwork AS b ON b.id_typesnetwork = a.id_typesnetwork WHERE id_company=:id_company";
                $querySn=$conn->createCommand($sql);
                $querySn->bindParam(":id_company", $row["id_company"]);
                $readSn=$querySn->query();
                $resSn=$readSn->readAll();
                $readSn->close();
                $res[$pk]["snewtorks"]=$resSn;
                
                $sql="SELECT typecompany_name,a.id_typecompany FROM company_tcompany AS a LEFT JOIN type_company AS b ON b.id_typecompany=a.id_typecompany WHERE id_company=:id_company";
                $queryTC=$conn->createCommand($sql);
                $queryTC->bindParam(":id_company", $row["id_company"]);
                $readTC=$queryTC->query();
                $resTC=$readTC->readAll();
                $readTC->close();
                $res[$pk]["tcompanys"]=$resTC;
                
            }
        }
        
        
        $response['data']=$res;
        $response["status"]="exito";
        echo CJSON::encode($response);
    }
     /*
    * Devuelve el listado de continentes halla según lo digitado en el campo.
    *
    * @param type $continent captura el string digitado para realizar filtro por continentes
    *
    * @return $display_json Listado de continentes en formato json
    */
    public function actionSearchContinent(){
        $stringContinent=Yii::app()->request->getPost("stringcontinent");
        $json_arr=[];
        $display_json=[];
//        $model= Beca::model();
        $continents=$this->searchContinentScript($stringContinent);//->searchCountryScript($_POST["stringtitulo"]);
        if(!empty($continents)){
            foreach($continents as $continent){
                $json_arr["id"] = $continent["id_continent"];
                $json_arr["value"] = $continent["continent_name"];
                $json_arr["label"] = $continent["continent_name"];
                array_push($display_json, $json_arr);
            }
        }
        else{
            $json_arr["id"] = "#";
            $json_arr["value"] = $stringContinent;
            $json_arr["label"] = "No hay resultados, desea agregar ".$stringContinent."?";
            array_push($display_json, $json_arr);
        }
        echo CJSON::encode($display_json);
    }
    
    /**
    * Devuelve el listado de continentes.
    *
    * @param type $continent variable del modelo que guarda el string digitado en campo en vista beca.php
    *
    * @return $result array de continentes
    */
    public function searchContinentScript($continent){
        $conect= Yii::app()->db;
        $searchItem=  strtoupper($continent);
        $sql="SELECT * FROM continent WHERE (continent_name LIKE :param1)
            or (continent_name LIKE :param2)
            or (continent_name LIKE :param3)
            or (continent_name LIKE :param4) order by continent_name asc limit 10";
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
    /*
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
        $sql="SELECT * FROM country WHERE ((country_name LIKE :param1)
            or (country_name LIKE :param2)
            or (country_name LIKE :param3)
            or (country_name LIKE :param4)) order by country_name asc limit 10";
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
        $json_arr=[];
        $display_json=[];
//        $model= Beca::model();
        $states=$this->searchStateScript($stringState);//->searchCountryScript($_POST["stringtitulo"]);
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
    public function searchStateScript($searchItem){
        $conect= Yii::app()->db;
        $item=  strtoupper($searchItem);
        $sql="SELECT * FROM state WHERE ((state_name LIKE :param1)
            OR (state_name LIKE :param2)
            OR (state_name LIKE :param3)
            OR (state_name LIKE :param4)) ORDER BY state_name asc limit 10";
        $query=$conect->createCommand($sql);
        $param1='%%'.$item.'%%';
        $param2='%%'.$item;
        $param3=$item.'%%';
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
        $json_arr=[];
        $display_json=[];
//        $model= Beca::model();
        $cities=$this->searchCityScript($stringCity);//->searchCountryScript($_POST["stringtitulo"]);
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
    public function searchCityScript($searchItem){
        $conect= Yii::app()->db;
        $item=  strtoupper($searchItem);
        $sql="SELECT * FROM city WHERE ((city_name LIKE :param1)
            OR (city_name LIKE :param2)
            OR (city_name LIKE :param3)
            OR (city_name LIKE :param4)) ORDER BY city_name asc limit 10";
        $query=$conect->createCommand($sql);
        $param1='%%'.$item.'%%';
        $param2='%%'.$item;
        $param3=$item.'%%';
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
    public function actionSearchCitySearch(){
        $stringCity=Yii::app()->request->getPost("stringcity");
        $json_arr=[];
        $display_json=[];
//        $model= Beca::model();
        $cities=$this->searchCityScriptSearhc($stringCity);//->searchCountryScript($_POST["stringtitulo"]);
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
    public function searchCityScriptSearhc($searchItem){
        $conect= Yii::app()->db;
        $item=  strtoupper($searchItem);
        $sql="SELECT * FROM city WHERE (city_name LIKE :param1)
            OR (city_name LIKE :param2)
            OR (city_name LIKE :param3)
            OR (city_name LIKE :param4) ORDER BY city_name asc";
        $query=$conect->createCommand($sql);
        $param1='%%'.$item.'%%';
        $param2='%%'.$item;
        $param3=$item.'%%';
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