<?php
	
	/**
	* 	Logowanie użytkownika
	*
	* @package login.php
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
	
	//Podstawowe dane dla szablonów
	$site['content'] = 'login';
	$site['title'] = 'Logowanie do serwisu';

	//sprawdzamy czy zostały wysłane dane z formularza
	if(isset($_POST) && count($_POST)){
		
		//pobieramy dane z formularza wg wzorca pól
		$pattern = array('Login', 'Haslo');
		$site['data'] = download_from_form($pattern, $_POST);
		
		//przygotowanie tablicy błędów, sprawdzenie poprawności pól logowania
		$site['status']['statements']['form_errors'] = array();
		check_form_login($site['data'], $pattern, $site['status']['statements']['form_errors']);
		
		//jeżeli nie zostały znalezione żadne błędy - próba logowania
		if(!(count($site['status']['statements']['form_errors']))){
			
			unset($site['status']['statements']['form_errors']);
			
			//jeżeli dane zgadzają się z danymi zapisanymi w bazie, odnotowujemy
			//w danych sesyjnych fakt zalogowania
			if($result = log_in_user($sql, 'Uzytkownik', $site['data'])){
				
				$_SESSION['user'] = $result;
				/*
				//przekierowanie użytkownika na stronę, której dostępu żądał/na stronę główną
				$redirect = $_POST['redirect'];
				$host  = $_SERVER['HTTP_HOST'];
				if($redirect==''){
				
					$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					$extra = 'index.php';
					header("Refresh:5; url = http://$host$uri/$extra?redirect=$redirect");
				
				}
				else{
				
					header("Refresh:5; url= http://$host$redirect");

				}*/
				
				// i przekierowujemy użytkownika do strony z której trafił na logowanie, bądź na główną
				if(isset($_SESSION['last'])){
					$powrot=$_SESSION['last'];
				}
				else{
					$powrot='index.php';
				}
				header('Location:'.$powrot);
                exit;
				
			}
			else{
				$site['status']['statements']['errors'][] = "Logowanie nie powiodło się. Błędne dane autoryzacyjne.";
				$site['content'] = 'error';
				$site['forward'] = "strony logowania ponownie.";
				header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/login.php');
			}
		}
	}
	
	screen_site( $site);

?>
		