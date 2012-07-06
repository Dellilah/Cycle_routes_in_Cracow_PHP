<?

	/**
	*  Szczegóły dotyczące dnego punktu trasy
	*
	* @package show_point.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 11.06.2012
    * @version 1.0.1 11.06.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	$site = array();
	
	
	
	if(isset($_GET['idPunkt_Trasy']) && ctype_digit($_GET['idPunkt_Trasy'])){
		
		$site = download_from_form(array('idPunkt_Trasy'), $_GET);
		
		//pobieramy dane szczegółowe punktu
		if($site['point'] = current(download_data($sql, 'Punkt_Trasy', array('*'), array('idPunkt_Trasy' => $site['idPunkt_Trasy'])))){
			
			$site['content'] = 'show_point';
			
			$site['routes_id'] = array();
			
			//pobieramy ID tras, które zawierają dany punkt
			if($site['routes_id'] = download_data($sql, 'Trasa_has_Punkt_Trasy', array('Trasa_idTrasa'), array('Punkt_Trasy_idPunkt_Trasy' => $site['idPunkt_Trasy']))){
				
				$site['routes'] = array();
				//pobieramy nazwy tras, które zawierają dany punkt
				foreach($site['routes_id'] as $route){
					
					$site['routes'][] = current(download_data($sql, 'Trasa', array('idTrasa','Nazwa'), array('idTrasa' => $route['Trasa_idTrasa'])));
					
				}
			}

		}
		else{
			$site['status']['statements']['errors'][] = 'Nie udało się pobrać danych punktu.';
			$site['content'] = 'error';
			$site['forward'] = 'listy wszystkich punktów';
			header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/all_points.php");	
		}
	}
	else{
		$site['status']['statements']['errors'][] = 'Błędnie wybrany punkt.';
		$site['content'] = 'error';
		$site['forward'] = 'listy wszystkich punktów';
		header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/all_points.php");	
	}
	
	screen_site($site);
?>
		
		