<?php	

	/**
	* Obsługa FORMULARZY
	* 
	* @package form_action.inc.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 13.04.2012
    * @version 1.0.2 14.04.2012
    */
	
	/**
	* Funkcja odpowiedzialna za pobieranie danych z formularza
	*
	* @param array $pattern	Tablica zawierajaca nazwy pól do pobrania
	* @param array $form	Tablica zawierająca dane do pobrania
	*
	* @return array
	*/
	
	function download_from_form($pattern, $form){
		
		$data = array();
		
		foreach($pattern as $field){
			if(isset($form[$field])){
				if(is_array($form[$field])){
					$form[$field] =  implode(" ", $form[$field]);
				}
				$data[$field] = trim($form[$field]);
			}
			else
				$data[$field] = '';
		}
		
		return $data;
	}
	
	
	/**
	*	Wstawienie do tablicy odpowiedniej adnotacji o błędzie
	*
	* @param array $errors Tablica docelowa błędów
	* @param string	$field	Pole błedu
	* @param strinf $error_description Opis błędu
	*
	*/
	
	function save_error(&$errors, $field, $error_description = 'Nieprawidłowe dane'){
		
		$errors = $errors + array($field => $error_description);
	
	}
	
	/**
	* Funkcja sprawdzająca obecność danych,które są wymagane
	*
	* @param array $pattern Tablica zawierająca nazwy pól do sprawdzenia
	* @param array $data	Tablica z danymi do sprawdzenia
	* @param array $errors Tablica do której będziemy zapisywali potencjalne błędy
	*/
	
	function require_data($pattern, $data, &$errors){
		
		foreach($pattern as $field){
			
			if(!isset($data[$field]) || $data[$field] == ''){
				
				save_error($errors, $field, "Pole obowiązkowe do wypełnienia");
			}
		}
		
		if(count($errors)){
			return false;
		}
		else{
			return true;
		}
	}
	
	/**
	* Funkcja sprawdzająca długość podawanych danych
	*
	* @param array $data  Tablica z danymi
	* @param string $field Pole sprawdzane
	* @param array $errors Tablica do której będziemy zapisywali potencjalne błędy
	* @param int   $min Minimalna długość ciągu
	* @param int   $max Maksymalna długość ciągu
	*/
	
	function check_length($data, $field, &$errors, $min, $max){
		
		if ( strlen($data[$field]) < $min ) {
            save_error($errors, $field, 'Wprowadzona wartość jest za krótka.');
			return false;
        }
		elseif ( strlen($data[$field]) > $max ) {
            save_error($errors, $field, 'Wprowadzona wartość jest za długa.');
			return false;
        }
		else{
			return true;
		}
	}
	
	/**
	* Funkcja sprawdzająca proste, POLSKIE stringi - imiona, naziwska, nazwy ulic, miast...
	*
	* @param array $data Tablica z danymi
	* @param string $field Nazwa Pola
	* @param array $errors Tablica błędów
	*/
	
	function check_short_string($data, $field, &$errors){
		
		if(!preg_match("/^[a-zA-ZąĄćęłóżźĆĘŁÓŻŹ ]+$/", $data[$field])){	
			save_error($errors, $field, "Nieprawidłowe znaki w polu - tylko alfabet");
		}
	}
	
	/**
	* 	Sprawdzanie danych z formularza logowania
	*
	* @param array $data Tablica zawierająca dane pobrane z formularza
	* @param array $pattern Tablica zawierająca listę pól do sprawdzenia
	* @param array $errors Tablica do której zapisywane będą błędy
	*/
	
	function check_form_login($data, $pattern, &$errors){
		
		if(require_data($pattern, $data, $errors)){
			//Jeżeli w polu będzie jakaś małpa :) to sprawdzamy czy to poprawny email
			//jeżeli nie występuje - traktujemy i sprawdzamy jak login
			if(!preg_match('/[@]{1}/', $data['Login']) ){
				check_login($data, 'Login', $errors);
			}
			else{
				check_email($data, 'Login', $errors);
			}
			check_pass($data, 'Haslo', $errors);
			if(isset($errors['Login']) || isset($errors['Haslo'])){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return false;
		}
		
	}
	
	/**
	* Funckja sprawdzająca poprawnośc loginu
	*
	* @param array $data	Tablica danych
	* @param string $field	Pole do sprawdzenia
	* @param array $errors Tablica do której zapisywane będą błędy
	*/
	
	function check_login($data, $field, &$errors){
		 
		if(check_length($data, $field, $errors, 3, 15)){
			if(!preg_match('/^[a-zA-Z0-9_^]+$/', $data[$field])){	
				save_error($errors, $field, "Nieprawidłowe znaki w polu - [ a-z, 0-9, _ , ^ ]");
			}
		}
	}
	
	/**
	* Funkcja sprawdzająca poprawność Hasła
	*
	* @param array $data	Tablica danych
	* @param string $field	Pole do sprawdzenia
	* @param array $errors Tablica do której zapisywane będą błędy
	*/
	
	function check_pass($data, $field, &$errors){
		
		if(check_length($data, $field, $errors, 3, 15)){
			if(!preg_match('/^[a-zA-Z0-9]+$/', $data[$field])){	
				save_error($errors, $field, "Nieprawidłowe znaki w polu [ a-z, 0-9 ]");
			}
			elseif ( !preg_match('/[0-9]+/', $data[$field]) ) {
				save_error($errors, $field, 'Pole Hasło musi zawierać co najmniej jedną cyfrę.');
			}
			elseif ( !preg_match('/[A-Za-z]+/', $data[$field]) ) {
				save_error($errors, $field, 'Pole Hasło musi zawierać co najmniej jedną literę.');
			}
		}
	}
	
	/**
	* 	Sprawdzanie danych z formularza rejestracji
	*
	* @param array $data Tablica zawierająca dane pobrane z formularza
	* @param array $pattern Tablica zawierająca listę pól do sprawdzenia
	* @param array $errors Tablica do której zapisywane będą błędy
	*/
	
	function check_form_sign_up(&$sql, $data, $pattern, &$errors){
		
		if(require_data($pattern, $data, $errors)){
			check_login($data, 'Login', $errors);
			is_taken($sql, 'Uzytkownik', $data, 'Login', $errors);
			check_pass($data, 'Haslo', $errors);
			confirm_pass($data['Haslo'], $data['Haslo_ponownie'], $errors);
			check_name($data, 'Imie', $errors);
			check_name($data, 'Nazwisko', $errors);
			check_email($data, 'Email', $errors);
			is_taken($sql, 'Uzytkownik', $data, 'Email', $errors);
			if(count($errors)){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return false;
		}
	}
	
	/** 
	*	Funkcja sprawdzająca zgodność hasła i jego powtórzenia
	*
	* @param string $pass Hasło
	* @param string $pass_conf Potwierdzenie hasła
	* @param array $errors Tablica do której będą zapisywane błędy
	*/
	
	function confirm_pass($pass, $pass_conf, &$errors){
		
		if($pass != $pass_conf){
			save_error($errors, 'Haslo_ponownie', "Pole HASŁO i POTWIERDZENIE HASŁA muszą być jednakowe");
		}
	
	}
	
	/**
	*  Funkcja sprawdzająca poprawność podanego imienia/nazwiska
	*
	* @param array $data	Tablica danych
	* @param string $field	Pole do sprawdzenia
	* @param array $errors  Tablica do której będą zapisywane błędy
	*/
	
	function check_name($data, $field, &$errors){
	
		if(check_length($data, $field, $errors, 3, 15)){
			check_short_string($data, $field, $errors);
		}
		
	}
	
	/**
	*	Funkcja sprawdzająca poprawność podanego e-maila
	*
	* @param array $data	Tablica danych
	* @param string $field	Pole do sprawdzenia
	* @param array $errors  Tablica do której będą zapisywane błędy
	*/
	
	function check_email($data, $field, &$errors){
		
			if(!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $data[$field])){
				save_error($errors, $field, "Nieprawidłowy adres e-mail");
			}
	}	
	
	
	/**
	* Sprawdza występowanie danej w tabeli
	*
	* @param array $sql Konfiguracja połączenia z bazą danych  
	* @param array $data Tablica danych
	* @param string $table Tabela z danymi
	* @param string $field Nazwa pola do sprawdzenia
	* @param array $errors  Tablica do której będą zapisywane błędy
	*/
	
	function is_taken(&$sql, $table, $data, $field, &$errors){
		
		$result=download_data($sql, $table, array('*'), array($field => $data[$field]));
		if($result && count($result)>0){
			save_error($errors, $field, "Już zarejestrowano w bazie");	
		}
	}		

	/**
	* 	Sprawdzanie danych z formularza dodawania punktu trasy
	
	* @param array $data Tablica zawierająca dane pobrane z formularza
	* @param array $pattern Tablica zawierająca listę pól do sprawdzenia
	* @param array $errors Tablica do której zapisywane będą błędy
	*/
	
	function check_form_add_point(&$data, $pattern, &$errors){
		
		//usuwamy NUMER ze wzroca - wg bazy danych nie jest to konieczne pole
		unset($pattern[3]);
		if(!isset($data['Numer']))
			$data['Numer'] = '';
			
		//jeżeli EDUKACYJNOŚĆ nie jest ustawiona - ustawiamy ją na 0
		if(!isset($data['Edukacyjnosc']) || $data['Edukacyjnosc'] == ''){
			$data['Edukacyjnosc'] = '0';
		}
		
		if(require_data($pattern, $data, $errors)){
			check_short_string($data, 'Nazwa', $errors);
			check_short_string($data, 'Miasto', $errors);
			check_short_string($data, 'Ulica', $errors);
			if(isset($data['Numer']) && $data['Numer']!='' && !ctype_digit($data['Numer'])){
				save_error($errors, 'Numer', "Niepoprawna wartość pola - tylko liczby");
			}
		}
	}	

	/**
	* 	Sprawdzanie danych z edycji profilu
	*
	* @param array $data Tablica zawierająca dane pobrane z formularza
	* @param array $pattern Tablica zawierająca listę pól do sprawdzenia
	* @param array $errors Tablica do której zapisywane będą błędy
	*/
	
	function check_form_edit_profile(&$sql, $data, $pattern, &$errors){
		
		if(require_data($pattern, $data, $errors)){
			if( (isset($data['Haslo']) || isset($data['Haslo_ponownie'])) && ($data['Haslo_ponownie'] != '' || $data['Haslo'] != '')){
				check_pass($data, 'Haslo', $errors);
				confirm_pass($data['Haslo'], $data['Haslo_ponownie'], $errors);
			}
			check_name($data, 'Imie', $errors);
			check_name($data, 'Nazwisko', $errors);
			if($data['Email'] != $data['current_mail']){
				check_email($data, 'Email', $errors);
				is_taken($sql, 'Uzytkownik', $data, 'Email', $errors);
			}
			if(count($errors)){
				return false;
			}
			else{
				return true;
			}
		}
		else{
			return false;
		}
	}