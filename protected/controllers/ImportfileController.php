<?php

class ImportfileController extends Controller{
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
        $uploaded = false;
        $dir = Yii::getPathOfAlias('webroot')."/protected/uploads/";
//        echo $dir;
        $model=new ImportFile();
        Yii::import('application.extensions.phpexcelreader.JPhpExcelReader');
        if(isset($_POST['ImportFile'])){
            $model->attributes=$_POST['ImportFile'];
            $file=CUploadedFile::getInstance($model,'file');
//           print_r($file);
//           var_dump($_FILES["ImportFile"]);
//           print_r($_POST);
            if($model->validate()){
                try{
                    $uploaded = $file->saveAs($dir.$file->getName());
                    
                        $data=new JPhpExcelReader($dir.$file->getName());
                    
                    
                    
                    if($data->sheets[0]['numRows']<=2000&&$data->sheets[0]['numRows']>1&&$data->sheets[0]['numCols']<=32&&$data->sheets[0]['numCols']>0){
//                        echo $data->sheets[0]['numRows'];
//                        exit();
                        for($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
                            try{
                                $save=1;
                                $continent="";
                                $country="";
                                $state="";
                                $city="";
                                $companyName="";
                                $companyNumber="";
                                $companyTypei=0;
                                $companyTypeii=0;
                                $companyFestDesc="";//Descripción de la empresa
                                $email=array();
                                $web="";
                                $facebook=array();
                                $twitter="";
                                $instagram="";
                                $googlePl="";
                                $whatsApp="";
                                $address="";
                                $observations="";               
                                $country=trim($data->sheets[0]['cells'][$i][2]);
                                $state=trim($data->sheets[0]['cells'][$i][3]);
                                $city=trim($data->sheets[0]['cells'][$i][4]);
                                $companyNumber=$companyName=trim($data->sheets[0]['cells'][$i][5]);
                                $companyTypei=trim($data->sheets[0]['cells'][$i][6]);
                                if(!empty($data->sheets[0]['cells'][$i][7])){$companyTypeii=trim($data->sheets[0]['cells'][$i][7]);}
                                $companyFestDesc=trim($data->sheets[0]['cells'][$i][8]);
                                for($j=1;$j<=10;$j++){
                                    if(!empty($data->sheets[0]['cells'][$i][$j+8])){
                                        array_push($email,trim($data->sheets[0]['cells'][$i][$j+8]));
                                    }
                                }
                                $web=trim($data->sheets[0]['cells'][$i][19]);
                                for($k=1;$k<=7;$k++){
                                    if(!empty($data->sheets[0]['cells'][$i][$k+19])){
                                        array_push($facebook,trim($data->sheets[0]['cells'][$i][$k+8]));
                                    }
                                }
                                $twitter=trim($data->sheets[0]['cells'][$i][27]);
                                $instagram=trim($data->sheets[0]['cells'][$i][28]);
                                if(!empty($data->sheets[0]['cells'][$i][29])){$googlePl=trim($data->sheets[0]['cells'][$i][29]);}
                                $whatsApp=trim($data->sheets[0]['cells'][$i][30]);
                                $address=trim($data->sheets[0]['cells'][$i][31]);
                                $observations=trim($data->sheets[0]['cells'][$i][32]);
                                $resContinent=$this->setIdContinent(strtoupper($this->removeAccents($continent)));
                                if($resContinent==0){
                                    $save=0;
                                    continue;
                                    
                                }
                                $resCountry=$this->setIdCountry(strtoupper($this->removeAccents($country)),$resContinent);
                                if($resCountry==0){
                                    $save=0;
                                    continue;
                                }
                                
                                $resState=$this->setIdState(strtoupper($this->removeAccents($state)),$resCountry);
                                if($resState==0){
                                    $save=0;
                                    continue;
                                }
//                                echo $resState."--";continue;
                                $resCity=$this->setIdCity(strtoupper($this->removeAccents($city)),$resState);
                                if($resCity==0){
                                    $save=0;
                                    continue;
                                }
                                $modelCompany=new Company();
                                $modelCompany->company_name=$companyName;
                                $modelCompany->company_number=$companyNumber;
                                $modelCompany->company_address=$address;
                                $modelCompany->company_fest_desc=$companyFestDesc;
                                $modelCompany->company_observations=$observations;
                                $modelCompany->id_city=$resCity;
                                if($modelCompany->validate()){
                                    if($modelCompany->save()){
                                        
                                    }
                                    else{
                                        //genera log de no save
                                        
                                    }
                                }
                                else{
                                    //genera log de no save
                                    
                                }
//                                $modelCompany->company_fest_desc=;
                            }
                            catch(CException $e){
                                continue;
                            }
                            //$data->sheets[0]['cells'][$i][1];
                        }
                        Yii::app()->getUser()->setFlash('success','The excel file was successfully imported. --'.$data->sheets[0]['numCols']);
                        $this->refresh();
                    }
                    else{
                        if($data->sheets[0]['numRows']==0){
                            $msn="The file is empty--".$data->sheets[0]['numCols'];

                        }else{
                            $msn="The file must not have more than 2000 records and not have mor than 31 columns  --".$data->sheets[0]['numCols'];
                        }
                        Yii::app()->getUser()->setFlash('error',$msn);
                        $this->refresh();

                    }
                }
                catch(CException $e){
                    Yii::app()->getUser()->setFlash('error',$e->getMessage());
                    $this->refresh();
                }

             }
             else{
                    Yii::app()->getUser()->setFlash('error','Invalid file: type, size or undefined.');
                    $this->refresh();
             }
         }
         else{
             $this->render("importfile",array('model'=>$model));
         }
    }
    public function actionImportfile(){
            $this->render('importfile');
    }
    public function setIdContinent($continent){
       $conn=Yii::app()->db;
       $sql="SELECT id_continent FROM continent WHERE continent_name LIKE :continentname ";
       $search='%'.$continent.'%';
       $query=$conn->createCommand($sql);
       $query->bindParam(":continentname", $search);
       $read=$query->query();
       $res=$read->read();
       $read->close();
       if(!empty($res)){
          return $res["id_continent"]; 
       }
       else{
           $modelContinent=new Continent();
           $modelContinent->continent_code=strtoupper($continent);
           $modelContinent->continent_name=  $modelContinent->continent_code;
           if($modelContinent->validate()){
               if($modelContinent->save()){
                   return $modelContinent->getPrimaryKey();
               }
               else{
                   return 0;
               }
           }
           else{
               return 0;
           }
       }
    }
    public function setIdCountry($country,$idContinent){
       $conn=Yii::app()->db;
       $sql="SELECT id_country FROM country WHERE country_name LIKE :countryname and id_continent=:idcontinent ";
       $search='%%'.$country.'%%';
       $query=$conn->createCommand($sql);
       $query->bindParam(":countryname", $search);
       $query->bindParam(":idcontinent", $idContinent);
       $read=$query->query();
       $res=$read->read();
       $read->close();
       if(!empty($res)){
          return $res["id_country"]; 
       }
       else{
           $modelCountry=new Country();
           $modelCountry->country_code=strtoupper($this->removeAccents($country));
           $modelCountry->country_name=  $modelCountry->country_code;
           $modelCountry->id_continent=$idContinent;
           if($modelCountry->validate()){
               if($modelCountry->save()){
                   return $modelCountry->getPrimaryKey();
               }
               else{
                   return 0;
               }
           }
           else{
               return 0;
           }
       }
    }
    private function setIdState($state,$idCountry){
        $conn=Yii::app()->db;
       $sql="SELECT id_state FROM state WHERE state_name LIKE :statename and id_country=:idcountry ";
       $search='%%'.$state.'%%';
       $query=$conn->createCommand($sql);
       $query->bindParam(":statename", $search);
       $query->bindParam(":idcountry", $idCountry);
       $read=$query->query();
       $res=$read->read();
       $read->close();
       if(!empty($res)){
          return $res["id_state"]; 
       }
       else{
           $modelState=new State();
           $modelState->state_code=strtoupper($this->removeAccents($state));
           $modelState->state_name=  $modelState->state_code;
           $modelState->id_country=$idCountry;
           if($modelState->validate()){
               if($modelState->save()){
                   return $modelState->getPrimaryKey();
               }
               else{
                   return 0;
               }
           }
           else{
               return 0;
           }
       }
    }
    private function setIdCity($city,$idState){
        $conn=Yii::app()->db;
       $sql="SELECT id_city FROM city WHERE city_name LIKE :cityname and id_state=:idstate ";
       $search='%%'.$city.'%%';
       $query=$conn->createCommand($sql);
       $query->bindParam(":cityname", $search);
       $query->bindParam(":idstate", $idState);
       $read=$query->query();
       $res=$read->read();
       $read->close();
       if(!empty($res)){
          return $res["id_city"]; 
       }
       else{
           $modelCity=new City();
           $modelCity->city_code=strtoupper($this->removeAccents($city));
           $modelCity->city_name=  $modelCity->city_code;
           $modelCity->id_state=$idState;
           if($modelCity->validate()){
               if($modelCity->save()){
                   return $modelCity->getPrimaryKey();
               }
               else{
                   return 0;
               }
           }
           else{
               return 0;
           }
       }
    }
    private function removeAccents($str) {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
        return str_replace($a, $b, $str);
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