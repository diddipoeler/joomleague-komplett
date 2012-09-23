<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<table width="100%" class="contentpaneopen">
	<tr>
		<td class="contentheading">
			<?php
			if ( $this->config['show_team_shortform'] == 1 && !empty($this->team->short_name))
			{
				echo '&nbsp;' . JText::sprintf( 'JL_ROSTER_TITLE2', $this->team->name, $this->team->short_name );
			}
			else
			{
				echo '&nbsp;' . JText::sprintf( 'JL_ROSTER_TITLE', $this->team->name );
			}
			?>
		</td>
	</tr>
	
</table>
<br />