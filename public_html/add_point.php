<?
	/**
	* Dodanie nowego opcjonalnego punktu na trasie - ADMIN
	*
	* @package add_point.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 03.05.2012
    * @version 1.0.1 03.05.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	//Podstawowe dane dla szablonów
	$site['content'] = 'add_point';
	$site['title'] = 'Dodawanie punktu tras';
	
	//autryzacja użytkownika-ADMINA
	if(authorization_admin()){
			
			//sprawdzamy czy zostały wysłane dane z formularza
		if(isset($_POST) && count($_POST)){
			
			//pobieramy dane z formularza wg wzorca pól
			$pattern = array('Nazwa', 'Miasto', 'Ulica', 'Numer', 'Edukacyjnosc');
			$site['data'] = download_from_form($pattern, $_POST);
			
			//przygotowanie tablicy błędów, sprawdzenie poprawności pól dodawania nowego punktu trasy
			$site['status']['statements']['form_errors'] = array();
			check_form_add_point($site['data'], $pattern, $site['status']['statements']['form_errors']);
			
			//jeżeli nie zostały znalezione żadne błędy - próba dodania punktu do Bazy
			if(!(count($site['status']['statements']['form_errors']))){
				
				//Pozbywamy się tablicy błędów wypełniania formularza
				unset($site['status']['statements']['form_erors']);				
				
				$pattern = array('Nazwa', 'Miasto', 'Ulica', 'Numer', 'Edukacyjnosc');
				
				if(insert_data($sql, 'Punkt_Trasy', $site['data'], $pattern)){
					
					$id_punktu = current(current(download_data($sql, 'Punkt_Trasy', array('idPunkt_Trasy'), array('Nazwa' => $site['data']['Nazwa']))));
					
					$site['status']['statements']['operation'][] = "Dodanie punktu powiodło się!";
					$site['content'] = "statements";
					$site['forward'] = "strony dodanego punktu ";
					header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_point?idPunkt_Trasy=".$id_punktu);
				}
				else{
					
					$site['status']['statements']['errors'][] = "Dodanie punktu do bazy nie powiodło się.";
					$site['content'] = "error";
					header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/");
				}					
			}
		}
		
	}
	else{
		$site['status']['statements']['errors'][]= "Dostęp wymaga zalogowania i uprawnień admina";
		$site['content'] = "warning";
		$site['forward'] = "odpowiedniej strony";
		header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/login.php');
	}
		
	screen_site( $site);
?>