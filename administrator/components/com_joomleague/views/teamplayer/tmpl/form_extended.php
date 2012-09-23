<?php defined('_JEXEC') or die('Restricted access');
?>		
		<?php
		foreach ( $this->extended->getGroups() as $key => $groups )
		{
			?>
			<fieldset class="adminform">
				<legend>
					<?php
					echo JText::sprintf('JL_ADMIN_TEAMPLAYER_EXT', 
					  JoomleagueHelper::formatName(null, $this->project_player->firstname, $this->project_player->nickname, $this->project_player->lastname, 0));
					?>
				</legend>
				<?php
				// render is defined in joomla\libraries\joomla\html\parameter.php
				echo $this->extended->render( 'extended', $key );
				?>
			</fieldset>
			<?php
		}
		?>