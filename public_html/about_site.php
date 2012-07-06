<?php
	
	/**
	* O stronie
	*
	* @package about_site.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 26.06.2012
    * @version 1.0.1 26.06.2012
    */
	
	//SESJA
	session_start();
	session_regenerate_id();
	
	//Załączenie pliku nagłówkowego
	include 'cms.h.php';
	
	$site['content'] = 'about_site';

	screen_site($site);
?>