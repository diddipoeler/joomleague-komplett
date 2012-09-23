<?php
/**
 * @copyright	Copyright (C) 2007 Joomteam.de. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
 * Joomleague Common Controller
 *
 * @author	Marco Vaninetti <martizva@tiscali.it>
 * @package	JoomLeague
 * @since	1.5.0a
 */

class JoomleagueCommonController extends JLGController
{

	function display()
	{
		// display the left menu only if hidemainmenu is not true
		$show_menu=!JRequest::getVar('hidemainmenu',false);

		// display left menu
		$viewName=JRequest::getCmd('view');
		if ($viewName != 'about' && $show_menu){$this->ShowMenu();}

		parent::display();

		// wrap the display
		if ($show_menu){
			$this->ShowMenuExtension();
			$this->ShowMenuFooter();
		}
	}

	function ShowMenu()
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$viewType=$document->getType();
		$view =& $this->getView('Adminmenu',$viewType);
		if ($model =& $this->getModel('project'))
		{
			// Push the model into the view (as default)
			$model->setId($mainframe->getUserState($option.'project',0));
			$view->setModel($model,true);
		}
		$view->display();
	}
	
	function ShowMenuExtension()
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$viewType=$document->getType();
		$view =& $this->getView('Adminmenu',$viewType);
		$view->setLayout('extension');
		$view->display();
	}

	function ShowMenuFooter()
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$viewType=$document->getType();
		$view =& $this->getView('Adminmenu',$viewType);
		$view->setLayout('footer');
		$view->display();
	}

	function selectws()
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();

		$stid	= JRequest::getVar('stid',	array(0),'','array');
		$pid	= JRequest::getVar('pid',	array(0),'','array');
		$tid	= JRequest::getVar('tid',	array(0),'','array');
		$rid	= JRequest::getVar('rid',	array(0),'','array');
		$sid	= JRequest::getVar('sid',	array(0),'','array');
		$stid	= JRequest::getVar('stid',	array(0),'','array');
		$pgid	= JRequest::getVar('pgid',	array(0),'','array');
		$pgmid	= JRequest::getVar('pmgid',	array(0),'','array'); // old way of getting prediction_id // TO BE FIXED: remove everywhere
		$act	= JRequest::getVar('act',0);
		
		$seasonnav = JRequest::getInt('seasonnav');
		$mainframe->setUserState($option.'seasonnav', $seasonnav);
		
		switch ($act)
		{
			case 'projects':
				if ($mainframe->setUserState($option.'project',(int)$pid[0]))
				{
					$mainframe->setUserState($option.'project_team_id','0');
					$this->setRedirect('index.php?option=com_joomleague&controller=cpanel&task=workspace&layout=panel&pid[]='.$pid[0],JText::_('JL_ADMIN_JL_CTRL_PROJECT_SELECTED'));
				}
				else
				{
					$this->setRedirect('index.php?option=com_joomleague&view=projects');
				}
				break;

			case 'teams':
				$mainframe->setUserState($option.'project_team_id',(int)$tid[0]);
				if ((int) $tid[0] != 0)
				{
					$this->setRedirect('index.php?option=com_joomleague&view=teamplayers&controller=teamplayer',JText::_('JL_ADMIN_JL_CTRL_TEAM_SELECTED'));
				}
				else
				{
					$this->setRedirect('index.php?option=com_joomleague&controller=cpanel&task=workspace&layout=panel&pid[]='.$pid[0]);
				}
				break;

			case 'rounds':
				if ((int) $rid[0] != 0)
				{
					$this->setRedirect('index.php?option=com_joomleague&controller=match&view=matches&rid[]='.$rid[0],JText::_('JL_ADMIN_JL_CTRL_ROUND_SELECTED'));
				}
				break;

			case 'seasons':
				$this->setRedirect('index.php?option=com_joomleague&view=projects', JText::_('JL_ADMIN_JL_CTRL_SEASON_SELECTED'));
				break;

			default:
				if ($mainframe->setUserState($option.'sportstypes',(int)$stid[0]))
				{
					$mainframe->setUserState($option.'project','0');
					$this->setRedirect('index.php?option=com_joomleague&view=projects&stid[]='.$stid[0],JText::_('JL_ADMIN_JL_CTRL_SPORTSTYPE_SELECTED'));
				}
				else
				{
					$this->setRedirect('index.php?option=com_joomleague&view=sportstypes');
				}
		}
	}
}