<?php defined('_JEXEC') or die('Restricted access');
?>		

<fieldset class="adminform">
	<legend>
		<?php
		echo JText::_( 'JL_ADMIN_LEAGUE_EXT' );
		?>
	</legend>
	<table>
		<tr>
			<td colspan="2">
				<?php
				foreach ( $this->extended->getGroups() as $key => $groups )
				{
					// render is defined in joomla\libraries\joomla\html\parameter.php
					echo $this->extended->render( 'extended', $key );
				}
				?>
			 </td>
		</tr>
	</table>
</fieldset>
