<?php

    /** Listing POPULARNYCH tras
    *
    * @package popular.php
    * @author Alicja Cyganiewicz
    * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 29.04.2012
    * @version 1.0.1 29.04.2012
    */
    
    session_start();
    
    //SESJA
    session_start();
    session_regenerate_id();
	
    //Za³¹czenie pliku nag³ówkowego
    include 'cms.h.php';
	
    //Podstawowe dane dla szablonów
    $site['content'] = 'popular';
    $site['title'] = 'Popularne trasy';
    
    $site['data']['routes_by_popularity'] = download_data($sql, 'Trasa', array('*'), array(), 'ORDER BY \'Licznik_popularnosci\' DESC');
   
    foreach($site['data']['routes_by_popularity'] as $route){
            $ids = download_data($sql, 'Trasa_has_Punkt_Trasy', array('Punkt_Trasy_idPunkt_Trasy'), array('Trasa_idTrasa' => $route['idTrasa']'zz;  
    screen_site($site);
?>
