<?php defined('_JEXEC') or die('Restricted access');
?>
		<fieldset class="adminform">
			<legend>
				<?php
				$text = (!$this->edit) ? JText::_('JL_ADMIN_PERSON_HEADER_ADD') : JText::sprintf('%1$s [<i>%2$s</i>]',JTEXT::_('JL_ADMIN_PERSON_HEADER_EDIT'), 
				  JoomleagueHelper::formatName(null, $this->person->firstname, $this->person->nickname, $this->person->lastname, 0));
				echo $text;
				?>
			</legend>
			<table class='admintable'>
				<tr>
					<td width='20%' class='key' style='text-align:right; vertical-align:top;' ><?php echo JText::_('JL_ADMIN_PERSON_SHOW_PICTURE'); ?></td>
					<td style='text-align:left; vertical-align:top;' ><?php echo $this->lists['show_pic']; ?></td>
				</tr>
				<tr>					
					<td width='20%' class='key' style='text-align:right; vertical-align:top;' ><?php echo JText::_('JL_ADMIN_PERSON_SHOW_P_DATA'); ?></td>
					<td style='text-align:left; vertical-align:top;' ><?php echo $this->lists['show_persdata']; ?></td>
				</tr>
				<tr>
					<td width='20%' class='key' style='text-align:right; vertical-align:top;' ><?php echo JText::_('JL_ADMIN_PERSON_SHOW_T_DATA'); ?></td>
					<td style='text-align:left; vertical-align:top;' ><?php echo $this->lists['show_teamdata']; ?></td>
				</tr>
				<tr>					
					<td width='20%' class='key' style='text-align:right; vertical-align:top;' ><?php echo JText::_('JL_ADMIN_PERSON_SHOW_FE'); ?></td>
					<td style='text-align:left; vertical-align:top;' ><?php echo $this->lists['show_on_frontend']; ?></td>
				</tr>
			</table>
		</fieldset>