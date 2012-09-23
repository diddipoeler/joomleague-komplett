<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

	<?php
	// Show team-description if defined.
	if ( !isset ( $this->projectteam->notes ) )
	{
		$description  = "";
	}
	else
	{
		$description  = $this->projectteam->notes;
	}

	if( trim( $description  != "" ) )
	{
		?>
		<br />
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr class="sectiontableheader">
				<td>
					<?php
					echo '&nbsp;' . JText::_( 'JL_ROSTER_TEAMINFORMATION' );
					?>
				</td>
			</tr>
		</table>

		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td>
					<?php
					$description = JHTML::_('content.prepare', $description);
					echo stripslashes( $description );
					?>
				</td>
			</tr>
		</table>
		<?php
	}
	?>
	<br />