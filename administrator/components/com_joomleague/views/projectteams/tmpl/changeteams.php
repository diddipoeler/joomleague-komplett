<?php defined('_JEXEC') or die('Restricted access');

?>
<form method="post" name="adminForm">
	<fieldset class="adminform">
		<legend>
		<?php
		echo JText::_( 'JL_ADMIN_PROJECTTEAMS_CHANGEASSIGN_TEAMS' );
		?>
		</legend>
		<table class="adminlist">
			<thead>
				<tr>
					<th class="title" width="5" style="vertical-align: top;"><?PHP echo JText::_( '' ); ?>
					</th>
					<th class="title" width="150" style="vertical-align: top;"><?PHP echo JText::_( 'JL_ADMIN_PROJECTTEAMS_CHANGE' ); ?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top;"><?PHP echo JText::_( 'JL_ADMIN_PROJECTTEAMS_SELECT_OLD_TEAM' ); ?>
					</th>
					<th class="title" nowrap="nowrap" style="vertical-align: top;"><?PHP echo JText::_( 'JL_ADMIN_PROJECTTEAMS_SELECT_NEW_TEAM' ); ?>
					</th>
				</tr>
			</thead>

			<?PHP

			//$lfdnummer = 1;
			$k = 0;
			$i = 0;

			foreach ( $this->projectteam as $row )
			{
				$checked = JHTML::_( 'grid.id', 'oldteamid'.$i, $row->id, $row->checked_out, 'oldteamid' );
				$append=' style="background-color:#bbffff"';
				$inputappend	= '';
				$selectedvalue = 0;
				?>
			<tr class="<?php echo "row$k"; ?>">
				<td style="text-align: center;"><?php
				echo $i;
				?>
				</td>
				<td style="text-align: center;"><?php
				echo $checked;
				?>
				</td>
				<td style="text-align: center;"><?php
				echo $row->name;
				?>
				</td>
				<td nowrap="nowrap" style="text-align: center;"><?php
				echo JHTML::_( 'select.genericlist', $this->lists['all_teams'], 'newteamid[' . $row->id . ']', $inputappend . 'class="inputbox" size="1" onchange="document.getElementById(\'cboldteamid' . $i . '\').checked=true"' . $append, 'value', 'text', $selectedvalue );
				?>
				</td>
			</tr>
			<?php
			$i++;
			$k=(1-$k);
			}
			?>
		</table>
	</fieldset>

	<input type="hidden" name="controller" value="projectteam" /> <input
		type="hidden" name="task" value="" />
		<?php echo JHTML::_('form.token')."\n"; ?>
</form>
