<?

	/**
	*  Wyświetlanie Edukacyjnych tras
	*
	* @package educational.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 27.05.2012
    * @version 1.0.1 27.05.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	//Podstawowe dane dla szablonów
	$site['content'] = 'all';
	$site['title'] = 'Educational';
	$site['site_title'] = 'Trasy edukacyjne';
	
	/* NAWIGACJA
	$site['max_per_site'] = 5;
	
	$site['status']['statements']['operation'] = download_sites_count($sql, $site['max_per_site'], 'Trasa');
	$site['content'] = 'all';
	$site['site_title'] = 'Trasy edukacyjne';
	
		dane do nawigacji
	$site['sites_count']
        = download_sites_count(&$sql, $site['max_per_site'], 'Trasa');
	if(isset($_GET['site']) && ctype_digit($_GET['site'])) {
        $current_site = $_GET['site'];
    }
    else {
        $current_site = 1;
    }
	
    if(($site['sites_count']>0)) {
       
        $site['current_site']
            = current_site_number($site['sites_count'], $current_site);*/
			
		//pobieramy id tras z bazy
		$site['routes_ids'] = download_data($sql, 'Trasa', array('idTrasa'));
		foreach($site['routes_ids'] as $key => $route){
			$site['routes_ids'][$key] = current($site['routes_ids'][$key]);
		}	
		foreach($site['routes_ids'] as $key => $id){
				
				$site['points'][$id] = download_data($sql, 'Trasa_has_Punkt_Trasy', array('Punkt_Trasy_idPunkt_Trasy'), array('Trasa_idTrasa' => $id));
				foreach($site['points'][$id] as $key => $point){
					$site['points'][$id][$key] = current($site['points'][$id][$key]);
				}
				//W tym momencie w $site['points'][3] są po kolei zapisane ID PUNKTÓW trasy o ID = 3
				//Teraz sprawdzimy czy kolejne punkty są edukacyjne - jeżeli tak to będziemy powiększali o 1 $site['educational_points'][3]
				$site['educational_points'][$id] = 0;
				
				foreach($site['points'][$id] as $key => $p_id){
					$a = current(download_data($sql, 'Punkt_Trasy', array('Edukacyjnosc'), array('idPunkt_Trasy' => $p_id)));
					if($a['Edukacyjnosc'] ==1){
						$site['educational_points'][$id]++;
					}
				}
						
				
		}
		//W tym momecie w $site['educational_points'][3]
		arsort($site['educational_points']);
		$pattern = array();
		foreach($site['educational_points'] as $key => $values){
			$pattern[] = $key;
		}
		
		// iiii tutaj w $patern mamy po kolei ID tras w kolejności od najbardziej edukacyjnej do najmniej!
		
		foreach($pattern as $key=>$value){
			$site['data']['routes'][] =current(download_data($sql, 
						'Trasa',
						array('*'),
						array('idTrasa' => $value)
						));
		}		

		
			if(!count($site['data']['routes'])){
				$site['status']['statements']['errors'][]='Brak tras do wyświetlenia. Stwórz dla nas pierwszą trasę!';	
				$site['content'] = 'warning';
				$site['forward'] = 'strony dodawania trasy';
				header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/add_route.php");	
			}
			else{
				
				foreach($site['data']['routes'] as $key => $value){
				
					$site['data']['points_id'] = download_data($sql, 'Trasa_has_Punkt_Trasy', array('Punkt_Trasy_idPunkt_Trasy'),
																array('Trasa_idTrasa' => $site['data']['routes'][$key]['idTrasa']));
																
					if(count($site['data']['points_id'])){
						
						foreach($site['data']['points_id'] as $key2 => $id){
							$site['data']['points_id'][$key2] = current($site['data']['points_id'][$key2]);
						}	
						
						$site['data']['routes'][$key]['points'] = array();
						
						foreach($site['data']['points_id'] as $key2 => $id){
							$site['data']['routes'][$key]['points'][] = current(download_data($sql, 'Punkt_Trasy', array('*'), 
																		array('idPunkt_Trasy' => $site['data']['points_id'][$key2])));
						}
						
						if(!count($site['data']['routes'][$key]['points'])){
							
							$id = $site['data']['routes'][$key]['idTrasa'];
							$site['status']['statements']['point_errors'][$id]= "Nie udało się pobrać danych dotyczących punktów trasy";
							
						}			
					}
					else{					
						$id = $site['data']['routes'][$key]['idTrasa'];
						$site['status']['statements']['point_errors'][$id] = "Brak punktów przypisanych do danej trasy";
					}	
				
					//pobieramy dane zdjęć
					$site['data']['routes'][$key]['photos'] = array();
					$site['data']['routes'][$key]['photos'] = download_data($sql, 'Zdjecie', array('*'), array('Trasa_idTrasa' => $site['data']['routes'][$key]['idTrasa']), 'LIMIT 0,6');
				
					//ustalamy jak graficznie przedstawić trudność i popularność
					$site['data']['routes'][$key]['pop']['full'] = floor($site['data']['routes'][$key]['Licznik_popularnosci']/10);
					$site['data']['routes'][$key]['pop']['half'] = 0;
					if($site['data']['routes'][$key]['Licznik_popularnosci']%10 > 5){
						$site['data']['routes'][$key]['pop']['half'] = 1;
					}
					$site['data']['routes'][$key]['pop']['empty'] = 6 - $site['data']['routes'][$key]['pop']['full'] - $site['data']['routes'][$key]['pop']['half'];
				}
			}

	//}	
	
	
	screen_site($site);
?>