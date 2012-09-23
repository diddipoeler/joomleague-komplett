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
class JoomleagueViewTemplate extends JLGView
{
	function display($tpl=null)
	{
		$option='com_joomleague';
		$mainframe =& JFactory::getApplication();
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();
		$model =& $this->getModel();
		$lists=array();

		//get template data
		$template =& $this->get('data');
		$isNew=($template->id < 1);

		// fail if checked out not by 'me'
		if ($model->isCheckedOut($user->get('id')))
		{
			$msg=JText::sprintf('DESCBEINGEDITTED',JText::_('JL_ADMIN_TEMPLATE_THETEMPLATE'),$template->name);
			$mainframe->redirect('index.php?option='.$option,$msg);
		}

		// Edit or Create?
		if (!$isNew){$model->checkout($user->get('id'));}

		$projectws =& $this->get('Data','projectws');
		$templatepath=JPATH_COMPONENT_SITE.DS.'settings';
		$xmlfile=$templatepath.DS.'default'.DS.$template->template.'.xml';
		
		$extensions = JoomleagueHelper::getExtensions(JRequest::getInt('p'));
		foreach ($extensions as $e => $extension) {
			$extensiontpath =  JPATH_COMPONENT_SITE . DS . 'extensions' . DS . $extension;
			if (is_dir($extensiontpath.DS.'settings'.DS.'default'))
			{
				if (file_exists($extensiontpath.DS.'settings'.DS.'default'.DS.$template->template.'.xml'))
				{
					$xmlfile=$extensiontpath.DS.'settings'.DS.'default'.DS.$template->template.'.xml';
				}
			}
		}
		
		$params=new JLParameter($template->params,$xmlfile);

		$master_id=($projectws->master_template) ? $projectws->master_template : '-1';
		$templates=array();
		//$templates[]=JHTML::_('select.option','0',JText::_('JL_ADMIN_TEMPLATE_OTHER_TEMPLATE' ),'value','text');
		if ($res=$model->getAllTemplatesList($projectws->id,$master_id)){$templates=array_merge($templates,$res);}
		$lists['templates']=JHTMLSelect::genericlist(	$templates,
														'select_id',
														'class="inputbox" size="1" onchange="javascript: submitbutton(\'apply\');"',
														'value',
														'text',
														$template->id);
		unset($res);
		unset($templates);
//echo '<pre>'.print_r($lists['templates'],true).'</pre>';

		$this->assignRef('request_url',$uri->toString());
		$this->assignRef('template',$template);
		$this->assignRef('params',$params);
		$this->assignRef('project',$projectws);
		$this->assignRef('lists',$lists);
		$this->assignRef('user',$user);

		parent::display($tpl);
	}

}
?>