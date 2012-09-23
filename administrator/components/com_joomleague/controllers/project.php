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
require_once(JPATH_COMPONENT.DS.'controllers'.DS.'joomleague.php');

/**
 * Joomleague Component Project Model
 *
 * @author 	Marco Vaninetti <martizva@tiscali.it>
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueControllerProject extends JoomleagueCommonController
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
		$option='com_joomleague';
		$mainframe 		=& JFactory::getApplication();
		$sports_type	= JRequest::getInt('filter_sports_type',0);
		$season			= JRequest::getInt('filter_season',0);
		$mainframe->setUserState($option.'.projects.filter_sports_type', $sports_type);
		$mainframe->setUserState($option.'.projects.filter_season', $season);
		
		$document =& JFactory::getDocument();
		$model=$this->getModel('project');
		$viewType=$document->getType();
		$view=$this->getView('project',$viewType);
		$view->setModel($model,true);	// true is for the default model;

		switch($this->getTask())
		{
			case 'add'	:
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','project');
				JRequest::setVar('edit',false);

				// Checkout the project
				$model=$this->getModel('project');
				$model->checkout();
			} break;

			case 'edit'	:
			{
				JRequest::setVar('hidemainmenu',0);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','project');
				JRequest::setVar('edit',true);

				// Checkout the project
				$model=$this->getModel('project');
				$model->checkout();
			} break;

			case 'copy'	:
			{
				$cid=JRequest::getVar('cid',array(0),'post','array');
				$copyID=(int) $cid[0];

				JRequest::setVar('hidemainmenu',1);
				JRequest::setVar('layout','form');
				JRequest::setVar('view','project');
				JRequest::setVar('edit',true);
				JRequest::setVar('copy',true);
			} break;
		}
		parent::display();
	}

	function copysave()
	{
		JRequest::checkToken() or die(JText::_('JL_GLOBAL_INVALID_TOKEN'));
		JToolBarHelper::title(JText::_('JL_PROJECT_COPY_TITLE'),'ProjectSettings');
		JToolBarHelper::back('JL_PROJECT_BACK','index.php?option=com_joomleague&view=projects');
		$post=JRequest::get('post');

		$newLeagueCheck=JRequest::getVar('newLeagueCheck',0,'post','int');
		$leagueNew=trim(JRequest::getVar('leagueNew',JText::_('JL_PROJECT_COPY_NEW_LEAGUE'),'post','string'));
		$newLeagueId=JRequest::getVar('oldleague',0,'post','int');
		$newSeasonCheck=JRequest::getVar('newSeasonCheck',0,'post','int');
		$seasonNew=trim(JRequest::getVar('seasonNew',JText::_('JL_PROJECT_COPY_NEW_SEASON'),'post','string'));
		$newSeasonId=JRequest::getVar('oldseason',0,'post','int');

//echo '<pre>'.print_r($post,true).'</pre>';

		if (($newLeagueCheck==1) && ($leagueNew!='')) // add new league if needed
		{
			echo JText::_('JL_PROJECT_COPY_ADDING_LEAGUE').'&nbsp;&nbsp;';
			$model=$this->getModel('league');
			$newLeagueId=$model->addLeague($leagueNew);
			echo $newLeagueId.'<br />';
		}
		JRequest::setVar('league_id',$newLeagueId,'post',true);

		if (($newSeasonCheck==1) && ($seasonNew!='')) // add new season if needed
		{
			echo JText::_('JL_PROJECT_COPY_ADDING_SEASON').'&nbsp;&nbsp;';
			$model=$this->getModel('season');
			$newSeasonId=$model->addSeason($seasonNew);
			echo $newSeasonId.'<br />';
		}
		JRequest::setVar('season_id',$newSeasonId,'post',true);

		$model=$this->getModel('projects');

		$cid=JRequest::getVar('cid',array(0),'post','array');
		$post['id']=(int)$cid[0];

		if (!$model->cpCheckPExists($post)) //check project unicity if season and league are not both new
		{
			$link='index.php?option=com_joomleague&controller=project&view=projects';
			$msg=JText::_('JL_PROJECT_COPY_PROJECT_EXISTS');
			$this->setRedirect($link,$msg);
		}

		if ((isset($post['fav_team'])) && (count($post['fav_team']) > 0))
		{
			$temp=implode(",",$post['fav_team']);
		}
		else
		{
			$temp='';
		}
		$post['fav_team']=$temp;

		echo JText::_('JL_PROJECT_COPY_SETTINGS').'<br />';
		$model=$this->getModel('project');
		if ($model->store($post)) //copy project data and get a new project_id
		{
			//	save the templates params
			if ($post['id']==0){$post['id']=$model->_db->insertid();}

			$templatesModel =& JLGModel::getInstance('Templates','JoomleagueModel');
			$templatesModel->setProjectId($post['id']);
			$templatesModel->checklist();

			// Check the table in so it can be edited.... we are done with it anyway
			$model->checkin();
			echo JText::_('JL_GLOBAL_SUCCESS').'<br />';

			echo '<br />'.JText::_('JL_PROJECT_COPY_DIVISIONS').'<br />';
			$source_to_copy_division=Array('0' => 0);
			$model=$this->getModel('division');
			if ($source_to_copy_division=$model->cpCopyDivisions($post)) //copy project divisions
			{
				echo '<br />'.JText::_('JL_GLOBAL_SUCCESS').'<br />';

				echo '<br />'.JText::_('JL_PROJECT_COPY_TEAMS').'<br />';
				$model=$this->getModel('projectteam');
				if ($model->cpCopyTeams($post,$source_to_copy_division)) //copy project teams
				{
					echo '<br />'.JText::_('JL_GLOBAL_SUCCESS').'<br />';
				}
				else
				{
					echo '<br />'.JText::_('JL_GLOBAL_ERROR').'<br />'.$model->getError().'<br />';
				}

				echo '<br />'.JText::_('JL_PROJECT_COPY_POSITIONS').'<br />';
				$model=$this->getModel('projectposition');
				if ($model->cpCopyPositions($post)) //copy project team-positions
				{
					echo '<br />'.JText::_('JL_GLOBAL_SUCCESS').'<br />';

					echo '<br />'.JText::_('JL_PROJECT_COPY_ROUNDS').'<br />';
					$model=$this->getModel('round');
					if ($model->cpCopyRounds($post)) //copy project team-positions
					{
						echo '<br />'.JText::_('JL_GLOBAL_SUCCESS').'<br />';
					}
					else
					{
						echo '<br />'.JText::_('JL_GLOBAL_ERROR').'<br />'.$model->getError().'<br />';
					}
				}
				else
				{
					echo '<br />'.JText::_('JL_GLOBAL_ERROR').'<br />'.$model->getError().'<br />';
				}
			}
			else
			{
				echo '<br />'.JText::_('JL_GLOBAL_ERROR').'<br />'.$model->getError().'<br />';
			}

			echo '<br />'.JText::_('JL_PROJECT_COPY_REFEREES').'<br />';
			$model=$this->getModel('projectreferee');
			if ($model->cpCopyProjectReferees($post))
			{
				echo '<br />'.JText::_('JL_GLOBAL_SUCCESS').'<br />';
			}
			else
			{
				echo '<br />'.JText::_('JL_GLOBAL_ERROR').'<br />'.$model->getError().'<br />';
			}
			$link='index.php?option=com_joomleague&controller=project&view=projects';
		}
		else
		{
			echo '<br />'.JText::_('JL_GLOBAL_ERROR').'<br />'.$model->getError().'<br />';
		}
		#$this->setRedirect($link,$msg);
	}

	function remove()
	{
		JRequest::checkToken() or die(JText::_('JL_GLOBAL_INVALID_TOKEN'));
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();

		JToolBarHelper::title(JText::_('JL_PROJECT_DELETE_TITLE'),'ProjectSettings');
		JToolBarHelper::back('JL_PROJECT_BACK','index.php?option=com_joomleague&view=projects');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);

		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_DELETE'));}

		foreach ($cid as $pid)
		{
			//delete project
			$model=$this->getModel('project');
			$project_id=(int)$pid;
			if (!$model->exists($project_id))
			{
				echo JText::sprintf('JL_PROJECT_NOT_EXISTS',"<b>$project_id</b>").'<br />';
				break;
			}

			echo '<h3>'.JText::sprintf('JL_PROJECT_DELETING','<i>'.$model->getProjectName($project_id).'</i>').'</h3>';
			
			//delete matches
			echo JText::_('JL_PROJECT_DELETING_MATCHES').'&nbsp;&nbsp;';
			$model=$this->getModel('match');
			if (!$model->deleteOne($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
			
			//delete rounds
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_ROUNDS').'&nbsp;&nbsp;';
			$model=$this->getModel('round');
			if (!$model->deleteOne($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
			
			//delete projectpositions
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_POSITIONS').'&nbsp;&nbsp;';
			$model=$this->getModel('position');
			if (!$model->deleteOne($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
			
			//delete projectreferees
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_REFEREES').'&nbsp;&nbsp;';
			$model=$this->getModel('projectreferee');
			if (!$model->deleteOne($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
			
			//delete teamplayers
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_PLAYERS').'&nbsp;&nbsp;';
			$mdlProject=$this->getModel('project');
			$mdlProject->setId($project_id);
			$mdlProject->getData();
			if (!$mdlProject->removeProjectPlayers($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$mdlProject->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
			//delete teamstaff
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_STAFFS').'&nbsp;&nbsp;';
			if (!$mdlProject->removeProjectStaff($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$mdlProject->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
			
			//delete projectteams
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_TEAMS').'&nbsp;&nbsp;';
			$model=$this->getModel('team');
			if (!$model->deleteOne($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
			//delete treetos
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_TREETOS').'&nbsp;&nbsp;';
			$model=$this->getModel('treeto');
			if (!$model->deleteOne($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}

			// Delete project divisions in table #__joomleague_division
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_DIVISIONS').'&nbsp;&nbsp;';
			$model=$this->getModel('division');
			if (!$model->deleteOne($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
			
			//delete projectteamplates
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_TEMPLATES').'&nbsp;&nbsp;';
			$model=$this->getModel('template');
			if (!$model->deleteOne($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}

			//delete projectsettings?
			echo '<br /><br />'.JText::_('JL_PROJECT_DELETING_SETTINGS').'&nbsp;&nbsp;';
			if (!$mdlProject->delete($project_id))
			{
				echo '<span style="color:red">'.JText::_('JL_GLOBAL_ERROR').'</span> - '.$model->getError();
				break;
			}
			else
			{
				echo '<span style="color:green">'.JText::_('JL_GLOBAL_SUCCESS').'</span>';
			}
		}
		//$this->setRedirect('index.php?option=com_joomleague&controller=project&view=projects');
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or die(JText::_('JL_GLOBAL_INVALID_TOKEN'));
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(0),'post','array');
		$post['id']=(int) $cid[0];
		$msg='';
		// convert dates back to mysql date format
		if (isset($post['start_date']))
		{
			$post['start_date']=strtotime($post['start_date']) ? strftime('%Y-%m-%d',strtotime($post['start_date'])) : null;
		}
		else
		{
			$post['start_date']=null;
		}

		if (isset($post['fav_team']))
		{
			if (count($post['fav_team']) > 0)
			{
				$temp=implode(",",$post['fav_team']);
			}
			else
			{
				$temp='';
			}
			$post['fav_team']=$temp;
		}
		else
		{
			$post['fav_team']='';
		}
		if (isset($post['extension']))
		{
			if (count($post['extension']) > 0)
			{
				$temp=implode(",",$post['extension']);
			}
			else
			{
				$temp='';
			}
			$post['extension']=$temp;
		}
		else
		{
			$post['extension']='';
		}

		if (isset($post['leagueNew']))
		{
			$mdlLeague=$this->getModel('league');
			$post['league_id']=$mdlLeague->addLeague($post['leagueNew']);
			$msg .= JText::_('JL_LEAGUE_CREATED').',';

		}
		if (isset($post['seasonNew']))
		{
			$mdlSeason=$this->getModel('season');
			$post['season_id']=$mdlSeason->addSeason($post['seasonNew']);
			$msg .= JText::_('JL_SEASON_CREATED').',';
		}

		$model=$this->getModel('project');

		if ($model->store($post))
		{
			//	save the templates params
			if ($post['id']==0){$post['id']=$model->_db->insertid();}
			$templatesModel =& JLGModel::getInstance('Templates','JoomleagueModel');
			$templatesModel->setProjectId($post['id']);
			$templatesModel->checklist();
			$msg .= JText::_('JL_PROJECT_SAVED');
		}
		else
		{
			$msg=JText::_('JL_ERROR_SAVING_PROJECT').$model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();
		if ($this->getTask()=='save')
		{
			$link='index.php?option=com_joomleague&controller=project&view=projects';
		}
		else
		{
			$link='index.php?option=com_joomleague&controller=project&task=edit&cid[]='.$post['id'];
		}
		//echo $msg;
		$this->setRedirect($link,$msg);
	}

	function publish()
	{
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_PUBLISH'));}
		$model=$this->getModel('project');
		if(!$model->publish($cid,1))
		{
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}
		$this->setRedirect('index.php?option=com_joomleague&controller=project&view=projects');
	}

	function unpublish()
	{
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_UNPUBLISH'));}
		$model=$this->getModel('project');
		if (!$model->publish($cid,0))
		{
			echo "<script> alert('".$model->getError()."'); window.history.go(-1); </script>\n";
		}
		$this->setRedirect('index.php?option=com_joomleague&controller=project&view=projects');
	}

	function cancel()
	{
		// Checkin the project
		$model=$this->getModel('project');
		$model->checkin();
		$this->setRedirect('index.php?option=com_joomleague&controller=project&view=projects');
	}

	function orderup()
	{
		$model=$this->getModel('project');
		$model->move(-1);
		$this->setRedirect('index.php?option=com_joomleague&controller=project&view=projects');
	}

	function orderdown()
	{
		$model=$this->getModel('project');
		$model->move(1);
		$this->setRedirect('index.php?option=com_joomleague&controller=project&view=projects');
	}

	function saveorder()
	{
		$cid=JRequest::getVar('cid',array(),'post','array');
		$order=JRequest::getVar('order',array(),'post','array');
		JArrayHelper::toInteger($cid);
		JArrayHelper::toInteger($order);
		$model=$this->getModel('project');
		$model->saveorder($cid,$order);
		$this->setRedirect('index.php?option=com_joomleague&controller=project&view=projects',JText::_('JL_GLOBAL_NEW_ORDERING_SAVED'));
	}

	function import()
	{
		JRequest::setVar('view','import');
		JRequest::setVar('table','project');
		parent::display();
	}
	
	function export()
	{
		JRequest::checkToken() or die('JL_GLOBAL_INVALID_TOKEN');
		$post=JRequest::get('post');
		$cid=JRequest::getVar('cid',array(),'post','array');
		JArrayHelper::toInteger($cid);
		if (count($cid) < 1){JError::raiseError(500,JText::_('JL_GLOBAL_SELECT_TO_EXPORT'));}
		$model = $this->getModel("project");
		$model->export($cid, "project", "Joomleague15");
	}
	
}
?>