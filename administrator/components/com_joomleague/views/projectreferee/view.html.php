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

require_once (JPATH_COMPONENT.DS.'helpers'.DS.'imageselect.php');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewProjectReferee extends JLGView
{

	function display($tpl=null)
	{
		$mainframe	=& JFactory::getApplication();

		if ($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}

		//get the division
		$project_team =& $this->get('data');

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		$mainframe	=& JFactory::getApplication();
		$db	 		=& JFactory::getDBO();
		$uri		=& JFactory::getURI();
		$user		=& JFactory::getUser();
		$model		=& $this->getModel();

		$lists=array();
		//get the projectreferee data of the project_team
		$projectreferee =& $this->get('data');
		$isNew=($projectreferee->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_P_REF_THE_PREF'),$projectreferee->name);
			$mainframe->redirect('index.php?option=com_joomleague',$msg);
		}

		// Edit or Create?
		if ($isNew)
		{
			$projectreferee->order=0;
		}

		//build the html select list for positions
		$refereepositions=array();
		$refereepositions[]=JHTML::_('select.option',	'0',JText::_('JL_GLOBAL_SELECT_REF_POS'));
		if ($res=& $model->getRefereePositions())
		{
			$refereepositions=array_merge($refereepositions,$res);
		}
		$lists['refereepositions']=JHTML::_(	'select.genericlist',
												$refereepositions,
												'position_id',
												'class="inputbox" size="1"',
												'value',
												'text',$projectreferee->project_position_id);
		unset($refereepositions);
                
        $default = JoomleagueHelper::getDefaultPlaceholder("player");
        if (empty($projectreferee->picture)){$projectreferee->picture=$default;}
		$imageselect	= ImageSelect::getSelector('picture','picture_preview','persons',$projectreferee->picture,$default);

		$projectws	=& $this->get('Data','projectws');

		$this->assignRef('projectws',$projectws);
		$this->assignRef('lists',$lists);
		$this->assignRef('projectreferee',$projectreferee);
		$this->assignRef('imageselect',$imageselect);
		/*
		 * extended data
		 */
		$paramsdata = $projectreferee->extended;
		$paramsdefs = JPATH_COMPONENT . DS . 'assets' . DS . 'extended' . DS . 'projectreferee.xml';
		$extended = new JParameter( $paramsdata, $paramsdefs );

		$this->assignRef( 'extended',		$extended );
		
		parent::display($tpl);
	}

}
?>