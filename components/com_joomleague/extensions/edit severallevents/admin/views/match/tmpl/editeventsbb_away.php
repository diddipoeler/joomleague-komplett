		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::_( $this->teams->team2 ); 
				?>
			</legend>
	<table>
		<thead>
			<tr>
				<th style="text-align:left; "></th>
				<th style="text-align:left; width: 100pt; "><?php echo JText::_( 'JL_ADMIN_MATCH_EEBB_PERSON' ); ?></th>
				<?php
				foreach ( $this->events as $ev)
				{
					?>
					<th style="text-align:center; ">
					<?php
					if ( JFile::exists(JPATH_SITE.DS.$ev->icon ) )
					{
						$imageTitle = JText::sprintf( '%1$s', JText::_( $ev->text ) );
						$iconFileName = $ev->icon;
						echo JHTML::_( 'image', $iconFileName, $imageTitle, 'title= "' . $imageTitle . '"' );
					} else {
						echo JText::_( $ev->text ) ;
					}
					?>
					</th>
					<?php
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php
			$teap = 0;
			$model = $this->getModel();
			for( $i=0 , $n = count( $this->awayRoster ); $i < $n; $i++ )
			{
					$row =& $this->awayRoster[$i];
					if($row->value == 0) continue;
					?>
					<tr id="row<?php echo $i;?>">
						<td style="text-align:left; ">
						<input type="hidden" name="player_id_a_<?php echo $i;?>" value="<?php echo $row->value;?>" />
						<input type="hidden" name="team_id_a_<?php echo $i;?>" value="<?php echo $row->projectteam_id;?>" />
						<input type="checkbox" id="cb_a<?php echo $i;?>" name="cid_a<?php echo $i;?>" value="cb_a" onclick="isChecked(this.checked);" />
						</td>
						<td style="text-align:left; ">
						<?php echo JoomleagueHelper::formatName(null, $row->firstname, $row->nickname, $row->lastname, 0) ?>
						</td>
						<?php
						//total events away player
						$teap = 0;
						foreach ( $this->events as $ev)
						{
							$teap++;	
							$this->assignRef( 'evbb', $model->getPlayerEventsbb( $row->value, $ev->value ) );
							?>
							<td style="text-align:center; ">
							<input type="hidden" name="event_type_id_a_<?php echo $i.'_'.$teap;?>" value="<?php echo $ev->value;?>" />
							<input type="hidden" name="event_id_a_<?php echo $i.'_'.$teap;?>" value="<?php echo $this->evbb[0]->id;?>" />
							<input type="text" size="3" class="inputbox" name="event_sum_a_<?php echo $i.'_'.$teap; ?>" value="<?php echo (($this->evbb[0]->event_sum > 0) ? $this->evbb[0]->event_sum : '' ); ?>" onchange="document.getElementById('cb_a<?php echo $i;?>').checked=true" />
						<?php 
						}
						?>
					</tr>
					<?php
			}
			?>
			<input type="hidden" name="total_a_players" value="<?php echo $i;?>" />
			<input type="hidden" name="teap" value="<?php echo $teap;?>" />
		</tbody>
	</table>		
		</fieldset>