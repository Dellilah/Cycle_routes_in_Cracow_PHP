<?

	/**
	*  Wyświetlanie wszystkich tras
	*
	* @package index.php
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
	$site['content'] = 'all';
	$site['title'] = 'Wszystkie trasy ';
	
	/* Dane do nawigacji
	$site['max_per_site'] = 5;
	
	$site['status']['statements']['operation'] = download_sites_count($sql, $site['max_per_site'], 'Trasa');
	$site['content'] = 'all';
	
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
		
		
		if(isset($_GET['order'])){
			switch($_GET['order']){
				case 'popular':
					$order = 'ORDER BY Licznik_popularnosci DESC';
					$site['title'] = 'Popularne';
					$site['site_title'] = 'Trasy popularne';
					break;
				case 'fast':
					$order= 'ORDER BY Czas';
					$site['title'] = 'Szybkie';
					$site['site_title'] = 'Trasy szybkie';
					break;
				case 'hard':
					$order = 'ORDER BY Trudnosc DESC';
					$site['title'] = 'Trudne';
					$site['site_title'] = 'Trasy trudne';
					break;
				case 'recreative':
					$order = 'ORDER BY Trudnosc, Czas';
					$site['title'] = 'Rekreacyjne';
					$site['site_title'] = 'Trasy rekreacyjne';
					break;
				default:
					$order = 'ORDER BY idTrasa DESC';
					$site['site_title'] = 'Wszystkie trasy w serwisie';
			}
		}
		else{
			$order = '';
			$site['site_title'] = 'Wszystkie trasy w serwisie';
		}
			
			//pobranie danych dot. Tras
		if($site['data']['routes']=download_data($sql, 
					'Trasa',
					array('*'),
					array(),
					$order)){
				

		
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
							//$site['content'] = "statements";
						}			
					}
					else{
						$id = $site['data']['routes'][$key]['idTrasa'];
						$site['status']['statements']['point_errors'][$id] = "Brak punktów przypisanych do danej trasy";
						//$site['content'] = "statements";
					}	
				
					//ustalamy jak graficznie przedstawić trudność i popularność
					$site['data']['routes'][$key]['pop']['full'] = floor($site['data']['routes'][$key]['Licznik_popularnosci']/10);
					$site['data']['routes'][$key]['pop']['half'] = 0;
					if($site['data']['routes'][$key]['Licznik_popularnosci']%10 > 5){
						$site['data']['routes'][$key]['pop']['half'] = 1;
					}
					$site['data']['routes'][$key]['pop']['empty'] = 6 - $site['data']['routes'][$key]['pop']['full'] - $site['data']['routes'][$key]['pop']['half'];
					
					//pobieramy dane zdjęć
					$site['data']['routes'][$key]['photos'] = array();
					$site['data']['routes'][$key]['photos'] = download_data($sql, 'Zdjecie', array('*'), array('Trasa_idTrasa' => $site['data']['routes'][$key]['idTrasa']), 'LIMIT 0,6');
					
				}
				
				if(!isset($_GET['order'])){
					shuffle($site['data']['routes']);
				}
			}
		}
		else{
			$site['status']['statements']['errors'][]='Nie udało się pobrać danych dotyczących tras rowerowych';	
			$site['content'] = 'error';
		}
	//}
	// else{
		// $site['status']['statements']['errors'][]='Brak danych';	
		// $site['content'] = 'statements';
	// }
	
	$_SESSION['last'] = current_url($_SERVER['PHP_SELF'], $_GET);
	
	screen_site($site);
?>
	
	