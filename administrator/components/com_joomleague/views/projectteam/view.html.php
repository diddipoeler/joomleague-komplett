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

require_once(JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewProjectteam extends JLGView
{
	function display($tpl = null)
	{
		if ($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}
		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		$option = 'com_joomleague';
		$mainframe	=& JFactory::getApplication();
		$project_id = $mainframe->getUserState( $option . 'project' );
		$uri 		=& JFactory::getURI();
		$user 		=& JFactory::getUser();
		$model		=& $this->getModel();
		$lists		= array();

		//get the project_team
		$project_team =& $this->get('data');
		$isNew = ($project_team->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg = JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_P_TEAM_THE_TEAM'),$project_team->name);
			$mainframe->redirect('index.php?option=com_joomleague',$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}
		else
		{
			// initialise new record
			$project_team->order = 0;
			// $project_team->parent_id = 0;
		}
		//build the html select list for playgrounds
		$playgrounds[] = JHTML::_('select.option','0',JText::_('JL_GLOBAL_SELECT_PLAYGROUND'));
		if ($res =& $model->getPlaygrounds())
		{
			$playgrounds = array_merge($playgrounds,$res);
		}
		$lists['playgrounds'] = JHTML::_(	'select.genericlist',$playgrounds,'standard_playground','class="inputbox" size="1"','value',
											'text', $project_team->standard_playground);
		unset($res);
		unset($playgrounds);

		//if there is no image selected, use default picture
		$default = JoomleagueHelper::getDefaultPlaceholder("team");
		if (empty($project_team->picture)){$project_team->picture=$default;}

		$imageselect=ImageSelect::getSelector('picture','picture_preview','teams',$project_team->picture,$default);

		//build the html select list for admin
		$lists['admin']=JHTML::_('list.users','admin',$project_team->admin);

		$projectws	=& $this->get('Data','projectws');
		#echo '<pre>'; print_r($projectws); echo '</pre>';

		// build the html select list for is in score
		$lists['is_in_score']=JHTML::_('select.booleanlist','is_in_score','class="inputbox"',$project_team->is_in_score);

		// build the html select list for is in score
		$lists['use_finally']=JHTML::_('select.booleanlist','use_finally','class="inputbox"',$project_team->use_finally);
		
		//build the html select list for days of week
		if ($trainingData=$model->getTrainigData($project_team->id))
		{
			$daysOfWeek=array(	0 => JText::_('JL_GLOBAL_SELECT'),
			1 => JText::_('JL_GLOBAL_MONDAY'),
			2 => JText::_('JL_GLOBAL_TUESDAY'),
			3 => JText::_('JL_GLOBAL_WEDNESDAY'),
			4 => JText::_('JL_GLOBAL_THURSDAY'),
			5 => JText::_('JL_GLOBAL_FRIDAY'),
			6 => JText::_('JL_GLOBAL_SATURDAY'),
			7 => JText::_('JL_GLOBAL_SUNDAY'));
			$dwOptions=array();
			foreach($daysOfWeek AS $key => $value){$dwOptions[]=JHTML::_('select.option',$key,$value);}
			foreach ($trainingData AS $td)
			{
				$lists['dayOfWeek'][$td->id]=JHTML::_('select.genericlist',$dwOptions,'dw_'.$td->id,'class="inputbox"','value','text',$td->dayofweek);
			}
			unset($daysOfWeek);
			unset($dwOptions);
		}

		if ($projectws->project_type == 'DIVISIONS_LEAGUE') // No divisions
		{
			//build the html options for divisions
			$division[]=JHTMLSelect::option('0',JText::_('JL_GLOBAL_SELECT_DIVISION'));
			$mdlDivisions = JModel::getInstance("divisions", "JoomLeagueModel");
			if ($res =& $mdlDivisions->getDivisions($project_id)){
				$division=array_merge($division,$res);
			}
			$lists['divisions']=$division;
				
			unset($res);
			unset($divisions);
		}

		/*
		 * extended data
		 */
		$paramsdata = $project_team->extended;
		$paramsdefs = JPATH_COMPONENT.DS.'assets'.DS.'extended'.DS.'projectteam.xml';
		$extended = new JLGExtraParams($paramsdata,$paramsdefs);
		
		$this->assignRef('extended',		$extended);
		$this->assignRef('imageselect',		$imageselect);
		$this->assignRef('projectws',		$projectws);
		$this->assignRef('lists',			$lists);
		$this->assignRef('project_team',	$project_team);
		$this->assignRef('trainingData',	$trainingData);

		parent::display($tpl);
	}

}
?>