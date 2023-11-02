<?php
//code made by Alexandr
//created at 1.11.2023
//updated at 1.11.2023
/**
 * create class for authentificator
 */

class auth
{
	public $checkusername='admin';
	public $passwordhash='356880f9d77359ed4407b349ee194107';
	/**
	* function for authentificator
	*/
	public function authentification($token){
		$_SESSION['token']=$token;
		header('Location:index.php?cont=index&table=users');
	}
	/**
	* function for hash password
	*/
	public function hashpassword($password,$username){
		$userhash=md5($password);
		if(($this->passwordhash===$userhash)&&($this->checkusername===$username)){
			$this->authentification('fnjklzxcjirhiyauwandskjbhcda');
		}
	}
	public function logout(){
		$_SESSION['token']='';
		header('Location:index.php');
	}
}
