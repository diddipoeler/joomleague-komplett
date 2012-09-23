<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
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
 * @static
 * @package	JoomLeague
 * @since	1.5
 */
class JoomleagueViewSettings extends JLGView
{
	function display($tpl=null)
	{
		//create the toolbar
		JToolBarHelper::title(JText::_('JL_SETTINGS_TITLE'),'config');
		JToolBarHelper::apply();
		JToolBarHelper::spacer();
		JToolBarHelper::save();
		JToolBarHelper::spacer();
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();

		//Get global parameters
		$table =& JTable::getInstance('component');
		$table->loadByOption('com_joomleague');
		$globalparams=new JParameter($table->params,JPATH_ADMINISTRATOR.DS.'components'.DS.'com_joomleague'.DS.'config.xml');

		$this->assignRef('globalparams',$globalparams);

		parent::display($tpl);
	}

}
?>