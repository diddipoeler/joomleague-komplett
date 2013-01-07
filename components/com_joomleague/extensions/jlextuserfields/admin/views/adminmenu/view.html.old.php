<?php
/**
 * @copyright   Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license	 GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pane');
jimport('joomla.filesystem.file');

/**
 * HTML View class for the Joomleague component
 *
 * @author	Marco Vaninetti <martizva@tiscali.it>
 * @package	JoomLeague
 * @since	1.5.0a
 */

// require_once(JPATH_COMPONENT.DS.'models'.DS.'sportstypes.php');
// require_once(JPATH_COMPONENT.DS.'models'.DS.'leagues.php');

class JoomleagueViewAdminmenu extends JLGView
{

	function display($tpl=null)
	{
	$option='com_joomleague';
	$mainframe =& JFactory::getApplication();
	JHTML::_('behavior.mootools');
	$db =& JFactory::getDBO();
	$document =& JFactory::getDocument();
  
  $model =& $this->getModel('jlextuserfields') ;
  //$res =& JoomleagueModeljlextuserfields::getJLTables();
    	
  parent::display('jlextuserfields');		
	}

	

}
?>