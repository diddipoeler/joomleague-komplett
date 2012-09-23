<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the Joomleague component
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewTreetonodes extends JLGView
{

	function display($tpl=null)
	{
		$mainframe =& JFactory::getApplication();
		if ($this->getLayout()=='default')
		{
			$this->_displayDefault($tpl);
			return;
		}
		parent::display($tpl);
	}

	function _displayDefault($tpl)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();

		$node =& $this->get('Data');
		$total =& $this->get('Total');
		$pagination =& $this->get('Pagination');

		$model =& $this->getModel();
		$projectws =& $this->get('Data','projectws');
		$treetows =& $this->get('Data','treetows');

		$roundcode =& $model->getMaxRound($mainframe->getUserState( $option . 'project' ));
		//build the html options for teams
		$team_id[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_SELECT_TEAM'));
		if ($projectteams =& $model->getProjectTeamsOptions())
		{
			$team_id=array_merge($team_id,$projectteams);
		}
		$lists['team']=$team_id;
		unset($team_id);

		if($roundcode)
		{
		//build the html selectlist for rounds
		$model =& $this->getModel('projectws');
		$ress =& JoomleagueHelper::getRoundsOptions($model->_id);

			foreach ($ress as $res)
			{
				$datum=JHTML::_('date',$res->round_date_first,'%d.%m.%Y').' - '.JHTML::_('date',$res->round_date_last,'%d.%m.%Y');
				$project_roundslist[]=JHTML::_('select.option',$res->id,sprintf("%s (%s)",$res->name,$datum));
			}
			$lists['project_rounds2']=JHTML::_('select.genericList',$project_roundslist,'rid','class="inputbox" ','value','text',$projectws->current_round);
		}
		else
		//There are no rounds in project
		{
			$lists['project_rounds2']=JText::_('JL_ADMIN_TREETONODES_ADD_TO_NOROUND');
		}

		$style  = 'style="background-color: #dddddd; ';
		$style .= 'border: 0px solid white;';
		$style .= 'font-weight: normal; ';
		$style .= 'font-size: 8pt; ';
		$style .= 'width: 150px; ';
		$style .= 'font-family: verdana; ';
		$style .= 'text-align: center;"';
		$path = 'media/com_joomleague/treebracket/onwhite/';
		
		// build the html radio for adding into new round / exist round
		$createYesNo=array(0 => JText::_('JL_GLOBAL_NO'),1 => JText::_('JL_GLOBAL_YES'));
		$createLeftRight=array(0 => JText::_('L'),1 => JText::_('R'));
		$ynOptions=array();
		$lrOptions=array();
		foreach($createYesNo AS $key => $value){$ynOptions[]=JHTMLSelect::option($key,$value);}
		foreach($createLeftRight AS $key => $value){$lrOptions[]=JHTMLSelect::option($key,$value);}
		$lists['addToRound']=JHTMLSelect::radiolist($ynOptions,'addToRound','class="inputbox"','value','text',1);

		// build the html radio for auto publish new matches
		$lists['autoPublish']=JHTMLSelect::radiolist($ynOptions,'autoPublish','class="inputbox"','value','text',0);

		// build the html radio for Left or Right redepth
		$lists['LRreDepth']=JHTMLSelect::radiolist($lrOptions,'LRreDepth','class="inputbox"','value','text',0);
		// build the html radio for create new treeto
		$lists['createNewTreeto']=JHTMLSelect::radiolist($ynOptions,'createNewTreeto','class="inputbox"','value','text',1);

		$this->assignRef('lists',$lists);
		$this->assignRef('node',$node);
		$this->assignRef('roundcode',$roundcode);
		$this->assignRef('style',$style);
		$this->assignRef('path',$path);
		$this->assignRef('projectws',$projectws);
		$this->assignRef('treetows',$treetows);
		$this->assignRef('total',$total);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('request_url',$uri->toString());

		parent::display($tpl);
	}

}
?>