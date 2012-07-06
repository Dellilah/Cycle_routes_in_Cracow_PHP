{*
    *
    * Wyświetlenie listy tras
    *
    * @package all.tpl
    * @author Alicja Cyganiewicz
    * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 23.05.2012
    * @version 1.0.1 23.05.2012
    *
*}

<h1> {$site_title} </h1>

<ul class="routes_list">
	{foreach $data.routes item=route}
	<li>
		<div class="one_route_inf">
			{assign var=pom value=$route.idTrasa}
			{if isset($status.statements.point_errors.$pom)}
				<span class="errors"><b>{$status.statements.point_errors.$pom}!<b></span>
			{/if}
			<div class="google_map" name="{$route.idTrasa}" style="width: 300px; height: 200px; border: 1px solid black; background: gray; margin-left: 20px; z-index: 3">
				
				<!-- Tu będą mapki -->
			</div>
			{if !isset($status.statements.point_errors.$pom)}
				{foreach from=$route.points key=k item=v}
	   				 <div class="map_data_{$route.idTrasa}">
	     		  		  <div class = "lat" title="{$v.Dlugosc}" style="display:none"></div>
	     		 		  <div class="lng" title="{$v.Szerokosc}"></div>
	    			</div>
				{/foreach}
			{/if}
			<div class="rout_inf">
				<ul>
					<li><h2>
						{assign var=link value="show_route.php?idTrasa=`$route.idTrasa`"}
						<a href="{$link}">{$route.Nazwa}</a></h2></li>
					<li>
						<table>
					    <tr class="popularity">    
					       {section name=foo start=0 loop=$route.pop.full step=1}
					           <td> <img alt="" src="./fx/bitmapy/l_pop_peln.png"> </td>
					        {/section}
					        {if $route.pop.half == 1}
					           <td> <img alt="" src="./fx/bitmapy/l_pop_pol.png"> </td> 
					        {/if}
					        {section name=foo2 start=0 loop=$route.pop.empty step=1}
					           <td> <img alt="" src="./fx/bitmapy/l_pop_pust.png"> </td>
					        {/section}
					    </tr>
						</table>
					</li>
					<li>
						<table>
					    <tr class="popularity"> 
						{section name=foo3 start=0 loop=$route.Trudnosc step=1}
					           <td> <img alt="" src="./fx/bitmapy/l_trud_peln.png"> </td>
					    {/section}
					    {section name=foo2 start=0 loop=(6-($route.Trudnosc)) step=1}
					           <td> <img alt="" src="./fx/bitmapy/l_trud_pust.png"> </td>
					    {/section}

					    </tr>
						</table>

					</li>
					<li><h3>Potrzebujesz: {($route.Czas - ($route.Czas % 60) )/ 60}h {$route.Czas % 60}min </h3></li>
				</ul>
			</div>
			<div class="pictures_min">
				<h3> Zdjęcia z Trasy </h3>
				<ul>
   				 {foreach from=$route.photos key=k item=v}
    			<li><a class="pict" href ="{$v.Adres_url}" rel="shadowbox[Vacation]"> <img alt="photo" src="{$v.Adres_url_min}" style="width: 90px; height:75px"></a></li>
  				 {/foreach}
				</ul>
			</div>
			<span class="more"><a href="{$link}">więcej...</a></span>
		</div>
	</li>
	{/foreach}
</ul>
