<?php defined('_JEXEC') or die('Restricted access');
?>
		<?php
		foreach ($this->extended->getGroups() as $key => $groups)
		{
			$gname=(strtolower($key) == '_default') ? JText::_('General') : $key;
			?>
			<fieldset class="adminform">
				<legend>
					<?php
					$text = (!$this->edit) ? JText::sprintf('JL_ADMIN_PERSON_EXTENDED_DATA_S',JText::_($gname)) : JText::sprintf('JL_ADMIN_PERSON_EXTENDED_DATA_S_S',
					  JoomleagueHelper::formatName(null, $this->person->firstname, $this->person->nickname, $this->person->lastname, 0), $gname);
					echo $text;
					?>
				</legend>
				<?php
				// render is defined in joomla\libraries\joomla\html\parameter.php
				echo $this->extended->render('extended',$key);
				?>
			</fieldset>
			<?php
		}
		?>