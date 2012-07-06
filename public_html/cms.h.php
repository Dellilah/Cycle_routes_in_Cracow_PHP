<?php
    /**
     * Załączenie wszystkich niezbędnych bibliotek.
     *
     * @package cms.h.php
     * @author Alicja Cyganiewicz
     * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
     * @since 1.04.2012
     * @version 1.0.2 13.04.2012
     */

    // konfiguracja developerska:
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors','on');
	ini_set('default_charset', 'utf-8');

    
    // załączenie bibliotek:
    include dirname(dirname(__FILE__)) . '/lib/inc/configuration.inc.php';
	include dirname(dirname(__FILE__)) . '/lib/inc/templates.inc.php';
	include dirname(dirname(__FILE__)) . '/lib/inc/form_action.inc.php';
	include dirname(dirname(__FILE__)) . '/lib/inc/database_service.inc.php';
	include dirname(dirname(__FILE__)) . '/lib/inc/database_queries.inc.php';
	include dirname(dirname(__FILE__)) . '/lib/inc/database_use.inc.php';
	include dirname(dirname(__FILE__)) . '/lib/inc/auth.inc.php';
	include dirname(dirname(__FILE__)) . '/lib/inc/additional.inc.php';
	include dirname(dirname(__FILE__)) . '/lib/inc/sites.inc.php';