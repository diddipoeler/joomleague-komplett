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
jimport('joomla.filesystem.file');
require_once (JPATH_COMPONENT.DS.'controllers'.DS.'joomleague.php');
/**
 * Joomleague Component Playground Controller
 *
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueControllerPlayground extends JoomleagueCommonController
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
			case 'add'     :
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','playground');
				JRequest::setVar('edit',false);

				// Checkout the project
				$model=$this->getModel('playground');
				$model->checkout();
			} break;
			case 'edit'    :
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','playground');
				JRequest::setVar('edit',true);

				// Checkout the project
				$model=$this->getModel('playground');
				$model->checkout();
			} break;
		}
		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or die('JL_GLOBAL_INVALID_TOKEN');
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(0),'post','array');
		$post['id']=(int) $cid[0];
		// decription must be fetched without striping away html code
		$post['notes']=JRequest:: getVar('notes','none','post','STRING',JREQUEST_ALLOWHTML);
		$model=$this->getModel('playground');
		if ($model->store($post))
		{
			$msg=JText::_('JL_ADMIN_VENUE_CTRL_SAVED');
		}
		else
		{
			$msg=JText::_('JL_ADMIN_VENUE_CTRL_ERROR_SAVE').$model->getError();
		}
		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		if ($this->getTask()=='save')
		{
			$link='index.php?option=com_joomleague&view=playgrounds';
		}
		else
		{
			$link='index.php?option=com_joomleague&controller=playground&task=edit&cid[]='.$post['id'];
		}
		$this->setRedirect($link,$msg);
	}

	function remove()
	{
		JRequest::checkToken() or die('JL_GLOBAL_INVALID_TOKEN');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_DELETE'));}
		$model=$this->getModel('playground');
		if(!$model->delete($cid))
		{
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
			return;
		}
		else
		{
			$msg='JL_ADMIN_VENUE_CTRL_DELETED';
		}
		$this->setRedirect('index.php?option=com_joomleague&view=playgrounds');
	}

	function cancel()
	{
		// Checkin the project
		$model=$this->getModel('playground');
		$model->checkin();
		$this->setRedirect('index.php?option=com_joomleague&view=playgrounds');
	}

	function orderup()
	{
		$model=$this->getModel('playground');
		$model->move(-1);
		$this->setRedirect('index.php?option=com_joomleague&view=playgrounds');
	}

	function orderdown()
	{
		$model=$this->getModel('playground');
		$model->move(1);
		$this->setRedirect('index.php?option=com_joomleague&view=playgrounds');
	}

	function saveorder()
	{
		JRequest::checkToken() or die('JL_GLOBAL_INVALID_TOKEN');
		$cid=JRequest::getVar('cid',array(),'post','array');
		$order=JRequest::getVar('order',array(),'post','array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);
		$model=$this->getModel('project');
		$model->saveorder($cid,$order);
		$msg=JText::_('JL_GLOBAL_NEW_ORDERING_SAVED');
		$this->setRedirect('index.php?option=com_joomleague&view=playgrounds',$msg);
	}

	function import()
	{
		JRequest::setVar('view','import');
		JRequest::setVar('table','playground');
		parent::display();
	}

	function export()
	{
		JRequest::checkToken() or die('JL_GLOBAL_INVALID_TOKEN');
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_EXPORT'));}
		$model = $this->getModel("playground");
		$model->export($cid, "playground", "Playground");
	}
}
?>