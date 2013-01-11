<?php defined('_JEXEC') or die('Restricted access'); // Check to ensure this file is included in Joomla!
/**
 * @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
require_once (JPATH_COMPONENT.DS.'controllers'.DS.'joomleague.php');

/**
 * Joomleague Component Person Controller
 *
 * @package	JoomLeague
 * @since	1.50a
 */
class JoomleagueControllerPerson extends JoomleagueCommonController
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
			case 'add' :
				{
					JRequest::setVar('hidemainmenu',0);
					JRequest::setVar('layout','form');
					JRequest::setVar('view','person');
					JRequest::setVar('edit',false);

					// Checkout the project
					$model=$this->getModel('person');
					$model->checkout();
				} break;

			case 'edit' :
				{
					JRequest::setVar('hidemainmenu',0);
					JRequest::setVar('layout','form');
					JRequest::setVar('view','person');
					JRequest::setVar('edit',true);

					// Checkout the project
					$model=$this->getModel('person');
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

		$model=$this->getModel('person');

		$post['birthday']=JoomleagueHelper::convertDate($post['birthday'],0);
		$post['deathday']=JoomleagueHelper::convertDate($post['deathday'],0);

		if ($model->store($post))
		{
			$msg=JText::_('JL_ADMIN_PERSON_CTRL_SAVED');

			if (JRequest::getVar('assignperson'))
			{
				$cid                = JRequest::getVar('cid',array(),'post','array');
				$cid[0]             = $model->_db->insertid();
				$project_team_id    = JRequest::getVar('team_id',0,'post','int');

				$model=$this->getModel('teamplayers');
				if ($model->storeassigned($cid,$project_team_id))
				{
					$msg .= ' - '.JText::_('JL_ADMIN_PERSON_CTRL_PERSON_ASSIGNED');
				}
				else
				{
					$msg .= ' - '.JText::_('JL_ADMIN_PERSON_CTRL_ERROR_PERSON_ASSIGNED').$model->getError();
				}
				$model=$this->getModel('person');
			}
			
			$userfields = $model->getUserfields();
			if ( $userfields )
			{
      $model->storeUserfields();
      }
      
		}
		else
		{
			$msg=JText::_('JL_ADMIN_PERSON_CTRL_ERROR_SAVE').$model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		if ($this->getTask() == 'save')
		{
			$link='index.php?option=com_joomleague&view=persons';
		}
		else
		{
			$link='index.php?option=com_joomleague&controller=person&task=edit&cid[]='.$post['id'];
		}
		#echo $msg;
		$this->setRedirect($link,$msg);
	}

	// save the checked rows inside the persons list
	function saveshort()
	{
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		$model=$this->getModel('person');
		if ($model->storeshort($cid,$post))
		{
			$msg=JText::_('JL_ADMIN_PERSON_CTRL_PERSON_UPDATE');
		}
		else
		{
			$msg=JText::_('JL_ADMIN_PERSON_CTRL_ERROR_PERSON_UPDATE').$model->getError();
		}
		#echo $msg;
		$link='index.php?option=com_joomleague&view=persons';
		$this->setRedirect($link,$msg);
	}

	function remove()
	{
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_DELETE'));}
		$model=$this->getModel('person');
		if(!$model->delete($cid))
		{
			$this->setRedirect('index.php?option=com_joomleague&view=persons',$model->getError(),'error');
			return;
		}
		$this->setRedirect('index.php?option=com_joomleague&view=persons');
	}

	function publish()
	{
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_PUBLISH'));}
		$model=$this->getModel('person');
		if(!$model->publish($cid,1))
		{
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}
		$this->setRedirect('index.php?option=com_joomleague&controller=person&view=persons');
	}

	function unpublish()
	{
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_UNPUBLISH'));}
		$model=$this->getModel('person');
		if (!$model->publish($cid,0))
		{
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}
		$this->setRedirect('index.php?option=com_joomleague&controller=person&view=persons');
	}

	function cancel()
	{
		// Checkin the project
		$model=$this->getModel('person');
		$model->checkin();
		$this->setRedirect('index.php?option=com_joomleague&view=persons');
	}

	function orderup()
	{
		$model=$this->getModel('person');
		$model->move(-1);
		$this->setRedirect('index.php?option=com_joomleague&view=persons');
	}

	function orderdown()
	{
		$model=$this->getModel('person');
		$model->move(1);
		$this->setRedirect('index.php?option=com_joomleague&view=persons');
	}

	function saveorder()
	{
		$cid=JRequest::getVar('cid',array(),'post','array');
		$order=JRequest::getVar('order',array(),'post','array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);
		$model=$this->getModel('person');
		$model->saveorder($cid,$order);
		$msg=JText::_('JL_GLOBAL_NEW_ORDERING_SAVED');
		$this->setRedirect('index.php?option=com_joomleague&view=persons',$msg);
	}

	//FIXME can it be removed?
	function assign()
	{
		$option='com_joomleague';
		$mainframe	=& JFactory::getApplication();
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','assignconfirm');
		JRequest::setVar('view','persons');
		JRequest::setVar('project_id',$mainframe->getUserState($option.'project',0));
		JRequest::setVar('cid',$cid);
		// Checkout the project
		$model=$this->getModel('teamplayers');
		parent::display();
	}

	function saveassigned()
	{
		$post				= JRequest::get('post');
		$project_team_id	= JRequest::getVar('project_team_id',0,'post','int');
		$cid 				= JRequest::getVar('cid',array(),'post','array');
		$type				= JRequest::getVar('type',0,'post','int');
		$project_id			= JRequest::getVar('project_id',0,'post','int');
		JArrayHelper::toInteger($cid);
		if ($type == 0)
		{ //players
			$model=$this->getModel('teamplayers');

			if ($model->storeassigned($cid,$project_team_id))
			{
				$msg=JText::_('JL_ADMIN_PERSON_CTRL_PERSON_ASSIGNED_AS_PLAYER');
			}
			else
			{
				$msg=JText::_('JL_ADMIN_PERSON_CTRL_ERROR_PERSON_ASSIGNED_AS_PLAYER').$model->getError();
			}
			$link='index.php?option=com_joomleague&view=teamplayers&controller=teamplayer';
		}
		elseif ($type == 1)
		{ //staff
			$model=$this->getModel('teamstaffs');

			if ($model->storeassigned($cid,$project_team_id))
			{
				$msg=JText::_('JL_ADMIN_PERSON_CTRL_PERSON_ASSIGNED_AS_STAFF');
			}
			else
			{
				$msg=JText::_('JL_ADMIN_PERSON_CTRL_ERROR_PERSON_ASSIGNED_AS_STAFF').$model->getError();
			}
			$link='index.php?option=com_joomleague&view=teamstaffs&controller=teamstaff';
		}
		elseif ($type == 2)
		{ //referee
			$model=$this->getModel('projectreferees');

			if ($model->storeassigned($cid,$project_id))
			{
				$msg=JText::_('JL_ADMIN_PERSON_CTRL_PERSON_ASSIGNED_AS_REFEREE');
			}
			else
			{
				$msg=JText::_('JL_ADMIN_PERSON_CTRL_ERROR_PERSON_ASSIGNED_AS_REFEREE').$model->getError();
			}
			$link='index.php?option=com_joomleague&view=projectreferees&controller=projectreferee';
		}
		#echo $msg;
		$this->setRedirect($link,$msg);
	}

	// view,layout are settend in link request,to be changed?
	function personassign()
	{
		JRequest::setVar('hidemainmenu',1);
		JRequest::setVar('layout','assignperson');
		parent::display();
	}

	function select()
	{
		$option='com_joomleague';
		$mainframe	=& JFactory::getApplication();
		JRequest::setVar('team_id',JRequest::getVar('team'));
		JRequest::setVar('task','teamplayers');
		$mainframe->setUserState($option.'team_id',JRequest::getVar('team_id'));
		$mainframe->setUserState($option.'task',JRequest::getVar('task'));
		$this->setRedirect('index.php?option=com_joomleague&controller=person&view=persons&layout=teamplayers');
	}

	function import()
	{
		JRequest::setVar('view',	'import');
		JRequest::setVar('table',	'person');
		parent::display();
	}

	function export()
	{
		JRequest::checkToken() or die('JL_GLOBAL_INVALID_TOKEN');
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_EXPORT'));}
		$model = $this->getModel("person");
		$model->export($cid, "person", "Person");
	}
}
?>