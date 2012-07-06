{*
	* Prototyp szablonu Logowania
	*
	* @package login.tpl.php
	* @author Alicja cyganiewicz
	* @since 14.04.2012
	* @version 1.1
*}
<div  class="other2">
	{if isset($status.statements.form_errors) && count($status.statements.form_errors)}
		<div> Błąd logowania </div>
	{/if}
    {if isset($status.statements.errors)}
		<div> {$status.statements.errors} </div>
	{/if}
		
	<form method="post" action="login.php">
	
	Login/E-mail<input type="text" name="Login" 
                {if isset($data.Login)}
                    value="{$data.Login}"
                {/if}/>
	
	<!-- Wyświetlenie błędów -->
	{if isset($errors.Login)}
		{$errors.Login}
	{/if}
	<br/>
	Hasło 
	<input type="password" name="Haslo" />
	
	<!-- Wyświetlenie błędów -->
	{if isset($errors.Haslo)}
		{$errors.Haslo}
	{/if}
    <br/>    
	<input type="submit" name="submit" value="Zaloguj">
	</form>
	<a href="sign_up.php">Zarejestruj</a>
</div>