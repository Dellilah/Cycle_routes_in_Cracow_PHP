<?

	/**
	*  Przeszukiwanie zawartości serwisu
	*
	* @package search.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 10.06.2012
    * @version 1.0.1 10.06.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	$site = array();
	
	if(isset($_GET['search']) && $_GET['search']!=''){
	
		$site['result']['routes_names'] = array();
		$site['result']['routes_descriptions'] = array();
		$site['result']['points_name'] = array();
		$site['result']['points_street'] = array();
		$site['result']['points_city'] = array();
	
		$site = download_from_form(array('search'),$_GET);
		
		//wyszukiwanie w danych tras
		$site['routes'] = download_data($sql, 'Trasa', array('*'));
		
		foreach($site['routes'] as $route){
			if(eregi($site['search'],$route['Nazwa'])){
				$site['result']['routes_names'][] = $route;
			}
			
			if(eregi($site['search'], $route['Opis'])){
				$site['result']['routes_descriptions'][] = $route;
			}
			
		}
		
		//wyszukiwanie w danych punktów tras
		$site['points'] = download_data($sql, 'Punkt_Trasy', array('*'));
		
		foreach($site['points'] as $point){
			if(eregi($site['search'], $point['Adres'])){
				$site['result']['points_name'][] = $point;
			}

		}		
		
		$site['content'] = 'search_result';
	
	}
	else{
		header("Location: ".$_GET['site']); 
		exit;
	}
	
	screen_site($site);
?>
		
		