<?php
	
	/**
	*	Rejestracja użytkownika w systemie
	*
	* @package sign_up.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 13.04.2012
    * @version 1.0.1 13.04.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	if(!authorization()){
	
		//Podstawowe dane dla szablonów
		$site['content'] = 'sign_up';
		$site['title'] = 'Rejestracja użytkownika';

		//sprawdzamy czy zostały wysłane dane z formularza
		if(isset($_POST) && count($_POST)){
			
			//pobieramy dane z formularza wg wzorca pól
			$pattern = array('Login', 'Email', 'Imie', 'Nazwisko', 'Haslo', 'Haslo_ponownie');
			$site['data'] = download_from_form($pattern, $_POST);
			
			//przygotowanie tablicy błędów, sprawdzenie poprawności pól rejestracji
			$site['status']['statements']['form_errors'] = array();
			check_form_sign_up($sql, $site['data'], $pattern, $site['status']['statements']['form_errors']);
			
			//jeżeli nie zostały znalezione żadne błędy - próba rejestracji nwego uzytkownika
			if(!(count($site['status']['statements']['form_errors']))){
				
				unset($site['status']['statements']['form_errors']);
				
				$pattern = array('Login', 'Email', 'Imie', 'Nazwisko', 'Haslo');
				
				if(insert_data($sql, 'Uzytkownik', $site['data'], $pattern)){
					
					if($result = log_in_user($sql, 'Uzytkownik', $site['data'])){
				
						$_SESSION['user'] = $result;
						
					}
					
					$site['status']['statements']['operation'][] = "Rejestracja powiodła się!";
					$site['content'] = "statements";
					$site['forward'] = 'strony głównej';
					header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/');
				}
				else{
					
					$site['status']['statements']['errors'][] = "Rejestracja użytkownika nie powiodła się.";
					$site['content'] = "error";
					$site['forward'] = 'strony głównej';
					header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/');
				}
			}
			
		}
	}
	else{
	
		$site['status']['statements']['errors'][] = "Przed rejestracją nowego użytkownika należy się wylogować";
		$site['content'] = "warning";
	}
	
	screen_site($site);

?>