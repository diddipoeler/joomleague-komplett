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

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewSeason extends JLGView
{

	function display($tpl=null)
	{
		$mainframe =& JFactory::getApplication();

		if ($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}

		//get the project
		$season =& $this->get('data');

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();
		$model =& $this->getModel();
		$lists=array();
		//get the season
		$season =& $this->get('data');
		$isNew=($season->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_SEASON'),$season->name);
			$mainframe->redirect('index.php?option='.$option,$msg);
		}

		// Edit or Create?
		if (!$isNew)
		{
			$model->checkout($user->get('id'));
		}
		else
		{
			// initialise new record
			$season->order=0;
		}

		// build the html select list for ordering
		$query = $model->getOrderingAndSeasonQuery();			
		$lists['ordering']=JHTML::_('list.specificordering',$season,$season->id,$query,1);

		$this->assignRef('lists',$lists);
		$this->assignRef('season',$season);

		parent::display($tpl);
	}

}
?>