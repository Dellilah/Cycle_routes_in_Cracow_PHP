<?

	/**
	*  Obs³uga nawigacji
	*
	* @package sites.inc.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 23.05.2012
    * @version 1.0.1 23.05.2012
    */	
	
	/**
     * Ustalenie liczby wszystkich stron.
     *
     * @param array $sql Konfiguracja po³¹czenia z baz¹ danych
     * @param integer $max_per_site Maksymalna liczba rekordów jakie mog¹ zostaæ wyœwietlone na pojedynczej stronie
	 * @param string $table Tabela w której liczymy
	 * @param array $conditions Tablica warunków liczenia
     * @return integer Iloœæ wszystkich stron, na których bêd¹ prezentowane wyniki zapytania
     */
    
	function download_sites_count(&$sql, $max_per_site, $table, $conditions=array()) {
   
        $sites_count = 0;
   
        $result = download_data($sql, $table, array('COUNT(*)' => 'count'), $conditions);
		
		//return current($result);
       
        if(count($result)) {
            $result = current($result);
            $sites_count = ceil($result['count']/$max_per_site);
        }
   
        return $sites_count;
    }
	
	
	/**
     * Ustawienie aktualnego numeru strony na podstawie danych pochodz¹cych z tablicy $_GET i liczby wszystkich stron.
     *
     * @param integer $sites_count Iloœæ wszystkich stron, na których bêd¹ prezentowane wyniki zapytania
     * @param integer $site_number Numer strony jaki zosta³ pobrany z tablicy $_GET
     */
    function current_site_number($sites_count, $site_number) {
       
        $current_site = 1;
       
        if(ctype_digit($site_number) && ($site_number>0) && ($site_number<=$sites_count)) {
            $current_site = $site_number;
        }
       
        return $current_site;
       
    }