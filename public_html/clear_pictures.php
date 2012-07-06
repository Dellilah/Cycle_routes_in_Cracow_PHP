<?php
	
	/**
	* Usuwanie wszystkich zdjęć i ich folderów z bazy
	*
	* @package clear_pictures.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 06.06.2012
    * @version 1.0.1 06.06.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	$path = 'fx/bitmapy';
	$site['status']['statements']['operation'] = array();
	
	if(authorization()){
		
		foreach(glob($path . '/Trasa_*') as $dir) {
			
			rmdirr($dir);
			$site['status']['statements']['operation'][] = $dir;
			$site['content'] = 'statements';
			
		}
	}
	
	screen_site($site);
?>