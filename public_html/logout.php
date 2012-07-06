<?php
	
	/**
	* Wylogowanie uzytkownika
	*
	* @package logout.php
	* @author Alicja cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 14.04.2012
    * @version 1.0.1 14.04.2012
    */
	
	session_start();
	session_regenerate_id();
	include 'cms.h.php';
	
	if(authorization()){
		
		unset($_SESSION['user']);
		session_destroy();
		
		$site['status']['statements']['operation'][] = "Zostałeś wylogowany";
		$site['content'] = 'statements';
		header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/');
		
	}
	else{
		header('Location: http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/');
	}
	
	screen_site($site);
?>
	