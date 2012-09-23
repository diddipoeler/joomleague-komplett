<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<div class="playerinfo">
	<table cellpadding="4" cellspacing="1" border="0">
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_INJURED' );
				?>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $this->lists['injury'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_INJURY_DATE' );
				?>
			</td>
			<td>
				<?php
				echo $this->lists['injury_date'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_INJURY_END' );
				?>
			</td>
			<td>
				<?php
				echo $this->lists['injury_end'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_INJURY_TYPE' );
				?>
			</td>
			<td>
				<input	class="inputbox" type="text" name="injury_detail" id="title" size="20" maxlength="250"
				value="<?php echo $this->teamPlayer->injury_detail; ?>" />
			</td>
		</tr>		
	</table>
</div>
<div class="playerinfo">
	<!-- suspend -->
	<table cellpadding="4" cellspacing="1" border="0">
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_SUSPENDED' );
				?>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $this->lists['suspension'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_SUSPENSION_DATE' );
				?>
			</td>
			<td>
				<?php
				echo $this->lists['suspension_date'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_SUSPENSION_END' );
				?>
			</td>
			<td>
				<?php
				echo $this->lists['suspension_end'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_SUSPENSION_TYPE' );
				?>
			</td>
			<td>
				<input	class="inputbox" type="text" name="suspension_detail" id="title" size="20" maxlength="250"
						value="<?php echo $this->teamPlayer->suspension_detail; ?>" />
			</td>
		</tr>	
	</table>
</div>
<div class="playerinfo">
	<!-- away -->
	<table cellpadding="4" cellspacing="1" border="0">
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_AWAY' );
				?>
			</td>
			<td nowrap="nowrap">
				<?php
				echo $this->lists['away'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_AWAY_DATE' );
				?>
			</td>
			<td>
				<?php
				echo $this->lists['away_date'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_AWAY_END' );
				?>
			</td>
			<td>
				<?php
				echo $this->lists['away_end'];
				?>
			</td>
		</tr>
		<tr>
			<td align="right">
				<?php
				echo JText::_( 'JL_EDIT_PERSON_AWAY_TYPE' );
				?>
			</td>
			<td>
				<input	class="inputbox" type="text" name="away_detail" id="title" size="20" maxlength="250"
						value="<?php echo $this->teamPlayer->away_detail; ?>" />
			</td>
		</tr>
	</table>
</div>
<div style="clear:left" />
</div>
<br/>