{*
    *
    * Wyświetlanie trasy
    *
    * @package show_route.tpl
    * @author Alicja Cyganiewicz
    * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 23.05.2012
    * @version 1.0.1 23.05.2012
    *
*}

{assign var="datas" value=$data.route}

<h1>{$datas.Nazwa}</h1>

<div id="mapka">   
        <!-- tu będzie mapa -->   
</div>
<div id="wskazowki">
        </div>

<ul class="short_info">
    <iframe
src="http://www.facebook.com/plugins/like.php?href=http://akacja.wzks.uj.edu.pl/~09_cyganiewicz/show_route.php?idTrasa={$datas.idTrasa}
&layout=standard&show_faces=false& width=450&action=like&colorscheme=light&height=80"
scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px;
height:80px;" allowTransparency="true"></iframe>
    <li> <strong> Popularność </strong> 
        <ul class="icons">
            {section name=foo start=0 loop=$datas.pop.full step=1}
                <li> <img src="./fx/bitmapy/l_pop_peln.png" alt=""> </li>
            {/section}
            {if $datas.pop.half == 1}
                <li> <img src="./fx/bitmapy/l_pop_pol.png" alt=""> </li> 
            {/if}
            {section name=foo2 start=0 loop=$datas.pop.empty step=1}
                <li> <img src="./fx/bitmapy/l_pop_pust.png" alt=""> </li>
            {/section}
        </ul>
    </li>
    <li> <strong> Trudność </strong>
        <ul class="icons">
            {section name=foo3 start=0 loop=$datas.Trudnosc step=1}
                <li> <img src="./fx/bitmapy/l_trud_peln.png" alt=""> </li>
            {/section}
            {section name=foo2 start=0 loop=(6-($datas.Trudnosc)) step=1}
                <li> <img src="./fx/bitmapy/l_trud_pust.png" alt=""> </li>
            {/section}
        </ul>
    </li>
    <li><strong>Czas </strong>:  {($datas.Czas - ($datas.Czas % 60) )/ 60}h {$datas.Czas % 60}min 	</li>
</ul>
	<div style="margin:40px;"><strong>Opis </strong>:   {$datas.Opis} </div>

<h2> Punkty Trasy </h1>
  {if !isset($status.statements.point_errors)}
   <ul class="points">
        	{foreach from=$datas.points key=k item=v}
        	<li>{$v.Adres}</li>
            
                <div class = "start_lat" title="{$datas.points.0.Dlugosc}" style="display:none"></div>
                <div class="start_lng" title="{$datas.points.0.Szerokosc}"></div>
                {assign var="count" value=count($datas.points)-1}
                <div class = "stop_lat" title="{$datas.points.$count.Dlugosc}" style="display:none"></div>
                <div class="stop_lng" title="{$datas.points.$count.Szerokosc}"></div>
            
            <div class="map_data">
                <div class = "lat" title="{$v.Dlugosc}" style="display:none"></div>
                <div class="lng" title="{$v.Szerokosc}"></div>
            </div>
        	{/foreach}
    </ul>
   {else}
      {$status.statements.point_errors}
   {/if}

<h2> Zdjęcia z Trasy </h2>
{assign var=link value="clear_routes_pictures.php?idTrasa=`$datas.idTrasa`"}
<a href={$link}><img src="./fx/bitmapy/trashcan_delete.png" alt="usuń wszystkie zdjęcia"/></a>
<div id="gallery">
    <ul>
        {foreach from=$datas.photos key=k item=v}
        <li>
            <a class="pict" href ="{$v.Adres_url}" rel="shadowbox[Vacation]"><img src="{$v.Adres_url_min}" style="width:100px; height: 80px;"></a>
           <a href="delete_picture.php?idZdjecie={$v.idZdjecie}"><img src="./fx/bitmapy/delete.png" style="width: 25px; height: 25px;" alt="usuń zdjęcie"></a>
        </li>
        {/foreach}
    </ul>
</div>

<form enctype="multipart/form-data" action="add_pictures.php" method="POST">
   <fieldset class="add_picture_area">
      
        <legend>Dodaj zdjęcia z trasy</legend>
    <div class="add_picture" data-number="1">
        1. <input name="img_1" type="file"> 
    </div>

   <input type="button" id="add_field_picture" value="+" />
   <input type="hidden" name="idTrasa" value="{$datas.idTrasa}">
   <input type="hidden" name="redirect" value="{$smarty.server.PHP_SELF}">
  <input type="submit" value="Wgraj">

    </fieldset>
</form>

