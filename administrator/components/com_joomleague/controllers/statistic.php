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
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
require_once(JPATH_COMPONENT.DS.'controllers'.DS.'joomleague.php');

/**
 * Joomleague Component Event Controller
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueControllerStatistic extends JoomleagueCommonController
{

	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('add','display');
		$this->registerTask('edit','display');
		$this->registerTask('apply','save');
		$this->registerTask('fulldelete','remove');
	}

	function display()
	{
		$option='com_joomleague';
		$mainframe 		=& JFactory::getApplication();
		$sports_type	= JRequest::getInt('filter_sports_type',0);
		$mainframe->setUserState($option.'.statistics.filter_sports_type',$sports_type);
		switch($this->getTask())
		{
			case 'add'	 :
			{
				JRequest::setVar('hidemainmenu', 0);
				JRequest::setVar('layout', 'form' );
				JRequest::setVar('view'  , 'statistic');
				JRequest::setVar('edit', false);

				// Checkout the object
				$model = $this->getModel('statistic');
				$model->checkout();
			} break;

			case 'edit'	:
			{
				JRequest::setVar('hidemainmenu', 0);
				JRequest::setVar('layout', 'form' );
				JRequest::setVar('view'  , 'statistic');
				JRequest::setVar('edit', true);

				// Checkout the club
				$model = $this->getModel('statistic');
				$model->checkout();
			} break;

		}

		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or die('JL_GLOBAL_INVALID_TOKEN');
		$post	= JRequest::get('post');
		$cid	= JRequest::getVar('cid', array(0), 'post', 'array');
		$post['id'] = (int) $cid[0];

		$model = $this->getModel('statistic');

		if ($return_id = $model->store($post))
		{
			$msg = JText::_('JL_ADMIN_STAT_CTRL_STAT_SAVED');
		}
		else
		{
			$msg = JText::_('JL_ADMIN_STAT_CTRL_ERROR_SAVE') . $model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();

		if ($this->getTask() == 'save')
		{
			$link = 'index.php?option=com_joomleague&view=statistics';
		}
		else
		{
			$link = 'index.php?option=com_joomleague&controller=statistic&task=edit&cid[]=' . $return_id;
		}

		$this->setRedirect($link, $msg);
	}

	function remove()
	{

		$cid = JRequest::getVar('cid', array(), 'post', 'array');
		JArrayHelper::toInteger($cid);

		if (count($cid) < 1) {
			JError::raiseError(500, JText::_('JL_GLOBAL_SELECT_TO_DELETE'));
		}

		$model = $this->getModel('statistic');

		if ($this->getTask() == 'fulldelete')
		{
			if(!$model->fulldelete($cid)) {
				$this->setRedirect('index.php?option=com_joomleague&view=statistics', $model->getError(), 'error');
				return;
			}
		}
		else if(!$model->delete($cid)) {
			$this->setRedirect('index.php?option=com_joomleague&view=statistics', $model->getError(), 'error');
			return;
		}

		$this->setRedirect('index.php?option=com_joomleague&view=statistics');
	}

	function cancel()
	{
		// Checkin the event
		$model = $this->getModel('statistic');
		$model->checkin();

		$this->setRedirect('index.php?option=com_joomleague&view=statistics');
	}

	function orderup()
	{
		$model = $this->getModel('statistic');
		$model->move(-1);

		$this->setRedirect('index.php?option=com_joomleague&view=statistics');
	}

	function orderdown()
	{
		$model = $this->getModel('statistic');
		$model->move(1);

		$this->setRedirect('index.php?option=com_joomleague&view=statistics');
	}

	function saveorder()
	{
		$cid = JRequest::getVar('cid', array(), 'post', 'array');
		$order = JRequest::getVar('order', array(), 'post', 'array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);

		$model = $this->getModel('statistic');
		$model->saveorder($cid, $order);

		$msg = JText::_('JL_GLOBAL_NEW_ORDERING_SAVED');
		$this->setRedirect('index.php?option=com_joomleague&view=statistics', $msg);
	}

	function publish()
	{
		$cid = JRequest::getVar('cid', array(), 'post', 'array');
		JArrayHelper::toInteger($cid);

		if (count($cid) < 1)
		{
			JError::raiseError(500, JText::_('JL_GLOBAL_SELECT_TO_PUBLISH'));
		}

		$model = $this->getModel('statistic');
		if(!$model->publish($cid, 1))
		{
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=com_joomleague&view=statistics');
	}

	function unpublish()
	{
		$cid = JRequest::getVar('cid', array(), 'post', 'array');
		JArrayHelper::toInteger($cid);

		if (count($cid) < 1)
		{
			JError::raiseError(500, JText::_('JL_GLOBAL_SELECT_TO_UNPUBLISH'));
		}

		$model = $this->getModel('statistic');
		if (!$model->publish($cid, 0))
		{
			echo "<script> alert('" . $model->getError(true)  ."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect('index.php?option=com_joomleague&view=statistics');
	}

	function import()
	{
		JRequest::setVar('view','import');
		JRequest::setVar('table','statistic');
		parent::display();
	}
	
	function export()
	{
		JRequest::checkToken() or die('JL_GLOBAL_INVALID_TOKEN');
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_EXPORT'));}
		$model = $this->getModel("statistic");
		$model->export($cid, "statistic", "Statistic");
	}
}
?>