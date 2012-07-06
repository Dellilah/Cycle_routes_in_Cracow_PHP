{*
    *
    * Strona usuwania tras
    *
    * @package delete_route.tpl
    * @author Alicja Cyganiewicz
    * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 19.06.2012
    * @version 1.0.1 19.06.2012
    *
*}

<h1> Lista tras do usunięcia </h1>

{if !isset($data) || !count($data)}
	<h2> Brak tras do usunięcia </h2>
{else}
	<ul>
		{foreach from=$data item=route}
			<li> {$route.Nazwa} <a href="delete_route.php?idTrasa={$route.idTrasa}"> usuń </a> </li>
		{/foreach}
	</ul>
{/if}