<?php
/**
 * @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');
require_once (JPATH_COMPONENT.DS.'controllers'.DS.'joomleague.php');

/**
 * Joomleague Component settings Controller
 *
 * @package		Joomleague
 * @since 1.5
 */
class JoomleagueControllerSettings extends JoomleagueCommonController
{

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'apply', 'save' );
	}

	function edit()
	{
		JRequest::setVar( 'hidemainmenu', 0 );
		JRequest::setVar( 'view'  , 'settings');
		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or die( 'JL_GLOBAL_INVALID_TOKEN' );

		// Sanitize
		$task	= JRequest::getVar('task');
		$post 	= JRequest::get( 'post' );
		
		$model=$this->getModel('settings');
		
		$defPh = JoomleagueHelper::getDefaultPlaceholder('player');
		$newPh = $post['ph_player'];
		error_log($newPh .'='. $defPh);
		if($newPh != $defPh) {
			if(!$model->updatePlaceholder(	'#__joomleague_person',
											'picture', 
											$defPh , 
											$newPh)) {
				$msg = $model->getError();
			}
			if(!$model->updatePlaceholder(	'#__joomleague_team_player',
											'picture', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
			if(!$model->updatePlaceholder(	'#__joomleague_team_staff',
											'picture', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
			if(!$model->updatePlaceholder(	'#__joomleague_project_referee',
											'picture', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
		} 
		$defPh = JoomleagueHelper::getDefaultPlaceholder('clublogobig');
		$newPh = $post['ph_logo_big'];
		if($newPh != $defPh) {
			if(!$model->updatePlaceholder(	'#__joomleague_club',
											'logo_big', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
			if(!$model->updatePlaceholder(	'#__joomleague_playground',
											'picture', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
		}
		$defPh = JoomleagueHelper::getDefaultPlaceholder('clublogomedium');
		$newPh = $post['ph_logo_medium'];
		if($newPh != $defPh) {
			if(!$model->updatePlaceholder(	'#__joomleague_club',
											'logo_middle', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
		}
		$defPh = JoomleagueHelper::getDefaultPlaceholder('clublogosmall');
		$newPh = $post['ph_logo_small'];
		if($newPh != $defPh) {
			if(!$model->updatePlaceholder(	'#__joomleague_club',
											'logo_small', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
		}
		$defPh = JoomleagueHelper::getDefaultPlaceholder('icon');
		$newPh = $post['ph_icon'];
		if($newPh != $defPh) {
			if(!$model->updatePlaceholder(	'#__joomleague_statistic',
											'icon', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
			if(!$model->updatePlaceholder(	'#__joomleague_sports_type',
											'icon', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
			if(!$model->updatePlaceholder(	'#__joomleague_eventtype',
											'icon', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
		}
		$defPh = JoomleagueHelper::getDefaultPlaceholder('team');
		$newPh = $post['ph_team'];
		if($newPh != $defPh) {
			if(!$model->updatePlaceholder(	'#__joomleague_team',
											'picture', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}			
			if(!$model->updatePlaceholder(	'#__joomleague_project_team',
											'picture', 
											$defPh ,
											$newPh)) {
				$msg = $model->getError();
			}
		}
		
		$table =& JTable::getInstance('component');

		$parampost['params'] = JRequest::getVar('globalparams');
		$parampost['option'] = 'com_joomleague';
		$table->loadByOption( 'com_joomleague' );
		$table->bind( $parampost );

		// save the changes
		if ($table->store()) {
			$msg	= JText::_( 'JL_ADMIN_SETTINGS_CTRL_STAT_SAVED');
		} else {
			$msg	= JText::_( 'JL_ADMIN_SETTINGS_CTRL_ERROR_SAVE');
		}

		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_joomleague&controller=settings&task=edit';
				break;

			case 'save':
				$link = 'index.php?option=com_joomleague&controller=settings&task=edit';
				break;

				default:
				$link = 'index.php?option=com_joomleague';
			break;
		}

		$this->setRedirect( $link, $msg );
	}

	function cancel()
	{
		$this->setRedirect( 'index.php?option=com_joomleague' );
	}
}

?>
