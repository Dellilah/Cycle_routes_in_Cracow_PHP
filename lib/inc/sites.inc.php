<?

	/**
	*  Obs�uga nawigacji
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
     * @param array $sql Konfiguracja po��czenia z baz� danych
     * @param integer $max_per_site Maksymalna liczba rekord�w jakie mog� zosta� wy�wietlone na pojedynczej stronie
	 * @param string $table Tabela w kt�rej liczymy
	 * @param array $conditions Tablica warunk�w liczenia
     * @return integer Ilo�� wszystkich stron, na kt�rych b�d� prezentowane wyniki zapytania
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
     * Ustawienie aktualnego numeru strony na podstawie danych pochodz�cych z tablicy $_GET i liczby wszystkich stron.
     *
     * @param integer $sites_count Ilo�� wszystkich stron, na kt�rych b�d� prezentowane wyniki zapytania
     * @param integer $site_number Numer strony jaki zosta� pobrany z tablicy $_GET
     */
    function current_site_number($sites_count, $site_number) {
       
        $current_site = 1;
       
        if(ctype_digit($site_number) && ($site_number>0) && ($site_number<=$sites_count)) {
            $current_site = $site_number;
        }
       
        return $current_site;
       
    }