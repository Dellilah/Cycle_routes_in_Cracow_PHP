<?

	/**
	*  Edycja profilu użytkownika
	*
	* @package edit_profile.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 18.05.2012
    * @version 1.0.1 18.05.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	//Podstawowe dane dla szablonów
	$site['content'] = 'edit_profile';
	$site['title'] = 'Edycja profilu użytkownika';
	$_SESSION['last']= 'edit_profile.php';
	if(authorization()){
		
			//sprawdzamy czy zostały wysłane dane z formularza
		if(isset($_POST) && count($_POST)){
			
			//pobieramy dane z formularza wg wzorca pól
			$pattern = array('Email', 'Imie', 'Nazwisko', 'Haslo', 'Haslo_ponownie');
			$site['data'] = download_from_form($pattern, $_POST);
			
			//przygotowanie tablicy błędów, sprawdzenie poprawności pól rejestracji
			$site['status']['statements']['form_errors'] = array();
			
			//zmieniamy wzorzec - pole hasło i hasło ponownie nie są wymagane i zapisujemy dotychczasowy mail
			$pattern = array('Email', 'Imie', 'Nazwisko');
			$site['data']['current_mail'] = $_SESSION['user']['Email'];
			check_form_edit_profile($sql, $site['data'], $pattern, $site['status']['statements']['form_errors']);
			
			//jeżeli nie zostały znalezione żadne błędy - próba update'u danych
			if(!(count($site['status']['statements']['form_errors']))){
				
				unset($site['status']['statements']['form_errors']);
				
				if(isset($site['data']['Haslo']) && $site['data']['Haslo'] != ''){
					$pattern = array('Email', 'Imie', 'Nazwisko', 'Haslo');
				}
				else{
					$pattern = array('Email', 'Imie', 'Nazwisko');
				}
				
				$site['data']['idUzytkownik'] = $_SESSION['user']['idUzytkownik'];
				
				if(update_data($sql, 'Uzytkownik', $site['data'], $pattern, 'idUzytkownik')){
					
					$site['status']['statements']['operation'][] = "Edycja profilu powiodła się!";
					$site['content'] = "statements";
					header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/");
				}
				else{
					
					$site['status']['statements']['errors'][] = "Edycja profilu nie powiodła się";
					$site['content'] = "error";
					$site['forward'] = "strony edycji profilu";
					header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/edit_profile.php');
				}

			
			}
			
		}
		//jeżeli żadne dane nie zostały wysłane, to należy pobrać dotychczasowe dane użytkownika, żeby mógł je edytować
		else{			
			$pattern = array('Login', 'Email', 'Imie', 'Nazwisko');
			$user = download_data($sql, 'Uzytkownik', $pattern, array('idUzytkownik' => $_SESSION['user']['idUzytkownik']));
			$site['data'] = current($user);
			
			if(!count($site['data'])){
				$site['status']['statements']['errors'][] = "Pobieranie danych użytkownika nie powiodło się";
				$site['content'] = "error";
				header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/");
			}
			
		}
		
	}
	else{
		$site['status']['statements']['errors'][]= "Dostęp wymaga zalogowania";
		$site['content'] = "warning";
		$site['forward'] = "odpowiedniej strony";
		header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/login.php');
	}
	
	screen_site( $site);
?>