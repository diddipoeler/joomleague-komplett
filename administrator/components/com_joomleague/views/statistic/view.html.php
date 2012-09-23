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
jimport( 'joomla.filesystem.file' );

require_once( JPATH_COMPONENT . DS . 'helpers' . DS . 'imageselect.php' );
require_once( JPATH_COMPONENT_ADMINISTRATOR . DS . 'statistics' . DS . 'base.php' );

/**
 * HTML View class for the Joomleague component
 *
 * @static
 * @package		Joomleague
 * @since 1.5
 */
class JoomleagueViewStatistic extends JLGView
{
	function display($tpl = null)
	{
		if($this->getLayout() == 'form')
		{
			$this->_displayForm($tpl);
			return;
		}

		//get the object
		$event =& $this->get('data');

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		$option='com_joomleague';
		$mainframe	=& JFactory::getApplication();

		$document	= & JFactory::getDocument();
		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();

		$lists  = array();
		$item 	=& $this->get('data');
		$isNew	= ( $item->id < 1 );

		$edit = JRequest::getVar('edit',true);

		// fail if checked out not by 'me'
		if ( $model->isCheckedOut( $user->get('id') ) )
		{
			$msg = JText::sprintf( 'DESCBEINGEDITTED', JText::_( 'The item' ), $item->name );
			$mainframe->redirect( 'index.php?option=' . $option .'&view=statistics', $msg, 'error' );
		}

		// Edit or Create?
		if ( !$isNew )
		{
			$model->checkout( $user->get('id') );
		}

		// build the html select list for ordering
		$query = $model->getOrderingAndStatisticQuery();
		$lists['ordering'] = JHTML::_( 'list.specificordering', $item, $item->id, $query, 1 );

		// icon
		//if there is no icon selected, use default icon
		$default = JoomleagueHelper::getDefaultPlaceholder("icon");
		if (empty($item->icon)){$item->icon=$default;}

		// image selector
		$imageselect = ImageSelect::getSelector('icon','picture_preview','statistics',$item->icon,$default);

		// class selector
		$files = JFolder::files(JPATH_COMPONENT_ADMINISTRATOR.DS.'statistics', 'php$');
		$options = array();
		foreach ($files as $file)
		{
			$parts = explode('.', $file);
			if ($parts[0] != 'base') {
				$options[] = JHTML::_('select.option', $parts[0], $parts[0]);
			}
		}	
		// check for statistic in extensions
		$extensions = JoomleagueHelper::getExtensions(0);		
		foreach ($extensions as $type)
		{
			$path = JLG_PATH_SITE.DS.'extensions'.DS.$type.DS.'admin'.DS.'statistics';
			if (!file_exists($path)) {
				continue;
			}
			$files = JFolder::files($path, 'php$');
			foreach ($files as $file)
			{
				$parts = explode('.', $file);
				if ($parts[0] != 'base') {
					$options[] = JHTML::_('select.option', $parts[0], $parts[0]);
				}
			}	
		}
		$lists['class'] = JHTML::_('select.genericlist', $options, 'class', 'class="inputbox"', 'value', 'text', $item->class);

		//build the html select list for sports_type
		$sports_type[]=JHTML::_('select.option','0',JText::_('JL_GLOBAL_SELECT_SPORTSTYPE'),'id','name');
		if ($res =& JoomleagueHelper::getSportsTypes()){$sports_type=array_merge($sports_type,$res);}
		$lists['sports_type']=JHTML::_(	'select.genericlist',$sports_type,'sports_type_id',
										'class="inputbox validate-select-required" size="1"',
										'id','name',$item->sports_type_id);
		unset($sports_type);

		if (!empty($item->class))
		{
			/*
			 * statistic class parameters
			 */
			$class = &JLGStatistic::getInstance($item->class);
			$class->bind($item);
			$this->assignRef( 'baseparams', $class->getBaseParams() );
			$this->assignRef( 'classparams', $class->getClassParams() );
			$this->assign( 'calculated',   $class->getCalculated());
		}

		$this->assignRef( 'imageselect', $imageselect);
		$this->assignRef( 'lists', $lists );
		$this->assignRef( 'item', $item );
		$this->assignRef( 'edit', $edit );

		parent::display($tpl);
	}
}
?>