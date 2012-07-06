<?php
	
	/**
	*	Zapytania do bazy danych
	*
	* @package queries.inc.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 14.04.2012
    * @version 1.0.1 14.04.2012
    */
	
	/**
	* Tworzenie zapytania typu INSERT
	*
	* @param string $table Nazwa tabeli do której zamierzamy dodawać
	* @param array $pattern Wzorzec pól jakie znajdują się w tabeli
	* @param array $data Dane do dodania
	* 
	* @return string Gotowe zapytanie typu INSERT
	*/
	
	function insert_query($table, $pattern, &$data){
		
		$data = prepare_data($data);
		
		foreach($pattern as $field){
			if(isset($data[$field])){	
				
				if(isset($fields)){
					$fields = $fields.','.$field;
				}
				else{
					$fields = $field;
				}
				
				if(isset($values)){
					if($field=='Haslo'){
						$values.= ', MD5(\''.$data[$field].'\')';
					}else{
						$values.=', \''.$data[$field].'\'';
					}				
				}
				else{
					if($field=='Haslo'){
						$values = 'MD5(\''.$data[$field].'\')';
					}else{
						$values ='\''.$data[$field].'\'';
					}
				}
			}			
		}
		
		$query = 'INSERT INTO '.$table.'('.$fields.') VALUES ('.$values.')';
		return $query;
	}
	
	/**
	*	Budowanie zapytania typu SELECT
	*
	* @param string $table nazwa tabeli z której będziemy pobierali dane
	* @param array $fields	Pola do pobrania
	* @param array $conditions Warunki pobierania
	* @param string $options	Dodatkowe opcje
	* 
	* @return string Poprawne zapytanie typu SELECT
	*/
	
	function select_query($table, $fields = array(), $conditions = array(), $options = ''){
		
		if(count($fields)){
			foreach($fields as $key  => $value){
				
				if(is_int($key)){
					$field = $value;
				}
				else{
					$field = $key.' AS '.$value;
				}
				
				if(isset($query_fields)){
					$query_fields = $query_fields.', '.$field;
				}
				else{
					$query_fields = $field;
				}
			}
		}
		else{
			$query_fields = '*';
		}

		$query = 'SELECT '.$query_fields.' FROM '.$table;
		
		if(count($conditions)){
			foreach($conditions as $key => $value){
				if(isset($query_conditions)){
					$query_conditions = $query_conditions.' AND '.$key.' = \''.$value.'\'';
				}
				else{
					$query_conditions =' WHERE '.$key.' = \''.$value.'\'';
				}
			}
			
			$query = $query.$query_conditions.' '.$options;
		}
		else{
			$query = $query.' '.$options;
		}
		
		return $query;
		
	}

	
	/**
	*	Budowanie zapytania typu UPDATE
	*
	* @param string $table nazwa tabeli z której będziemy pobierali dane
	* @param array $fields	Pola do edycji
	* @param array $new_values	Nowe wartości do wpisania do pól
	* @param array $conditions Warunki wybierania wierszy do edycji?
	* 
	* @return string Poprawne zapytanie typu UPDATE
	*/
	
	function update_query($table, $fields, $new_values, $conditions){
		
		foreach($fields as $field){
			if(isset($new_values[$field])){
				if(!isset($query_set)){
					$query_set = ' SET '.$field.'=\''.$new_values[$field].'\'';
				}
				else{
					$query_set = $query_set.', '.$field.'=\''.$new_values[$field].'\'';
				}
			}
		}
		
		foreach($conditions as $key => $value){
				if(isset($query_conditions)){
					$query_conditions = $query_conditions.' AND '.$key.' = \''.$value.'\'';
				}
				else{
					$query_conditions =' WHERE '.$key.' = \''.$value.'\'';
				}
		}
		
		$query = 'UPDATE '.$table.$query_set.$query_conditions;
		return $query;
		
	}
	
	/**
	*	Budowanie zapytania typu DELETE
	*
	* @param string $table nazwa tabeli z której będziemy usuwali
	* @param array $conditions Warunki wybierania wierszy do usunięcia
	* 
	* @return string Poprawne zapytanie typu DELETE
	*/
	
	function delete_query($table, $conditions){
	
		$query = 'DELETE FROM '.$table;
		if(isset($conditions) && count($conditions)){
			foreach($conditions as $key => $value){
				if(isset($sql_conditions)){
					$sql_conditions .= ' AND '.$key.' = '.$value;
				}
				else{
					$sql_conditions = ' WHERE '.$key.'='.$value;
				}
			}
				
		}
		$query .= $sql_conditions;
		return $query;
	}