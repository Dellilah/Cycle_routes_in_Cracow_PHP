<?

	/**
	*  Wyświetlanie pojedynczej trasy
	*
	* @package show_route.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 23.05.2012
    * @version 1.0.1 23.05.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	//Podstawowe dane dla szablonów
	$site['content'] = 'show_route';
	$site['title'] = 'Opis trasy';
	
	
	//pobieramy id tras z bazy
	$site['routes_ids'] = download_data($sql, 'Trasa', array('idTrasa'));
	
	//sprawdzamy czy znaleźliśmy jakiekolwiek trasy
	if(count($site['routes_ids'])){
		
		foreach($site['routes_ids'] as $key => $route){
			$site['routes_ids'][$key] = current($site['routes_ids'][$key]);
		}	
		
		if(isset($_GET['idTrasa']) && ctype_digit($_GET['idTrasa']) && does_belong_to($_GET['idTrasa'], $site['routes_ids'])){
			
			$site['data']['route'] = current(download_data($sql, 'Trasa', array('*'), array('idTrasa' => $_GET['idTrasa'])));
			
			if( count($site['data']['route'])){
				
				$site['title'] = $site['data']['route']['Nazwa'];
			
				//ustalamy jak graficznie przedstawić trudność i popularność
				if(floor($site['data']['route']['Licznik_popularnosci']/10) < 6){
					$site['data']['route']['pop']['full'] = floor($site['data']['route']['Licznik_popularnosci']/10);
				}
				else{
					$site['data']['route']['pop']['full'] = 6;
				}
				
				$site['data']['route']['pop']['half'] = 0;
				if($site['data']['route']['Licznik_popularnosci']%10 > 5){
					$site['data']['route']['pop']['half'] = 1;
				}
				$site['data']['route']['pop']['empty'] = 6- $site['data']['route']['pop']['full'] - $site['data']['route']['pop']['half'];
					
			
				$site['data']['points_id'] = download_data($sql, 'Trasa_has_Punkt_Trasy', array('Punkt_Trasy_idPunkt_Trasy'), array('Trasa_idTrasa' => $_GET['idTrasa']));
				
				//pobieranie danych dot. zdjęć trasy
				$site['data']['route']['photos'] = download_data($sql, 'Zdjecie', array('*'), array('Trasa_idTrasa' => $_GET['idTrasa']));
				
				if(count($site['data']['points_id'])){
					foreach($site['data']['points_id'] as $key => $id){
						$site['data']['points_id'][$key] = current($site['data']['points_id'][$key]);
					}	
					
					$site['data']['route']['points'] = array();
					foreach($site['data']['points_id'] as $key => $id){
						$site['data']['route']['points'][] = current(download_data($sql, 'Punkt_Trasy', array('*'), 
																	array('idPunkt_Trasy' => $site['data']['points_id'][$key])));
					}
					
					if(!count($site['data']['route']['points'])){
						$site['status']['statements']['point_errors'] = "Nie udało się pobrać danych dotyczących punktów trasy";
					}			
				}
				else{
					$site['status']['statements']['point_errors'] = "Brak punktów przypisanych do danej trasy";
				}				
			}
			else{
				$site['status']['statements']['errors'][] = "Nie udało się pobrać danych dotyczących trasy";
				$site['content'] = "error";	
				$site['forward'] = 'poprzedniej strony';
				header("Refresh: 5, url=".$_SESSION['last']);
			}
		}
		else{
			$site['status']['statements']['errors'][] = "Błędnie wybrana trasa";
			$site['content'] = "error";
			$site['forward'] = 'poprzedniej strony';
			header("Refresh: 5, url=".$_SESSION['last']);
		}
	}
	else{
		$site['status']['statements']['errors'][]='Brak tras do wyświetlenia. Stwórz dla nas pierwszą trasę!';	
		$site['content'] = 'warning';
		$site['forward'] = 'strony dodawania trasy';
		header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/add_route.php");	
	}
	
	if($site['content']=='show_route'){		
		$site['data']['route']['Licznik_popularnosci']++;
		update_data($sql, 'Trasa', $site['data']['route'], array('Licznik_popularnosci'),'idTrasa');	
	}
	
	$_SESSION['last'] = current_url($_SERVER['PHP_SELF'], $_GET);

	screen_site($site);
?>
