<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
//jimport('joomla.filesystem.file');

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package		Joomleague
 * @since 0.1
 */
class JoomleagueViewTreeto extends JLGView
{
	function display( $tpl = null )
	{
		$mainframe =& JFactory::getApplication();
		if ( $this->getLayout() == 'form' )
		{
			$this->_displayForm( $tpl );
			return;
		}
		elseif ($this->getLayout() == 'gennode')
		{
			$this->_displayGennode($tpl);
			return;
		}
		parent::display( $tpl );
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

		$treeto =& $this->get('data');
		//if there is no image selected, use default picture
		$default = JoomleagueHelper::getDefaultPlaceholder("team");
		if (empty($treeto->trophypic)){$treeto->trophypic=$default;}

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('The treeto'),$treeto->id);
			$mainframe->redirect('index.php?option='.$option,$msg);
		}
	
		$projectws =& $this->get('Data','projectws');

		$this->assignRef('treeto',$treeto);
		$this->assignRef('projectws',$projectws);
		$this->assignRef('lists',$lists);
		parent::display($tpl);
	}

	function _displayGennode($tpl)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();
		$model =& $this->getModel();
		$lists=array();

		$treeto =& $this->get('data');
		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('The treeto'),$treeto->id);
			$mainframe->redirect('index.php?option='.$option,$msg);
		}
		// build the html radio
		$createYesNo=array(0 => JText::_('JL_GLOBAL_NO'),1 => JText::_('JL_GLOBAL_YES'));
		$ynOptions=array();
		foreach($createYesNo AS $key => $value){$ynOptions[]=JHTML::_('select.option',$key,$value);}

		$projectws =& $this->get('Data','projectws');
		$this->assignRef('projectws',$projectws);
		$this->assignRef('lists',$lists);
		$this->assignRef('treeto',$treeto);

		parent::display($tpl);
	}
}
?>