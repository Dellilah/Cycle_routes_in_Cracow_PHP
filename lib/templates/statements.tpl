{*
	* Wyœwietlanie komunikatów
	*
	* @package statements.tpl.php
	* @author Alicja Cyganiewicz
	* @since 08.04.2012
	* @version 1.2
*}
<div class="other">
	<div>	<h2> Gratuluję! </h2>

		{if isset($status.statements.operation)}
			{if count($status.statements.operation)}
			<ul>
				{foreach from=$status.statements.operation item=op key=k}
				<li>{$op}</li>
				 {/foreach}
			</ul>
			{else}
				{$status.statements.operation}
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