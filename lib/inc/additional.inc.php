<?php
	
	/**
	*	Przydatne funkcje
	*
	* @package additional.inc.php
	* @author Alicja Cyganiewicz
	* @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 23.05.2012
    * @version 1.0.1 23.05.2012
    */
	
	/**
	* Sprawdzanie czy zmienna nale¿y do tablicy
	*
	* @param mixed $variable zmienna, której zawieranie sprawdzamy
	* @param array $content	tablica, któej zawartoœæ przeszukujemy
	* 
	* @return bool Zawieranie
	*/
	
	function does_belong_to($variable, $content){
	
		$a = 0;
		foreach($content as $key => $value){
			if($content[$key] == $variable)	
				$a=1;
		}
		if($a==0)
			return false;
		else
			return true;
		
	}
	
	/**
	* Usuwanie folderów wraz z ca³¹ ich zawartoœci¹
	*
	* @param string $file nazwa tego, co chcemy rekursywnie usun¹æ
	*
	*/
	
	function rmdirr($dir){
		
		foreach(glob($dir.'/*') as $file){
			if(is_dir($file)){
				rmdirr($file);
			}
			else{
				unlink($file);
			}
		}
		rmdir($dir);
	}
	
	/**
	* Uzyskiwanie "wywo³anego" url-u: wraz z parametrami z GET
	*
	* @param string $basic_url Podstawowy url
	* @param array $get Tablica zmiennych przekazanych przez GET
	* 
	* @return string Adres url z którego zosta³o wywo³ane
	*/
	
	function current_url($basic_url, $get){
		
		if(count($get)){
			foreach($get as $key => $value){
				if(isset($url)){
					$url .= '&'.$key.'='.$value;
				}
				else{
					$url = $basic_url.'?'.$key.'='.$value;
				}
			}
			return $url;
		
		}
		else{
			return $basic_url;
		}
	}