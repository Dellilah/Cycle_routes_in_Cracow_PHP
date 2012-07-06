<?php

	/**
	* Obsługa Bazy danych
	*
	* @package database_service.inc.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 14.04.2012
    * @version 1.0.1 14.04.2012
    */
	
	/**
	* Łączenie z bazą danych
	*
	* @param array $database Tablica danych potrzebnych do połączenia
	* @return mixed	Wynik łączenia z bazą
	*/
	
	function database_connect(&$database){
		
		if(!$database['connect'] = @mysql_connect($database['host'], $database['user'], $database['password'])){
			$database['errors'] = "Nie można połączyć z serwerem";
			return false;
		}
		elseif(!@mysql_select_db($database['database'])){
			$database['errors'] = "Nie można połączyć z bazą danych";
			return false;
		}
		else{
			mysql_query('SET NAMES utf-8');
			mysql_query ('SET CHARACTER_SET utf8_unicode_ci');
			return $database['connect'];
		}
	}
	
	/**
	*	 Przygotowanie danych do zapisu do bazy : Dodajemy tu znaki unikowe, aby zapytanie było bezpieczne dla bazy
	*
	* @param array $data Tablica z danymi, o które trzeba zadbać
	* @return array Tablica gotowych danych
	*/
	
	function prepare_data($data){
		
		$return_data = array();
		
		foreach($data as $field => $value){
			
			$return_data[$field] = mysql_real_escape_string($value);
		
		}
		
		return $return_data;
		
	}
	
	/**
	* 	Wykoannie zapytania SQL
	*
	* @param string $query Zapytanie do wykonania
	* @return mixed Wynik zapytania do bazy
	*/
	
	function database_query($query){
		
		if(!($query_result = @mysql_query($query))){
			return false;
		}
		else{
			return $query_result;
		}
	
	}