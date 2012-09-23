<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
?>			
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::_( 'JL_ADMIN_MATCH_F_SD' );
				?>
			</legend>
			<br/>
			<table class='admintable'>
				<tr>
					<th>
						&nbsp;
					</th>
					<th align="right">
						<?php
						echo $this->match->hometeam;
						?>
					</th>
					<th>
						&nbsp;
					</th>
					<th>
						<?php
						echo $this->match->awayteam;
						?>
					</th>
				</tr>
				<!-- Header team names END -->
				<!-- match legs -->
				<?php
				if ( $this->projectws->use_legs == 1 )
				{
					?>
					<tr>
						<td align="right">
							<?php
							if ( $this->table_config['alternative_legs'] == '' )
							{
								echo JText::_( 'JL_ADMIN_MATCH_F_SD_SETS' );
							}
							else
							{
								echo $this->table_config['alternative_legs'];
							}
							?>:
						</td>
						<td align="right">
							<input	type="text" name="team1_legs" value="<?php echo $this->match->team1_legs; ?>" size="3"
									tabindex="100" class="inputbox" />
						</td>
						<td align="center">:</td>
						<td>
							<input	type="text" name="team2_legs" value="<?php echo $this->match->team2_legs; ?>" size="3"
									tabindex="101" class="inputbox" />
						</td>
					</tr>
					<?php
				}
				?>
				<!-- END match legs -->
				<!-- Bonus points -->
				<tr>
					<td align="right" class="key">
						<label>
							<?php
							echo JText::_( 'JL_ADMIN_MATCH_F_SD_BONUS' );
							?>
						</label>
					</td>
					<td align="right">
						<input	type="text" name="team1_bonus" value="<?php echo $this->match->team1_bonus;?>" size="3" class="inputbox" />
					</td>
					<td align="center">:</td>
					<td>
						<input	type="text" name="team2_bonus" value="<?php echo $this->match->team2_bonus;?>" size="3" class="inputbox" />
					</td>
				</tr>
				<!-- Bonus points END -->

			<!-- Score Table END -->
			<!-- Additional Details Table START -->
				<!-- Result notice -->
				<tr>
					<td align="right" class="key">
						<label for="match_result_detail">
							<?php
							echo JText::_( 'JL_ADMIN_MATCH_F_SD_SCORE_NOTICE' );
							?>
						</label>
					</td>
					<td colspan='3'>
						<input	type="text" name="match_result_detail" value="<?php echo $this->match->match_result_detail; ?>" size="40"
								class="inputbox" />
					</td>
				</tr>
				<!-- Result notice END -->

			</table>
		</fieldset>

		<div style="text-align:right; ">
			<input type="submit" value="<?php echo JText::_( 'JL_GLOBAL_SAVE' ); ?>">
		</div>