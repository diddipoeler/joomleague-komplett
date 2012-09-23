<?php defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Match Extended Data' ); ?></legend>
	<table class='adminForm' border='0'>
		<tr>
			<td>
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
<div style="text-align:right; ">
	<input type="submit" value="<?php echo JText::_( 'JL_GLOBAL_SAVE' ); ?>">
</div><br />