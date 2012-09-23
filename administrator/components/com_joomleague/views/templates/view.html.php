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
 * @author	Marco Vaninetti <martizva@tiscali.it>
 * @package	JoomLeague
 * @since	0.1
 */
class JoomleagueViewTemplates extends JLGView
{
	function display($tpl=null)
	{
		$mainframe =& JFactory::getApplication();
		if ($this->getLayout()=='default')
		{
			$this->_displayDefault($tpl);
			return;
		}
		parent::display($tpl);
	}

	function _displayDefault($tpl)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$document =& JFactory::getDocument();
		$uri =& JFactory::getURI();
		$templates =& $this->get('Data');
		$total =& $this->get('Total');
		$pagination =& $this->get('Pagination');
		$projectws =& $this->get('Data','projectws');
		$model=$this->getModel();

		if ($projectws->master_template)
		{
			$model->set('_getALL',1);
			$allMasterTemplates=$this->get('MasterTemplatesList');
			$model->set('_getALL',0);
			$masterTemplates=$this->get('MasterTemplatesList');
			$importlist=array();
			$importlist[]=JHTML::_('select.option',0,JText::_('JL_ADMIN_TEMPLATES_SELECT_FROM_MASTER'));
			$importlist=array_merge($importlist,$masterTemplates);
			$lists['mastertemplates']=JHTML::_('select.genericlist',$importlist,'templateid');
			$master=$this->get('MasterName');
			$this->assign('master',$master);
			$templates=array_merge($templates,$allMasterTemplates);
		}
//echo '<pre>'.print_r($masterTemplates,true).'</pre>';
//echo '<pre>'.print_r($templates,true).'</pre>';

		$filter_state		= $mainframe->getUserStateFromRequest($option.'tmpl_filter_state',		'filter_state',		'',				'word');
		$filter_order		= $mainframe->getUserStateFromRequest($option.'tmpl_filter_order',		'filter_order',		'tmpl.template','cmd');
		$filter_order_Dir	= $mainframe->getUserStateFromRequest($option.'tmpl_filter_order_Dir',	'filter_order_Dir',	'',				'word');
		$search				= $mainframe->getUserStateFromRequest($option.'tmpl_search',			'search',			'',				'string');
		$search_mode		= $mainframe->getUserStateFromRequest($option.'tmpl_search_mode',		'search_mode',		'',				'string');
		$search				= JString::strtolower($search);

		// state filter
		$lists['state']=JHTML::_('grid.state',$filter_state);

		// table ordering
		$lists['order_Dir']=$filter_order_Dir;
		$lists['order']=$filter_order;

		// search filter
		$lists['search']=$search;
		$lists['search_mode']=$search_mode;

		$this->assignRef('user',JFactory::getUser());
		$this->assignRef('lists',$lists);
		$this->assignRef('templates',$templates);
		$this->assignRef('projectws',$projectws);
		$this->assignRef('pagination',$pagination);
		$this->assignRef('request_url',$uri->toString());

		parent::display($tpl);
	}

}
?>