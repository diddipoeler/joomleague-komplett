<?php defined('_JEXEC') or die('Restricted access');
?>		

		<?php
		foreach ( $this->extended->getGroups() as $key => $groups )
		{
			?>
			<fieldset class="adminform">
				<legend>
					<?php
					echo JText::sprintf('JL_ADMIN_TEAMSTAFF_EXT', 
					  JoomleagueHelper::formatName(null, $this->project_teamstaff->firstname, $this->project_teamstaff->nickname, $this->project_teamstaff->lastname, 0));
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