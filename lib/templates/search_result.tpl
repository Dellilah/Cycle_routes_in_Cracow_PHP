{*
    *
    * Wyświetlanie wyników wyszukiwania
    *
    * @package search_result.tpl
    * @author Alicja Cyganiewicz
    * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 11.06.2012
    * @version 1.0.1 11.06.2012
    *
*}

<h1> Wyniki wyszukiwania '{$search}'</h1>

<div>... w nazwie trasy </br>
	{if isset($result.routes_names) && count($result.routes_names)}
		<ul>{foreach from=$result.routes_names item=route}
				<li><a href="show_route.php?idTrasa={$route.idTrasa}">{$route.Nazwa}</a></li>
			{/foreach}
		</ul>
	{else}
		Nie znaleziono
	{/if}
</div>

<div>... w opisie trasy </br>
	{if isset($result.routes_descriptions) && count($result.routes_descriptions)}
		<ul>{foreach from=$result.routes_descriptions item=route}
				<li><a href="show_route.php?idTrasa={$route.idTrasa}">{$route.Nazwa}</a></li>
			{/foreach}
		</ul>
	{else}
		Nie znaleziono
	{/if}
</div>

<div>... w punktach tras </br>
	{if isset($result.points_name) && count($result.points_name)}
		<ul>{foreach from=$result.points_name item=point}
				<li><a href="show_point.php?idPunkt_Trasy={$point.idPunkt_Trasy}">{$point.Adres}</a></li>
			{/foreach}
		</ul>
	{else}
		Nie znaleziono
	{/if}
</div>