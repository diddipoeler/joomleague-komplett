<?php defined('_JEXEC') or die('Restricted access');
?>		

			<?php
			foreach ($this->extended->getGroups() as $key => $groups)
			{
				$gname = (strtolower($key) == '_default') ? JText::_('General') : $key;
				?>
				<fieldset class="adminform">
					<legend>
						<?php
						echo JText::sprintf(	'JL_ADMIN_P_TEAM_TITLE_EXT',
												'<i>' . $this->project_team->name . '</i>',
												'<i>' . $this->projectws->name . '</i>');
						?>
					</legend>
					<?php
					// render is defined in joomla\libraries\joomla\html\parameter.php
					echo $this->extended->render('extended', $key);
					?>
				</fieldset>
				<?php
			}
			?>