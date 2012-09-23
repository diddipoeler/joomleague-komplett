<?php
/**
* @copyright	Copyright (C) 2007 Joomteam.de. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );
require_once ( JPATH_COMPONENT . DS . 'controllers' . DS . 'joomleague.php' );
/**
 * Joomleague Component Controller
 *
 * @package		Joomleague
 * @since 0.1
 */
class JoomleagueControllerDivision extends JoomleagueCommonController
{

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add', 'display' );
		$this->registerTask( 'edit', 'display' );
		$this->registerTask( 'apply', 'save' );
	}

	function display()
	{
		$option='com_joomleague';

		$mainframe	=& JFactory::getApplication();
		$document =& JFactory::getDocument();

		switch ( $this->getTask() )
		{
			case 'add'	 :
			{
				$model = $this->getModel ( 'division' );
				$viewType = $document->getType();
				$view = $this->getView( 'division', $viewType );
				$view->setModel( $model, true );	// true is for the default model;

				$projectws = $this->getModel ( 'project' );
				$projectws->_name = 'projectws';
				$projectws->setId( $mainframe->getUserState( $option . 'project', 0 ) );
				$view->setModel( $projectws );

				JRequest::setVar( 'hidemainmenu', 0 );
				JRequest::setVar( 'layout', 'form' );
				JRequest::setVar( 'view', 'division' );
				JRequest::setVar( 'edit', false );

				// Checkout the project
				$model->checkout();
			} break;

			case 'edit'	:
			{
				$model = $this->getModel ( 'division' );
				$viewType = $document->getType();
				$view = $this->getView( 'division', $viewType );
				$view->setModel( $model, true );	// true is for the default model;

				$projectws = $this->getModel ( 'project' );
				$projectws->_name = 'projectws';
				$projectws->setId( $mainframe->getUserState( $option . 'project', 0 ) );
				$view->setModel( $projectws );

				JRequest::setVar( 'hidemainmenu', 0 );
				JRequest::setVar( 'layout', 'form' );
				JRequest::setVar( 'view', 'division' );
				JRequest::setVar( 'edit', true );

				// Checkout the project
				$model->checkout();

			} break;

			default :
			{
				$model = $this->getModel ( 'divisions' );
				$viewType = $document->getType();
				$view = $this->getView( 'divisions', $viewType );
				$view->setModel( $model, true );	// true is for the default model;

				$projectws = $this->getModel ( 'project' );
				$projectws->_name = 'projectws';

				$projectws->setId( $mainframe->getUserState( $option . 'project', 0 ) );
				$view->setModel( $projectws );
			}
			break;

		}
		parent::display();
	}

	// save division in cid and save/update also the events associated with the saved division
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or die( 'JL_GLOBAL_INVALID_TOKEN' );

		$post	= JRequest::get( 'post' );
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];

		$model = $this->getModel( 'division' );

		if ( $model->store( $post ) )
		{
			$msg = JText::_( 'JL_ADMIN_DIVISION_CTRL_SAVED' );

		}
		else
		{
			$msg = JText::_( 'JL_ADMIN_DIVISION_CTRL_ERROR_SAVE' ) . $model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();

		if ( $this->getTask() == 'save' )
		{
			$link = 'index.php?option=com_joomleague&controller=division&view=divisions';
		}
		else
		{
			$link = 'index.php?option=com_joomleague&controller=division&task=edit&cid[]=' . $post['id'];
		}

		$this->setRedirect( $link, $msg );
	}

	// remove the divisions in cid
	function remove()
	{
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );

		if ( count( $cid ) < 1 )
		{
			JError::raiseError( 500, JText::_( 'JL_GLOBAL_SELECT_TO_DELETE' ) );
		}

		$model = $this->getModel( 'division' );

		if ( !$model->delete( $cid ) )
		{
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_joomleague&controller=division&view=divisions' );
	}

	function cancel()
	{
		// Checkin the project
		$model = $this->getModel( 'division' );
		$model->checkin();

		$this->setRedirect( 'index.php?option=com_joomleague&controller=division&view=divisions' );
	}

	function orderup()
	{
		$model = $this->getModel( 'division' );
		$model->move(-1);

		$this->setRedirect( 'index.php?option=com_joomleague&controller=division&view=divisions' );
	}

	function orderdown()
	{
		$model = $this->getModel( 'division' );
		$model->move(1);

		$this->setRedirect( 'index.php?option=com_joomleague&controller=division&view=divisions' );
	}

	function saveorder()
	{
		$cid	 = JRequest::getVar( 'cid', array(), 'post', 'array' );
		$order	 = JRequest::getVar( 'order', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );
		JArrayHelper::toInteger( $order );

		$model = $this->getModel( 'division' );
		$model->saveorder( $cid, $order );

		$msg = JText::_( 'JL_GLOBAL_NEW_ORDERING_SAVED' );
		$this->setRedirect( 'index.php?option=com_joomleague&controller=division&view=divisions', $msg );
	}
}
?>