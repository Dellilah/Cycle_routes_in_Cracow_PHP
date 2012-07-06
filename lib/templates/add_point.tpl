{*
    * Prototyp szablonu formularza dodawania punktu do listy Punktów tras
    *
    * @package add_point.tpl
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
    
    <form name="add_point" method="post" action="add_point.php">
        <fieldset>
            <legend>Dodanie charakterystycznego punktu trasy</legend>
            <p><label>Nazwa: </label><input type="text" name="Nazwa"
                                        {if isset($data.Nazwa)}
                                            value = "{$data.Nazwa}"
                                        {/if} autofocus required/>
                    <!-- Wyświetlenie błędów -->
                {if isset($errors.Nazwa)}
                        {$errors.Nazwa}
                {/if}</p>
            <p><label>Miasto: </label><input type="text" name="Miasto"
                                             {if isset($data.Miasto)}
                                                 value = "{$data.Miasto}"
                                            {else}
                                                value="Kraków"
                                            {/if} required/>
                    <!-- Wyświetlenie błędów -->
                {if isset($errors.Miasto)}
                        {$errors.Miasto}
                {/if}</p>
            <p><label>Ulica: </label><input type="text" name="Ulica"
                                            {if isset($data.Ulica)}
                                                 value = "{$data.Ulica}"
                                            {/if} required/>
                    <!-- Wyświetlenie błędów -->
                {if isset($errors.Ulica)}
                        {$errors.Ulica}
                {/if}</p>
            <p><label>Numer: </label><input type="text" name="Numer"
                                            {if isset($data.Numer)}
                                                 value = "{$data.Numer}"
                                            {/if}/>
                    <!-- Wyświetlenie błędów -->
                {if isset($errors.Numer)}
                        {$errors.Numer}
                {/if}</p>
            <p><label>Edukacyjność punktu <input name="Edukacyjnosc" value="1" type="checkbox"
                                                {if isset($data.Edukacyjnosc) && $data.Edukacyjnosc == '1'}
                                                    checked = "checked"
                                                {/if}></label></p>
       
        <input type="submit" name="submit" value="Dodaj">
	</fieldset>
    </form>