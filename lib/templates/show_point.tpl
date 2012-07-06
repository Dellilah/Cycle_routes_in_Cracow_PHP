{*
    *
    * Szczegóły punktu trasy
    *
    * @package show_point.tpl
    * @author Alicja Cyganiewicz
    * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 11.06.2012
    * @version 1.0.1 11.06.2012
    *
*}
<!-- <div class ="point_inf">
    <div class = "city" title="{$point.Miasto}" style="display:none"></div>
    <div class="street" title="{$point.Ulica}"></div>
    <div class="number" title="{$point.Numer}"></div>
</div>
<div id="mapka" style="width: 500px; height: 300px; border: 1px solid black; background: gray;">   
         
</div> -->

<h1>{$point.Adres}</h1>
<h2>Edukacyjność: {if $point.Edukacyjnosc == 1} TAK {else} NIE {/if}
<h2>Trasy, które prowadzą przez dany punkt</h2>
{if isset($routes_id) && count($routes_id)}
<ul>
	{foreach from=$routes item=route}
		<li><a href="show_route.php?idTrasa={$route.idTrasa}">{$route.Nazwa}</a></li>
	{/foreach}
</ul>
{/if}
