<?php defined('_JEXEC') or die('Restricted access');
?>		

<fieldset class="adminform">
	<legend>
		<?php
		echo JText::sprintf( 'JL_ADMIN_P_REF_EXT_TITLE',
		  JoomleagueHelper::formatName(null, $this->projectreferee->firstname, $this->projectreferee->nickname, $this->projectreferee->lastname, 0));
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
