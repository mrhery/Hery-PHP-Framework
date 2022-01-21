<?php
use phpseclib\Crypt\AES;
use phpseclib\Crypt\Random;

class Encrypter{
	public static function AESEncrypt($string, $key, $iv){
		$cipher = new AES(2);
		$cipher->setKey($key);
		$cipher->setIV($iv);
		
		return $cipher->encrypt($string); 
	}
	
	public static function AESDecrypt($string, $key, $iv){
		$cipher = new AES(2);
		$cipher->setKey($key);
		$cipher->setIV($iv);
		
		try{
			return $cipher->decrypt($string);
		}catch(Exception $e){
			return false;
		}
	}
	
	public static function CreateIv(){
		$cipher = new AES(2);
		return Random::string($cipher->getBlockLength() >> 3);
	}
}

?>