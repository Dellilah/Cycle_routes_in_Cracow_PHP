<?php
	
	/**
	* Dodawanie zdjęć do trasy
	*
	* @package add_pictures.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 30.05.2012
    * @version 1.0.1 30.05.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	$path = 'fx/bitmapy/Trasa_';
	$site['status']['statements']['operation'] = array();
	
	$_SESSION['last'] = 'show_route.php?idTrasa='.$_POST['idTrasa'];
	
	if(authorization()){
		
		if(count($_FILES) && isset($_FILES['img_1']['name']) &&($_FILES['img_1']['name'])!= ''){
			
			foreach($_FILES as $key=>$value){

				if(!is_dir($path.$_POST['idTrasa'])){
					mkdir($path.$_POST['idTrasa'], 0777);
					mkdir($path.$_POST['idTrasa'].'/min', 0777);
				}
			
				
				if(is_dir($path.$_POST['idTrasa'])){
					$add_path = $path.$_POST['idTrasa'];
					$u_plik = $value['tmp_name'];
					$u_nazwa = $value['name'];
					$u_rozmiar = $value['size'];
					$mime = $value[ 'type'];

					if( strpos( $mime, 'image/' ) === false ){
						$site['status']['statements']['errors'][] = "Plik nie jest obrazkiem";
						$site['content'] = "error";
						$site['forward'] = "strony trasy";
						header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa='.$_POST['idTrasa']);
						//$_GET['idTrasa'] = $_POST['idTrasa'];
						//include 'show_route.php';
						//exit;
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
						$site['data']['Trasa_idTrasa'] = $_POST['idTrasa'];
						$site['data']['Uzytkownik_idUzytkownik'] = $_SESSION['user']['idUzytkownik'];
						
						$pattern = array('Adres_url','Adres_url_min', 'Trasa_idTrasa', 'Uzytkownik_idUzytkownik');
						if(!insert_data($sql, 'Zdjecie', $site['data'], $pattern)){
						
							$site['status']['statements']['errors'][] = "Obrazek nie został załączony do trasy";
							$site['content'] = "error";
							$site['forward'] = "strony trasy";
							header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa='.$_POST['idTrasa']);
							
						
						}

					}
					else{
						$site['status']['statements']['errors'][] = "Nie udało się załadować ".$u_nazwa;
						$site['content'] = "error";
						$site['forward'] = "strony trasy";
						header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa='.$_POST['idTrasa']);
					}
				}
			}
			if(!isset($site['status']['statements']['errors'])){
				header('Location:'.$_SESSION['last']);
				exit;
			}

		}
		else{
			$site['status']['statements']['errors'][] = "Nie wybrano plików do załadowania";
			$site['content'] = "warning";
			$site['forward'] = "strony trasy";
			header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route?idTrasa='.$_POST['idTrasa']);
		}
		
	}
	else{
		$site['status']['statements']['errors'][]= "Dostęp wymaga zalogowania";
		$site['content'] = "warning";
		$site['forward'] = "odpowiedniej strony";
		header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/login.php');
	}
	
	screen_site($site);

?>