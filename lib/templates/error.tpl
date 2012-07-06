{*
	* Wyœwietlanie błędów
	*
	* @package statements.tpl.php
	* @author Alicja Cyganiewicz
	* @since 08.04.2012
	* @version 1.2
*}
	<div class="other">	<div><h2> Wystąpił błąd! </h2>

		{if isset($status.statements.errors)}
			{if count($status.statements.errors)}
			<ul>
				{foreach from=$status.statements.errors item=op key=k}
				<li>{$op}</li>
				 {/foreach}
			</ul>
			{else}
				{$status.statements.errors}
			{/if}
			
		{/if}
	</div>
	<div class="forward">Za chwilę nastąpi przekierowanie do 
						{if isset($forward)}
							{$forward}
						{else}
							strony głównej serwisu
						{/if}
	</div>
</div>