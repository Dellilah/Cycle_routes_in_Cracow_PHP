<?php
	
	/**
	* Działanie, korzystanie z zasobów bazy
	*
	* @package database_use.inc.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 14.04.2012
    * @version 1.0.1 14.04.2012
    */
	
	/**
	* Dodanie danych do bazy
	*
	* @param array $database Tablica danych potrzebnych do połączenia
	* @param string $table Tabela docelowa
	* @param array $data Tablica danych do wpisania
	* @param array $pattern Tablica pól do których wstawiamy dane
	* @return boolean	Wynik operacji
	*/
		
		
	function insert_data(&$database, $table, &$data, $pattern=array()){
		
		if($connect = database_connect($database)){
			
			$query = insert_query($table, $pattern, $data);
			
			if(database_query($query)){
				return true;
			}
			else return false;
		}
		else{
			return false;
		}
	}
	
	
	function insert_data2(&$database, $table, &$data, $pattern=array()){
		
		if($connect = database_connect($database)){
			
			$query = insert_query($table, $pattern, $data);
			return $query;
			/*if(database_query($query)){
				return true;
			}
			else return false;*/
		}
		else{
			return false;
		}
	}
	
	/**
	* Pobieranie elementów bazy
	*
	* @param array $database Tablica danych potrzebnych do połączenia
	* @param string $table nazwa tabeli z której będziemy pobierali dane
	* @param array $fields	Pola do pobrania
	* @param array  $conditions Warunki pobierania
	* 
	* @return mixed Wynik pobierania danych
	*/
	
	function download_data(&$database, $table, $fields = array(), $conditions = array(), $options=''){
		
		if(!($connect = database_connect($database))){
			return false;
		}
		else{
			$query = select_query($table, $fields, $conditions, $options);
			
			if(!($result = database_query($query))){
				$database['errors'] = "Nie można pobrać danych z bazy";
				return false;
			}
			else{
				$data = array();
				while($row = mysql_fetch_assoc($result)){
					foreach($row as $key => $value){
						$row[$key] = $value;
					}
					$data[]=$row;
				}
				mysql_free_result($result);
				return $data;
			}
		}
	}
	
	/**
	* Edycja zawartości bazy
	*
	* @param array $database Tablica danych potrzebnych do połączenia
	* @param string $table Tabela docelowa
	* @param array $data Tablica nowych danych do wpisania
	* @param array $pattern Tablica pól do których wstawiamy dane
	* @param string $field_id Nazwa pola w danej tabeli w którym znajduje się wyróżnik (id)
	* @return boolean	Wynik operacji
	*/
	
	function update_data(&$database, $table, $data, $pattern, $field_id){
		
		if($connect = database_connect($database)){
			
			$query = update_query($table, $pattern, $data, array($field_id => $data[$field_id]));
			if(database_query($query)){
				return true;
			}
			else return false;
		}
		else{
			return false;
		}
	}
	
	/**
	* Usuwanie rekordów z bazy
	*
	* @param array $database Tablica danych potrzebnych do połączenia
	* @param string $table Tabela z której dane mają zostać usunięte
	* @param array  $conditions Warunki usuwania rekordów
	* 
	* @return boolean Wynik operacji
	*/
	
	function delete_data(&$database, $table, $conditions){
		
		if($connect = database_connect($database)){
			$query = delete_query($table, $conditions);
			if(database_query($query)){
				return true;
			}
			else{
				$database['errors'] = 'Usuwanie nie powiodło się';
				return false;
			}
		}
		else{
			$database['errors'] = 'Połączenie z bazą nie powiodło się';
			return false;
		}
			
	}