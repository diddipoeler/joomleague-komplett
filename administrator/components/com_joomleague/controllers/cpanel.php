<?php
/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
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
require_once (JPATH_COMPONENT.DS.'controllers'.DS.'joomleague.php');
/**
 * Joomleague Component Controller
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueControllerCpanel extends JoomleagueCommonController
{

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('add','display');
		$this->registerTask('edit','display');
		$this->registerTask('apply','save');
	}

	function display()
	{

		switch($this->getTask())
		{
			case 'add'	:
			{
				JRequest::setVar('hidemainmenu',1);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','project');
				JRequest::setVar('edit',false);

				// Checkout the project
				$model=$this->getModel('project');
				$model->checkout();
			} break;

			case 'edit'	:
			{
				JRequest::setVar('hidemainmenu',1);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','project');
				JRequest::setVar('edit',true);

				// Checkout the project
				$model=$this->getModel('project');
				$model->checkout();
			} break;

		}
		parent::display();
	}

	function workspace()
	{
		//JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','panel');
		JRequest::setVar('view','adminmenu');
		JRequest::setVar('edit',true);

		// Checkout the project
		$model=$this->getModel('project');
		$model->checkout();

		parent::display();
	}

}
?>
