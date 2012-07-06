{*
	* Prototyp szablonu edycji profilu użytkownika
	*
	* @package edit_profile.tpl
	* @author Alicja cyganiewicz
	* @since 18.05.2012
	* @version 1.1
*}
	
	{if isset($status.statements.form_errors) && count($status.statements.form_errors)}
		<div> Błędnie wypełniony formularz </div>
                <!-- Skracamy dostęp do błędów, ponieważ będziemy ich sporo używać -->
                {$errors = $status.statements.form_errors}
	{/if}
		
	<form method="post" action="edit_profile.php">
            <fieldset>
                <legend> {$smarty.session.user.Login}, edytuj dane </legend>
                <ul>
                <li> <label>Imię </label><input type="text" name="Imie" value="{$data.Imie}"/>
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Imie)}
                        {$errors.Imie}
                {/if} </li>
                
                <li> <label> Nazwisko </label><input type="text" name="Nazwisko" value="{$data.Nazwisko}"/>
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Nazwisko)}
                        {$errors.Nazwisko}
                {/if}</li>
                
                <li> <label>HASŁO </label><input type="password" name="Haslo" />
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Haslo)}
                        {$errors.Haslo}
                {/if}</li>
                
                <li> <label>HASŁO PONOWNIE </label><input type="password" name="Haslo_ponownie" />
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Haslo_ponownie)}
                        {$errors.Haslo_ponownie}
                {/if}</li>
                
                <li> <label> EMAIL </label><input type="text" name="Email" value="{$data.Email}"/>
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Email)}
                        {$errors.Email}
                {/if}</li>
                
                <input type="submit" name="submit" value="Edycja">
            </fieldset>
	</form>