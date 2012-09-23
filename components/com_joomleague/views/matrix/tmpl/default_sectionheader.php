<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>

<!-- START: sectionheader -->
	<table width="100%" class="contentpaneopen" border="0">
		<tr>
			<td class="contentheading">
				<?php
				echo '&nbsp;' . JText::_( 'JL_MATRIX' );
				if ( $this->divisionid )
				{
					echo " " . $this->division->name;
				}
				if ( $this->roundid )
				{
					echo " - " . $this->round->name;
				}
				?>
			</td>
		</tr>
	</table>
<br />
<!-- END: sectionheader -->