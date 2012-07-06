<?php
	
	/**
	* Funkcje pozwalaj¹ce na autoryzacjê u¿ytkownika
	*
	* @package auth.inc.php
	* @author Alicja cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 14.04.2012
    * @version 1.0.1 14.04.2012
    */
	
	/**
	* Sprawdzanie danych u¿ytkownika do logowania
	*
	* @param array $database Dane potrzebne do kontaktu z baz¹ danych
	* @param string $table Tabela z danymi uzytkownikow
	* @param array $data Dane podane do logowania
	*/
	
	function log_in_user(&$database, $table, &$data){
		
		$result = download_data($database, $table , array('*'), 
				array('Login' => $data['Login'], '(Haslo=md5(\''.$data['Haslo'].'\'))' => 1));
		$result2 = download_data($database, $table , array('*'), 
				array('Email' => $data['Login'], '(Haslo=md5(\''.$data['Haslo'].'\'))' => 1));
		if(count($result)!=1){
			if(count($result2)!=1){
				return false;
			}
			else{
				return current($result2);
			}
		}
		else{
			return current($result);
		}
	}
	
	/**
	* 	Autoryzacja zalogowania u¿ytkownika
	*/
	
	function authorization(){
		
		if(isset($_SESSION['user']) && count($_SESSION['user'])){
			return true;
		}
		else{
			/*$redirect = $_SERVER['PHP_SELF'];
			if(isset($_GET) && count($_GET)){
				$redirect = $redirect.'?';
				foreach($_GET as $key => $value){
					$redirect = $redirect.$key.'='.$value.'&';
				}
			}		
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'login.php';
			header("Refresh:5; url= http://$host$uri/$extra?redirect=$redirect");
			echo "Wymaga Logowania, zaraz zostaniesz tam przekierowany";
			*/
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'login.php';
			//header("Refresh:5; url= http://$host$uri/$extra");
			return false;
		}
	}
	
	/**
	* 	Autoryzacja u¿ytkownika - admina
	*/
	
	function authorization_admin(){
		
		if(isset($_SESSION['user']) && count($_SESSION['user']) && $_SESSION['user']['Typ'] == 'admin'){
			return true;
		}
		else{
			return false;
		}
	}
	