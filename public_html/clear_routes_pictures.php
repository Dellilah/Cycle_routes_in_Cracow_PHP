<?php
	
	/**
	* Usuwanie wszystkich zdjęć danej trasy
	*
	* @package clear_routes_pictures.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 07.06.2012
    * @version 1.0.1 07.06.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	$path = 'fx/bitmapy';
	$site['status']['statements']['operation'] = array();
	
	$_SESSION['last'] = 'clear_routes_pictures.php?idTrasa='.$_GET['idTrasa'];
	
	if(authorization_admin()){
		
		if(isset($_GET) && isset($_GET['idTrasa'])){
			
			$site['data'] = download_from_form(array('idTrasa'), $_GET);
			
			if(delete_data($sql, 'Zdjecie', array('Trasa_idTrasa' => $site['data']['idTrasa']))){
								
				foreach(glob($path . '/Trasa_'.$site['data']['idTrasa']) as $dir) {
					
					rmdirr($dir);
					$site['status']['statements']['operation'][] = "Usunięto wszystkie zdjęcia trasy ";
					$site['content'] = 'statements';
					$site['forward'] = 'strony trasy';
					header("Refresh: 5, url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa=".$_GET['idTrasa']);
					
				}
			}
			else{
				$site['status']['statements']['errors'][] = 'Usuwanie zdjęć nie powiodło się.';
				$site['content'] = 'error';
				$site['forward'] = 'poprzedniej strony';
				header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa=".$_GET['idTrasa']);		
			}		
		}
	}
	else{
		$site['status']['statements']['errors'][] = "Wymaga uprawnień admina";
		$site['content'] = 'warning';
		$site['forward'] = "odpowiedniej strony";
		header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/login.php');
	}
	
	screen_site($site);
?>