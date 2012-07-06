<?php
	
	/**
	* Lista wszystkich punktów 
	*
	* @package all_points.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 19.06.2012
    * @version 1.0.1 19.06.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	$site['content'] = 'all_points';
	
	if(!$site['data'] = download_data($sql, 'Punkt_Trasy', array('*'))){
		$site['status']['statements']['errors'][]= "Brak punktów do wyświetlenia";
		$site['content'] = "error";
		header('Refresh: 5; url=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/');
	}
		
	screen_site($site);
?>