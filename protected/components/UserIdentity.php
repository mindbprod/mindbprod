<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
//    private $keyString="_.$|°p8";
    public function authenticate(){
        $criteria = new CDbCriteria;
        $criteria->select = 'password,id_sperson,id_typeuser';
        $userFromDb=  User::model()->findByAttributes(array('username'=>$this->username),$criteria);
        
        if(!is_object($userFromDb) && !isset($userFromDb->username)){
                $this->errorCode=self::ERROR_USERNAME_INVALID;
        }
        else{
            $verifyPass=$this->verifyPassword($userFromDb->password,$this->password);
            if(!$verifyPass){
                $this->errorCode=self::ERROR_PASSWORD_INVALID;
            }
            else{
                $this->errorCode=self::ERROR_NONE;
                $modelPerson=  Person::model()->findByPk($userFromDb->id_sperson);
                $modelTypeUser= TypeUser::model()->findByPk($userFromDb->id_typeuser);
                Yii::app()->user->setState('nombrePerson',$modelPerson->person_name." ".$modelPerson->person_lastname);
                Yii::app()->user->setState('nombreUsuario',$this->username);
                Yii::app()->user->setState('nombreRole',$modelTypeUser->typeuser_name);
                Yii::app()->user->setState('codeRole',$modelTypeUser->typeuser_code);
                
            }
        }
        return !$this->errorCode;
    }
    private function verifyPassword($passHash,$passwordForm){
//        if (password_verify($passwordForm, $passHash)) {
        if ($passwordForm==$passHash) {
            return true;
        } else {
            return false;
        }
    }
//    private function cryptPassword($password){
//        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
//        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM );
//        mcrypt_generic_init($td, $this->keyString, $iv);
//        $encrypted_data_bin = mcrypt_generic($td, $password);
//        mcrypt_generic_deinit($td);
//        mcrypt_module_close($td);
//        $encrypted_data_hex = bin2hex($iv).bin2hex($encrypted_data_bin);
//        return $encrypted_data_hex;
//    }
//    private function decryptPassword($password){
//        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
//        $iv_size_hex = mcrypt_enc_get_iv_size($td)*2;
//        $iv = pack("H*", substr($password, 0, $iv_size_hex));
//        $encrypted_data_bin = pack("H*", substr($password, $iv_size_hex));
//        mcrypt_generic_init($td, $this->keyString, $iv);
//        $decrypted = mdecrypt_generic($td, $encrypted_data_bin);
//        mcrypt_generic_deinit($td);
//        mcrypt_module_close($td);
//        return $decrypted;
//    }
}