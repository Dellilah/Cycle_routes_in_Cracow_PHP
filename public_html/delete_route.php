<?php
	
	/**
	* Usuwanie trasy
	*
	* @package delete_route.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 19.06.2012
    * @version 1.0.1 19.06.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	//sciezka do zdjec
	$path = 'fx/bitmapy';
	
	$_SESSION['last'] = 'delete_route.php';
	
	$site['content'] = 'delete_route';
	
	if(isset($_GET['idTrasa']) && ctype_digit($_GET['idTrasa'])){
		
		$site['data'] = current(download_data($sql, 'Trasa', array('Uzytkownik_idUzytkownik'), array('idTrasa' => $_GET['idTrasa'])));
		
		if(isset($_SESSION['user']) && ($_SESSION['user']['idUzytkownik']==$site['data']['Uzytkownik_idUzytkownik'] || $_SESSION['user']['Typ'] == 'admin')){
			
				//najpierw usuwamy połączenie z punktami, punktów nie!
			if(!delete_data($sql, 'Trasa_has_Punkt_Trasy', array('Trasa_idTrasa' => $_GET['idTrasa']))){
					$site['status']['statements']['errors'][]= "Nie udało się usunąć powiązania z punktami";
					$site['content'] = "error";
					$site['forward'] = "strony trasy";
					header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route.php?idTrasa='.$_GET['idTrsa']);
			}
				
				//usuwamy zdjęcia trasy
			if(delete_data($sql, 'Zdjecie', array('Trasa_idTrasa' => $_GET['idTrasa']))){
								
				foreach(glob($path . '/Trasa_'.$_GET['idTrasa']) as $dir) {	
					rmdirr($dir);	
				}
				
				if(delete_data($sql, 'Trasa', array('idTrasa' => $_GET['idTrasa']))){
					$site['status']['statements']['operation'][] = 'Usunięto trasę wraz z jej powiązaniami do punktów (punkty nie zostały usunięte) oraz zdjęciami';
					$site['content'] = 'statements';
					$site['forward'] = "listy Twoich tras";
					header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/delete_route.php');	
				}
				else{
					$site['status']['statements']['errors'][] = 'Usuwanie trasy nie powiodło się.';
					$site['content'] = 'error';
					$site['forward'] = "strony trasy";
					header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route.php?idTrasa='.$_GET['idTrsa']);	
				}	
			}
			else{
				$site['status']['statements']['errors'][] = 'Usuwanie zdjęć trasy nie powiodło się.';
				$site['content'] = 'error';
				$site['forward'] = "strony trasy";
				header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route.php?idTrasa='.$_GET['idTrsa']);	
			}
		}
		else{
			$site['status']['statements']['errors'][]= "Nie masz uprawnień aby usunąć tę trasę";
			$site['content'] = "warning";
			$site['forward'] = "stromy trasy";
			header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route.php?idTrasa='.$_GET['idTrasa']);
		}
	}
	else{
		
		if(!isset($_SESSION['user'])){
			$site['status']['statements']['errors'][]= "Aby usuwać trasy musisz być zalogowany";
			$site['content'] = "warning";
			$site['forward'] = "strony logowania";
			header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/login.php');
		}
		elseif($_SESSION['user']['Typ'] == 'admin'){
			if(!$site['data'] = download_data($sql, 'Trasa', array('*'))){
				$site['status']['statements']['errors'][]= "Nie udało się pobrać danych dot. tras";
				$site['content'] = "error";
				header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/');	
			}
		}
		else{
			if(!$site['data'] = download_data($sql, 'Trasa', array('*'), array('Uzytkownik_idUzytkownik' => $_SESSION['user']['idUzytkownik']))){
				$site['status']['statements']['errors'][]= "Nie udało się pobrać danych dot. tras";
				$site['content'] = "error";
				header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/');
			}
		}
	}
	
	screen_site($site);
?>
	
	