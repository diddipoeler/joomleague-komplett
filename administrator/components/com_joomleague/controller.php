<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // Check to ensure this file is included in Joomla!

/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

jimport( 'joomla.application.component.controller' );
require_once ( JPATH_COMPONENT . DS . 'controllers' . DS . 'joomleague.php' );

/**
 * HTML View class for the Joomleague component
 *
 * @author Marco Vaninetti <martizva@tiscali.it>
 * @package   Joomleague
 * @since 0.1
 */

class JoomleagueController extends JoomleagueCommonController
{
	function display()
	{
		// display the left menu only if hidemainmenu is not true
		// $show_menu = !JRequest::getVar('hidemainmenu', false);

		// Set a default view if none exists
		if ( !JRequest::getCmd( 'view' ) )
		{
			JRequest::setVar( 'view', 'projects' );
		}

		// // display left menu
		// $viewName = JRequest::getCmd( 'view' );
		// if ( $viewName != 'about' && $show_menu )
		// {
		//	  $this->ShowMenu();
		// }

	parent::display();

	// wrap the display
	// if ( $show_menu )
	// {
	// $this->ShowMenuFooter();
	// }

	}

}
?>