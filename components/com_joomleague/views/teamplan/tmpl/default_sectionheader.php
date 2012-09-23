<?php defined('_JEXEC') or die('Restricted access');
?>
<table width="100%" class="contentpaneopen">
	<tr>
		<td class="contentheading">
			<?php
			$output='';
			if ((isset($this->division)) && (is_a($this->division,'LeagueDivision')))
			{
				$output .= ' '.$this->division->name.' ';
			}
			if (!empty($this->ptid))
			{
				$output .= ' '.$this->teams[$this->ptid]->name;
			}
			else
			{
				$output .= ' '.$this->project->name;
			}
			echo JText::sprintf('JL_TEAMPLAN_PAGE_TITLE',$output);
			?>
		</td>
		<?php
		if($this->config['show_ical_link'])
		{
			?>
			<td class="contentheading" style="text-align: right;">
				<?php
				if (!is_null($this->ptid))
				{
				$link=JoomleagueHelperRoute::getIcalRoute($this->project->id,$this->teams[$this->ptid]->team_id,null,null);
				$text=JHTML::_('image.site','calendar.png',DS.'administrator'.DS.'components'.DS.'com_joomleague'.DS.'assets'.DS.'images'.DS,NULL,NULL,JText::_('JL_TEAMPLAN_ICAL_EXPORT'));
				$attribs	= array('title' => JText::_('JL_TEAMPLAN_ICAL_EXPORT'));
				echo JHTML::_('link',$link,$text,$attribs);
				}
				?>
			</td>
			<?php
		}
		?>
	</tr>
</table><br />