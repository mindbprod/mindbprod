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
                    if($data->sheets[0]['numRows']<=2000&&$data->sheets[0]['numRows']>1&&$data->sheets[0]['numCols']<=33&&$data->sheets[0]['numCols']>0){
                        $registros=0;
                        for($i = 2; $i <= $data->sheets[0]['numRows']; $i++){
                            if(empty($data->sheets[0]['cells'][$i][1])){
                                break;  
                            }
                            try{
//                                $save=1;
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
                               
                                if(!empty($data->sheets[0]['cells'][$i][6])){$companyName=trim($data->sheets[0]['cells'][$i][6]);}
                                if(!empty($data->sheets[0]['cells'][$i][7])){$companyTypei=trim($data->sheets[0]['cells'][$i][7]);}
                                if(!empty($data->sheets[0]['cells'][$i][8])){$companyTypeii=trim($data->sheets[0]['cells'][$i][8]);}
                                $companyNumber=$companyName;
                                if(!empty($data->sheets[0]['cells'][$i][9])){$companyFestDesc=trim($data->sheets[0]['cells'][$i][9]);}
                                for($j=1;$j<=10;$j++){
                                    if(!empty($data->sheets[0]['cells'][$i][$j+9])){
                                        array_push($email,trim($data->sheets[0]['cells'][$i][$j+9]));
                                    }
                                }
                                if(!empty($data->sheets[0]['cells'][$i][20])){$web=trim($data->sheets[0]['cells'][$i][20]);}
//                                $web=trim($data->sheets[0]['cells'][$i][19]);
                                for($k=1;$k<=7;$k++){
                                    if(!empty($data->sheets[0]['cells'][$i][$k+20])){
                                        array_push($facebook,trim($data->sheets[0]['cells'][$i][$k+20]));
                                    }
                                }
                                if(!empty($data->sheets[0]['cells'][$i][28])){$twitter=trim($data->sheets[0]['cells'][$i][28]);}
                                if(!empty($data->sheets[0]['cells'][$i][29])){$instagram=trim($data->sheets[0]['cells'][$i][29]);}
                                if(!empty($data->sheets[0]['cells'][$i][30])){$googlePl=trim($data->sheets[0]['cells'][$i][30]);}
                                if(!empty($data->sheets[0]['cells'][$i][31])){$whatsApp=trim($data->sheets[0]['cells'][$i][31]);}
                                if(!empty($data->sheets[0]['cells'][$i][32])){$address=trim($data->sheets[0]['cells'][$i][32]);}
                                if(!empty($data->sheets[0]['cells'][$i][33])){$observations=trim($data->sheets[0]['cells'][$i][33]);}
                                
                                $modelUbication=new Ubication();
                                $resContinent="";
                                if(!empty($data->sheets[0]['cells'][$i][2])){
                                    $continent=trim($data->sheets[0]['cells'][$i][2]);
                                    $resContinent=$this->setIdContinent($continent);
                                }
                                $modelUbication->id_continent=$resContinent;
                                $resCountry="";
                                if(!empty($data->sheets[0]['cells'][$i][3])){
                                    $country=trim($data->sheets[0]['cells'][$i][3]);
                                    $resCountry=$this->setIdCountry($country);
                                }
                                $modelUbication->id_country=$resCountry;
                                $resState="";
                                if(!empty($data->sheets[0]['cells'][$i][4])){
                                    $state=trim($data->sheets[0]['cells'][$i][4]);
                                    $resState=$this->setIdState($state);
                                }
                                $modelUbication->id_state=$resState;
                                $resCity="";
                                if(!empty($data->sheets[0]['cells'][$i][5])){
                                    $city=trim($data->sheets[0]['cells'][$i][5]);
                                    $resCity=$this->setIdCity($city);
                                }
                                $modelUbication->id_city=$resCity;
                                $modelCompany=new Company();
                                $modelCompany->company_name=$companyName;
                                $modelCompany->company_number=$companyNumber;
                                $modelCompany->company_address=$address;
                                $modelCompany->company_fest_desc=$companyFestDesc;
                                $modelCompany->company_observations=$observations;
                                if($modelCompany->validate()){
                                    if($modelCompany->save()){
                                        $modelUbication->id_company=$modelCompany->getPrimaryKey();
                                        $modelUbication->save();
                                        if(!empty($companyTypei)){
                                            $ctype=1;
                                            $modelTCompany=new CompanyTcompany();
                                            $modelTCompany->id_typecompany=$ctype;
                                            $modelTCompany->id_company=$modelCompany->getPrimaryKey();
                                            if($modelTCompany->validate()&&$modelTCompany->save()){$vacio;}
                                        }
                                        if(!empty($companyTypeii)){
                                            $ctype=2;
                                            $modelTCompany=new CompanyTcompany();
                                            $modelTCompany->id_typecompany=$ctype;
                                            $modelTCompany->id_company=$modelCompany->getPrimaryKey();
                                            if($modelTCompany->validate()&&$modelTCompany->save()){$vacio;}
                                        }
                                        if(!empty($whatsApp)){
                                            $modelTelephone=new Telephone();
                                            $modelTelephone->id_typetelephone=1;
                                            $modelTelephone->telephone_number=$whatsApp;
                                            $modelTelephone->id_company=$modelCompany->getPrimaryKey();
                                            if($modelTelephone->validate()&&$modelTelephone->save()){$vacios;}
                                        }
                                        if(!empty($web)){
                                            $modelWeb=new Web();
                                            $modelWeb->id_company=$modelCompany->getPrimaryKey();
                                            $modelWeb->web=$web;
                                            if($modelWeb->validate()&&$modelWeb->save()){$vacios;}
                                        }
                                        if(!empty($email)){
                                            foreach($email as $em){
                                                $modelEmail=new Email();
                                                $modelEmail->id_company=$modelCompany->getPrimaryKey();
                                                $modelEmail->email=$em;
                                                if($modelEmail->validate()&&$modelEmail->save()){$vacios;}
                                            }
                                        }
                                        if(!empty($facebook)){
                                            foreach($facebook as $fb){
                                                $modelSNet=new SocialNetwork();
                                                $modelSNet->id_typesnetwork=1;
                                                $modelSNet->id_company=$modelCompany->getPrimaryKey();
                                                $modelSNet->snetwork=$fb;
                                                if($modelSNet->validate()&&$modelSNet->save()){$vacios;}
                                            }
                                        }
                                        if(!empty($twitter)){
                                            $modelSNet=new SocialNetwork();
                                            $modelSNet->id_typesnetwork=2;
                                            $modelSNet->id_company=$modelCompany->getPrimaryKey();
                                            $modelSNet->snetwork=$twitter;
                                            if($modelSNet->validate()&&$modelSNet->save()){$vacios;}
                                        }
                                        if(!empty($instagram)){
                                            $modelSNet=new SocialNetwork();
                                            $modelSNet->id_typesnetwork=3;
                                            $modelSNet->id_company=$modelCompany->getPrimaryKey();
                                            $modelSNet->snetwork=$instagram;
                                            if($modelSNet->validate()&&$modelSNet->save()){$vacios;}
                                        }
                                        if(!empty($googlePl)){
                                            $modelSNet=new SocialNetwork();
                                            $modelSNet->id_typesnetwork=4;
                                            $modelSNet->id_company=$modelCompany->getPrimaryKey();
                                            $modelSNet->snetwork=$googlePl;
                                            if($modelSNet->validate()&&$modelSNet->save()){$vacios;}
                                        }
                                        $registros++;
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
                        Yii::app()->getUser()->setFlash('success','The excel file was successfully imported. Imported records: '.$registros);
                        $this->refresh();
                    }
                    else{
                        if($data->sheets[0]['numRows']==0){
                            $msn="The file is empty--".$data->sheets[0]['numCols'];

                        }else{
                            $msn="The file must not have more than 2000 records and not have mor than 33 columns  --";
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
//        mb_strtoupper($this->removeAccents());
       if(empty($continent)){
           return "";
       }
       $continent=mb_strtoupper($continent);
       $conn=Yii::app()->db;
       $sql="SELECT id_continent FROM continent WHERE UPPER(continent_name) LIKE :continentname ";
       $search='%%'.$continent.'%%';
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
           $modelContinent->continent_code=$this->removeAccents($continent);
           $modelContinent->continent_name=  $continent;
           if($modelContinent->validate()){
               if($modelContinent->save()){
                   return $modelContinent->getPrimaryKey();
               }
               else{
                   return "";
               }
           }
           else{
               return "";
           }
       }
    }
    public function setIdCountry($country){
        if(empty($country)){
           return "";
        }
        $country=mb_strtoupper($country);
       $conn=Yii::app()->db;
       $sql="SELECT id_country FROM country WHERE UPPER(country_name) LIKE :countryname ";
       $search='%%'.$country.'%%';
       $query=$conn->createCommand($sql);
       $query->bindParam(":countryname", $search);
       $read=$query->query();
       $res=$read->read();
       $read->close();
       if(!empty($res)){
          return $res["id_country"]; 
       }
       else{
           $modelCountry=new Country();
           $modelCountry->country_code=$this->removeAccents($country);
           $modelCountry->country_name=  $country;
           if($modelCountry->validate()){
               if($modelCountry->save()){
                   return $modelCountry->getPrimaryKey();
               }
               else{
                   return "";
               }
           }
           else{
               return "";
           }
       }
    }
    private function setIdState($state){
        if(empty($state)){
           return "";
        }
        $state=mb_strtoupper($state);
        $conn=Yii::app()->db;
        $sql="SELECT id_state FROM state WHERE UPPER(state_name) LIKE :statename ";
        $search='%%'.$state.'%%';
        $query=$conn->createCommand($sql);
        $query->bindParam(":statename", $search);
        $read=$query->query();
        $res=$read->read();
        $read->close();
        if(!empty($res)){
           return $res["id_state"]; 
        }
        else{
            $modelState=new State();
            $modelState->state_code=$this->removeAccents($state);
            $modelState->state_name=  $state;
            if($modelState->validate()){
                if($modelState->save()){
                    return $modelState->getPrimaryKey();
                }
                else{
                    return "";
                }
            }
            else{
                return "";
            }
        }
    }
    private function setIdCity($city){
        if(empty($city)){
           return "";
        }
        $city=mb_strtoupper($city);
        $conn=Yii::app()->db;
       $sql="SELECT id_city FROM city WHERE UPPER(city_name) LIKE :cityname ";
       $search='%%'.$city.'%%';
       $query=$conn->createCommand($sql);
       $query->bindParam(":cityname", $search);
       $read=$query->query();
       $res=$read->read();
       $read->close();
       if(!empty($res)){
          return $res["id_city"]; 
       }
       else{
           $modelCity=new City();
           $modelCity->city_code=$this->removeAccents($city);
           $modelCity->city_name=  $city;
           if($modelCity->validate()){
               if($modelCity->save()){
                   return $modelCity->getPrimaryKey();
               }
               else{
                   return "";
               }
           }
           else{
               return "";
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