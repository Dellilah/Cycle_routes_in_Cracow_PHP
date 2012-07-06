<?php
    /**
     * Obsługa szablonów.
     *
     * @package templates.inc.php
     * @author Alicja Cyganiewicz
     * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
     * @since 1.04.2012
     * @version 1.0.2 13.04.2012
     */

	//podpięcie bibioteki Smarty:
    include dirname(dirname(__FILE__)) . '/smarty/Smarty.class.php';
	
	//inicjacja obiektu Smarty:
    $smarty = new Smarty();

    $smarty->template_dir = dirname(dirname(__FILE__)) . '/templates';
    $smarty->compile_dir = dirname(dirname(__FILE__)) . '/templates_c'; 
    
    /**
     * Wyświetlenie szablonu.
     * 
     * @param array $site Dane do wyświetlenia w szablonie 
     * @param string $layout "Layout" strony
     * @global object $smarty Obiekt klasy Smarty
     * 
     */
	 
    function screen_site($site, $layout = 'layout.html') {
        global $smarty;
        $smarty->assign($site);
        $smarty->display($layout);
    }