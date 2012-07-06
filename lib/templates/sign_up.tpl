{*
	* Prototyp szablonu rejestracji
	*
	* @package sign_up.tpl.php
	* @author Alicja cyganiewicz
	* @since 14.04.2012
	* @version 1.1
*}
	
	{if isset($status.statements.form_errors) && count($status.statements.form_errors)}
		<div> Błędnie wypełniony formularz </div>
                <!-- Skracamy dostęp do błędów, ponieważ będziemy ich sporo używać -->
                {$errors = $status.statements.form_errors}
	{/if}
		
	<form method="post" action="sign_up.php">
            <fieldset class="sign_up">
                <legend> Zarejestruj się! </legend>
                <ul>
                <li> <label>Imię </label><input type="text" name="Imie" 
                        {if isset($data.Imie)}
                            value="{$data.Imie}"
                        {/if}/>
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Imie)}
                        {$errors.Imie}
                {/if} </li>
                
                <li> <label> Nazwisko </label><input type="text" name="Nazwisko" 
                        {if isset($data.Nazwisko)}
                            value="{$data.Nazwisko}"
                        {/if}/>
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Nazwisko)}
                        {$errors.Nazwisko}
                {/if}</li>
                
                <li> <label> Login </label><input type="text" name="Login" 
                        {if isset($data.Login)}
                            value="{$data.Login}"
                        {/if}/>
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Login)}
                        {$errors.Login}
                {/if}</li>
                
                <li> <label>Hasło </label><input type="password" name="Haslo" />
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Haslo)}
                        {$errors.Haslo}
                {/if}</li>
                
                <li> <label>Hasło ponownie </label><input type="password" name="Haslo_ponownie" />
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Haslo_ponownie)}
                        {$errors.Haslo_ponownie}
                {/if}</li>
                
                <li> <label> E-mail </label><input type="text" name="Email"  
                        {if isset($data.Email)}
                            value="{$data.Email}"
                        {/if}/>
                
                <!-- Wyświetlenie błędów -->
                {if isset($errors.Email)}
                        {$errors.Email}
                {/if}</li>
                
               <input type="image" src="./fx/bitmapy/sign_up_button.png" alt="Zarejestruj" class="sign_up_button"/>
            </fieldset>
	</form>