<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );
?>		
		<fieldset class="adminform">
			<legend>
				<?php
				echo JText::_( 'JL_ADMIN_MATCH_F_MD' );
				?>
			</legend>

			<table class='admintable'>
				<!-- Match_state added 230709 Timoline -->
				<tr>
					<td align="right" class="key">
						<label for="cancel">
							<?php
							echo JText::_( 'JL_ADMIN_MATCH_F_MD_CANCEL' );
							?>
						</label>
					</td>
					<td>
						<?php
						echo $this->lists['cancel'];
						?>
					</td>
				</tr>				
				<tr>
					<td align="right" class="key">
						<label for="cancel_reason">
							<?php
							echo JText::_( 'JL_ADMIN_MATCH_F_MD_REASON_CANCEL' );
							?>
						</label>
					</td>
					<td colspan='3'>
						<input	type="text" name="cancel_reason" value="<?php echo $this->match->cancel_reason; ?>" size="40"
								class="inputbox" />
					</td>
				</tr>

				<!-- Playground -->
				<tr>
					<td align="right" class="key">
						<label >
							<?php
							echo JText::_( 'JL_ADMIN_MATCH_F_MD_VENUE' );
							?>
						</label>
					</td>
					<td>
						<?php
						echo $this->lists['playgrounds'];
						?>
					</td>
				</tr>
				<!-- Playground END-->

			</table>
		</fieldset>

		<div style="text-align:right; ">
			<input type="submit" value="<?php echo JText::_( 'JL_GLOBAL_SAVE' ); ?>">
		</div>
	