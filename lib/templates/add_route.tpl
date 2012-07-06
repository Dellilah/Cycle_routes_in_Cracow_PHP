{*
    *
    * Dodawanie trasy
    *
    * @package add_route.tpl
    * @author Alicja Cyganiewicz
    * @link http://www.akacja.wzks.uj.edu.pl/Licencjat/CMS
    * @since 3.05.2012
    * @version 1.0.1 3.05.2012
    *
*}
    {if isset($status.statements.form_errors) && count($status.statements.form_errors)}
        <div>Błędnie wypełniony formularz</div>
        {$errors = $status.statements.form_errors}
    {/if}

    
    <form enctype="multipart/form-data" name="add_route" method="post" action="add_route.php">
        <fieldset class="adding_route">
            <legend>Dodaj nową trasę!</legend>
            <ul class="add_route">
                    
                <li><label style="margin-right: 98px;">Nazwa: </label><input type="text" name="Nazwa" size="40"
                                            {if isset($data.Nazwa)}
                                                value = "{$data.Nazwa}"
                                            {/if} />
                        <!-- Wyświetlenie błędów -->
                    {if isset($errors.Nazwa)}
                            {$errors.Nazwa}
                    {/if}</li>
                
                <li><label>Trudność: </label>
                   <ul class="icons_choice">
                    {section name=foo loop=6} 
                        <li name="{$smarty.section.foo.iteration}"><img src="./fx/bitmapy/l_trud_pust.png"></li>
                    {/section}
                    </ul>
                    <input type="hidden" name="Trudnosc" value = " "/>
                </li>
                
                <li><label style="margin-right: 7px;">Czas [w minutach]: </label><input type="text" name="Czas" size="7"
                                            {if isset($data.Czas)}
                                                value = "{$data.Czas}"
                                            {/if} />
                        <!-- Wyświetlenie błędów -->
                    {if isset($errors.Czas)}
                            {$errors.Czas}
                    {/if}</li>
                
                <li><label class="textarea">Opis trasy: </label><textarea cols="92" rows="10" name="Opis"
                                            {if isset($data.Opis)}
                                                value = "{$data.Opis}"
                                            {/if} d/></textarea>
                        <!-- Wyświetlenie błędów -->
                    {if isset($errors.Opis)}
                            {$errors.Opis}
                    {/if}</li>
            </ul>

            <h1>Punkty Trasy </h1>
            Kliknij na mapę, aby dodać punkt trasy
             <div id="mapa_add" style="width: 600px; height: 400px; border: 1px solid black; background: gray; margin-left: 20px; z-index: 3">
             </div>
             <!-- <input type="text" id="latlongclicked" style="width:300px; border:1px inset gray;"> -->
             <div class="add_point" data-number="0">
             </div>
            <!-- <span style="margin-right: 170px; margin-left: 55px">Nazwa</span>
            <span style="margin-right: 100px;">Miasto [Kraków]</span>
            <span style="margin-right: 180px;">Ulica</span>
            <span> Numer</span>
            

            <div class = "add_point" data-number="1">1.  
                                             
                                              <input type='text' name='Nazwa1' id='nazwa_1' size='30'>
                                         
                                              <input type='text' name='Miasto1' id='miasto_1' value="Kraków" size='30'>

                                              <input type='text' name='Ulica1' id='ulica_1' size='30'>

                                              <input type='text' name='Numer1' id='numer_1' size='10'>

                                              <input type='checkbox' name='Edukacyjnosc1' id='edukacyjnosc_1'>Edukacyjność<br/>

                                              <input type="hidden" name="points_count" value="1">

                                              <input type="button" class="remove_field_point" value="-" />
            </div>

            

            <img src="./fx/bitmapy/add_button.png" alt="ADD" id="add_field_point"/> -->
      
                <h1>Dodaj zdjęcia z trasy</h1>
            <div class="add_picture" data-number="1">
                1. <input name="img_1" type="file"> 
            </div>

           <img src="./fx/bitmapy/add_button.png" alt="ADD" id="add_field_picture"/>

            </fieldset>


        <input type="image" src="./fx/bitmapy/add_route_button.png" alt="DODAJ TRASĘ" class="add_route_button"/>
	
    </form>