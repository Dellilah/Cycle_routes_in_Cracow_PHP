<?php
	
	/**
	* Usuwanie wszystkich zdjęć i ich folderów z bazy
	*
	* @package clear_pictures.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 06.06.2012
    * @version 1.0.1 06.06.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	$path = 'fx/bitmapy';
	
	if(authorization()){
		
		if(isset($_GET['idZdjecie']) && ctype_digit($_GET['idZdjecie'])){
			$site['data']['picture'] = current(download_data($sql, 'Zdjecie', array('*'), array('idZdjecie' => $_GET['idZdjecie'])));
			
			if($site['data']['picture']['Uzytkownik_idUzytkownik'] == $_SESSION['user']['idUzytkownik'] || $_SESSION['user']['Typ'] == 'admin'){
				
				if(delete_data($sql, 'Zdjecie', array('idZdjecie' => $site['data']['picture']['idZdjecie']))){
					if(file_exists($site['data']['picture']['Adres_url'])){
						unlink($site['data']['picture']['Adres_url']);
						$site['status']['statements']['operation'][] = 'Usunięto zdjęcie';
						$site['content'] = 'statements';
						$site['forward'] = 'strony trasy';
						header("Refresh: 5, url=".$_SESSION['last']);
					}
					else{
						$site['status']['statmenets']['errors'][]='Brak pliku do usunięcia';
						$site['content'] = 'warning';
						$site['forward'] = 'strony trasy';
						header("Refresh: 5, url=".$_SESSION['last']);
					}
				}
				$site['status']['statmenets']['errors'][] = 'Nie udało się usunąć zdjęcia z bazy';
				$site['content'] = 'error';
				$site['forward'] = 'strony trasy';
				header("Refresh: 5, url=".$_SESSION['last']);
			}
			else{
				$site['status']['statements']['errors'][] = 'Nie masz uprawnień do usuwania tego zdjęcia';
				$site['content'] = 'warning';
				$site['forward'] = 'strony trasy';
				header("Refresh: 5, url=".$_SESSION['last']);
			}
		}
		else{
			$site['status']['statements']['errors'][]='Błędnie wybrane zdjęcie do usnięcia';
			$site['content'] = 'error';
			$site['forward'] = 'strony trasy';
			header("Refresh: 5, url=".$_SESSION['last']);
		}
	}
	else{
		$site['status']['statements']['errors'][] = "Tylko dla zalogowanych użytkowników.";
		$site['content'] = 'warning';
		$site['forward'] = "odpowiedniej strony";
		header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/login.php');
	}
		
	screen_site($site);
?>