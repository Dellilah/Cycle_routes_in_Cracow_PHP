<?

	/**
	*  Dodawanie nowej trasy do bazy danych
	*
	* @package add_route.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 03.05.2012
    * @version 1.0.1 03.05.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	//Podstawowe dane dla szablonów
	$site['content'] = 'add_route';
	$site['title'] = 'Dodawanie Trasy';
	$flaga=1;
	
	$_SESSION['last'] = 'add_route.php';
	
	if(authorization()){
		
		//sprawdzamy czy zostały wysłane dane z formularza
		if(isset($_POST) && count($_POST)){
			
			//pobieramy podstawowe dane trasy, bez punktów na razie
			$pattern1 = array('Nazwa', 'Trudnosc', 'Czas', 'Opis');
			$site['data'] = download_from_form($pattern1, $_POST);
			array_push($pattern1, "Uzytkownik_idUzytkownik");
			$site['data']['Uzytkownik_idUzytkownik'] = $_SESSION['user']['idUzytkownik'];
			if(insert_data($sql, 'Trasa', $site['data'], $pattern1)){
				
				
				$site['data']['Trasa_Punkt']= array();
									
				$site['data']['Trasa_idTrasa'] = download_data($sql, 'Trasa', array('idTrasa'), array('Nazwa' => $site['data']['Nazwa']));				
				$site['data']['Trasa_idTrasa'] = current(current($site['data']['Trasa_idTrasa']));
				$site['data']['Trasa_Punkt']['Trasa_idTrasa'] = $site['data']['Trasa_idTrasa'];				
				
				//walka z punktami
				$pattern2 = array('points_count');
				$site['data']['points'] = array();
				$site['data']['points'] = download_from_form($pattern2, $_POST);
				
				$i=1;
				for($i; $i<=$site['data']['points']['points_count']; $i++){
					
					if(isset($site['data']['Trasa_Punkt']['Punkt_Trasy_idPunkt_Trasy'])){
						unset($site['data']['Trasa_Punkt']['Punkt_Trasy_idPunkt_Trasy']);
					}
				
					$pattern_temp = array('Adres'.$i, 'Dlugosc'.$i, 'Szerokosc'.$i, 'Edukacyjnosc'.$i);
					$site['data']['points'][$i] = download_from_form($pattern_temp, $_POST);
					
					//pozbywamy sie cyferek 
						$site['data']['point']['Adres'] = $site['data']['points'][$i]['Adres'.$i];
						$site['data']['point']['Dlugosc'] = $site['data']['points'][$i]['Dlugosc'.$i];
						$site['data']['point']['Szerokosc'] = $site['data']['points'][$i]['Szerokosc'.$i];
						$site['data']['point']['Edukacyjnosc'] = $site['data']['points'][$i]['Edukacyjnosc'.$i];
						
					if($site['data']['point']['Edukacyjnosc'] == 'on'){
						$site['data']['point']['Edukacyjnosc'] = 1;
					}
					else{
						$site['data']['point']['Edukacyjnosc'] = 0;
					}
					
					list($ul_nr, $kod_miasto, $kraj) = explode(',', $site['data']['point']['Adres']);
					$site['data']['point']['Adres'] = $ul_nr.', '.$kod_miasto;

					
					$pattern3 = array('Adres', 'Dlugosc', 'Szerokosc', 'Edukacyjnosc');
					
					//musimy sprawdzić czy dany punkt istnieje już w bazie
					
					//$site['data']['tmp'] = current(download_data($sql, 'Punkt_Trasy', array('COUNT(*)'=> 'count'),
																	//array('Nazwa' => $site['data']['point']['Nazwa'])));
					
					//jeżeli punkt nie istnieje - dodajemy go do bazy
					//if($site['data']['tmp']['count'] <= 0){
						if(!insert_data($sql, 'Punkt_Trasy', $site['data']['point'], $pattern3)){
							$site['status']['statements']['errors'][] = "Nie udało się zapisać punktu trasy. Całość trasy nie zostaje zapisana w bazie";
							$site['content'] = 'error';
							$site['forward'] = "strony dodawania trasy";
							header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/add_route.php");
						}
					//}
					
					//jeżeli nie zostały odnotowane żadne błędy (udało się dodać nowy punkt do bazy) - pobieramy ID tego punktu, żeby móc połączyć z trasą
					if(!isset($site['status']['statements']['errors'])){
					
						$site['data']['Punkt_Trasy_idPunkt_Trasy'] = download_data($sql, 'Punkt_Trasy', array('idPunkt_Trasy'), 
																				array('Dlugosc' => $site['data']['point']['Dlugosc'], 'Szerokosc' => $site['data']['point']['Szerokosc']));
						$pom = count($site['data']['Punkt_Trasy_idPunkt_Trasy']);
						
																				
						$site['data']['Punkt_Trasy_idPunkt_Trasy'] = $site['data']['Punkt_Trasy_idPunkt_Trasy'][$pom-1]['idPunkt_Trasy'];
						
						$site['data']['Trasa_Punkt']['Punkt_Trasy_idPunkt_Trasy'] = $site['data']['Punkt_Trasy_idPunkt_Trasy'];
						
						if($connect = database_connect($sql)){
			
							$query = "INSERT INTO Trasa_has_Punkt_Trasy (Trasa_idTrasa, Punkt_trasy_idPunkt_Trasy) VALUES ('".$site['data']['Trasa_Punkt']['Trasa_idTrasa']."', '".$site['data']['Trasa_Punkt']['Punkt_Trasy_idPunkt_Trasy']."')";
							
							if(!database_query($query)){
								$flaga = 0;
							}
						}
						else{
							$site['status']['statements']['errors'][] = "Nie udało połączyć się z bazą";
							$site['content'] = 'error';
							$site['forward'] = "strony dodawania trasy";
							header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/add_route.php");
						}
						
						if($flaga == 1){
							$site['status']['statements']['operation'][] = "Trasa została dodana do bazy!";
							$site['content'] = 'statements';
							$site['forward'] = "strony nowo dodanej trasy";
							header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route.php?idTrasa=".$site['data']['Trasa_Punkt']['Trasa_idTrasa']);
						}
						else{
							$site['status']['statements']['errors'][] = "Nie udało się załączyć wszystkich punktów trasy";
							$site['content'] = 'error';
							$site['forward'] = "strony dodawania trasy";
							header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/add_route.php");
						}
			
					}
					else{
						$site['status']['statements']['errors'][] = "Nie udało się zapisać któregoś z punktów trasy. Trasa nie zostanie zapisana.";
						$site['content'] = 'error';
						$site['forward'] = "strony dodawania trasy";
						header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/add_route.php");

					}
				
				}
			}
			else{
				$site['status']['statements']['errors'][] = "Dodawanie trasy nie powiodło się.";
				$site['content'] = 'error';
				$site['forward'] = "strony dodawania trasy";
				header("Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/add_route.php");
			}
			//jeżeli nie wystąpiły dotąd żadne błędy to możemy pomyśleć o dodaniu zdjęć
			if(!isset($site['status']['statements']['errors'])){

				//ścieżka do pliku z obrazkami z tras
				$path = 'fx/bitmapy/Trasa_';
				$id_T = $site['data']['Trasa_Punkt']['Trasa_idTrasa'];
				
				if(count($_FILES) && isset($_FILES['img_1']['name']) &&($_FILES['img_1']['name'])!= ''){
						
					foreach($_FILES as $key=>$value){

						if(!is_dir($path.$id_T)){
							mkdir($path.$id_T, 0777);
							mkdir($path.$id_T.'/min', 0777);
						}
						if(is_dir($path.$id_T)){
							$add_path = $path.$id_T;
							$u_plik = $value['tmp_name'];
							$u_nazwa = $value['name'];
							$u_rozmiar = $value['size'];
							$mime = $value[ 'type'];

							if( strpos( $mime, 'image/' ) === false ){
								$site['status']['statements']['errors'][] = "Jeden z plików nie jest obrazkiem. Trasa dodana do bazy bez tego zdjęcia.";
								$site['content'] = "error";
								$site['forward'] = "strony trasy";
								header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa='.$id_T);
							}
							elseif(is_uploaded_file($u_plik)){
								move_uploaded_file($u_plik, $add_path."/".$u_nazwa);
								chmod($add_path."/".$u_nazwa, 0777);
								
								require_once '../lib/inc/ThumbLib.inc.php';
								$thumb = PhpThumbFactory::create($add_path."/".$u_nazwa);//adres zdjęcia do przeskalowania
								$thumb->adaptiveResize(50, 50);
								$thumb->save($add_path."/min/".$u_nazwa);
								//copy($add_path."/".$u_nazwa, $add_path."/min/".$u_nazwa);
								
								chmod($add_path."/min/".$u_nazwa, 0777);
								
								$site['data']['Adres_url'] = $add_path."/".$u_nazwa;
								$site['data']['Adres_url_min'] = $add_path."/min/".$u_nazwa;
								$site['data']['Trasa_idTrasa'] = $id_T;
								$site['data']['Uzytkownik_idUzytkownik'] = $_SESSION['user']['idUzytkownik'];
								
								$pattern = array('Adres_url', 'Adres_url_min', 'Trasa_idTrasa', 'Uzytkownik_idUzytkownik');
								
								if(!insert_data($sql, 'Zdjecie', $site['data'], $pattern)){
								
									$site['status']['statements']['errors'][] = "Jedno ze zdjęć nie zostało dodane do bazy. Została dodana trasa.";
									$site['content'] = "error";
									$site['forward'] = "strony trasy";
									header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa='.$id_T);								
								}
								// header("Location: ".$_POST['redirect']."?idTrasa=".$_POST['idTrasa']); 
								// exit;
							}
							else{
								$site['status']['statements']['errors'][] = "Nie udało się załadować ".$u_nazwa.". Trasa została dodana";
								$site['content'] = "error";
								$site['forward'] = "strony trasy";
								header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa='.$id_T);
							}
						}
					}
				}
			}
			
		}
	}
	else{
		$site['status']['statements']['errors'][]= "Dostęp wymaga zalogowania";
		$site['content'] = "warning";
		$site['forward'] = "odpowiedniej strony";
		header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/login.php');
	}
	
	screen_site( $site);
?>
			
			