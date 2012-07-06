{*
    *
    * Lista wszystkich punktów
    *
    * @package all_points.tpl
    * @author Alicja Cyganiewicz
    * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 19.06.2012
    * @version 1.0.1 19.06.2012
    *
*}
<h1>  Lista wszystkich punktów tras </h1>

<ul class = "all_points">
	{foreach from=$data item=point}
	<li> {$point.Nazwa} <a href="show_point.php?idPunkt_Trasy={$point.idPunkt_Trasy}"> >>> </a></li>
	<div class="map_data">
                <div class = "city" title="{$point.Miasto}"></div>
                <div class="street" title="{$point.Ulica}"></div>
                <div class="number" title="{$point.Numer}"></div>
    </div>
	{/foreach}
</ul>

<div id="mapka">   
        <!-- tu będzie mapa -->   
</div>