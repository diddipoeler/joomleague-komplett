<?php
/**
* @copyright	Copyright (C) 2007 Joomleague.de. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
* @diddipoeler
*/


// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );



$maxImportTime=480;

if ((int)ini_get('max_execution_time') < $maxImportTime){@set_time_limit($maxImportTime);}

class JoomleagueModeljlextcsseditor extends JModel
{

function _loadData()
	{
  /*
  global $mainframe, $option;
  echo '_loadData projekt -> '.$mainframe->getUserState( $option . 'project', 0 ).'<br>';
  $this->_data =  $mainframe->getUserState( $option . 'project', 0 );
  return $this->_data;
  */
	}

function _initData()
	{
	/*
	global $mainframe, $option;
  echo '_initData projekt -> '.$mainframe->getUserState( $option . 'project', 0 ).'<br>';
  $this->_data =  $mainframe->getUserState( $option . 'project', 0 );
  return $this->_data;
  */
	}
	
	function _CHOOSE_TITLE()
  {
  $editor	= JRequest::getCmd('editor');
    switch($editor)
			{
				case 'CSS':
			    JToolBarHelper::title( JText::_( 'Joomleague-CSS Manager' ), 'thememanager' );			
					break;

				case 'XML':
			    JToolBarHelper::title( JText::_( 'Joomleague-XML Manager' ), 'thememanager' );
					break;
			}
		//JToolBarHelper::title( JText::_( 'Joomleague-CSS Editor' ), 'thememanager' );
		JToolBarHelper::custom( 'edit_css', 'edit.png', 'edit_f2.png', 'Edit', true );
		JToolBarHelper::cancel('edit');
		JToolBarHelper::help( 'screen.templates' );
	}
	
	function _CHOOSE_CSS(&$client)
  {
  $editor	= JRequest::getCmd('editor');
    switch($editor)
			{
				case 'CSS':
			    JToolBarHelper::title( JText::_( 'Joomleague-CSS Manager' ), 'thememanager' );			
					break;

				case 'XML':
			    JToolBarHelper::title( JText::_( 'Joomleague-XML Manager' ), 'thememanager' );
					break;
			}
		//JToolBarHelper::title( JText::_( 'Joomleague-CSS Editor' ), 'thememanager' );
		JToolBarHelper::custom( 'edit_css', 'edit.png', 'edit_f2.png', 'Edit', true );
		JToolBarHelper::cancel('edit');
		JToolBarHelper::help( 'screen.templates' );
	}
	
	function _EDIT_CSS(&$client)
  {
  $editor	= JRequest::getCmd('editor');
	  switch($editor)
			{
				case 'CSS':
			    JToolBarHelper::title( JText::_( 'Joomleague-CSS Editor' ), 'thememanager' );			
					break;

				case 'XML':
			    JToolBarHelper::title( JText::_( 'Joomleague-XML Editor' ), 'thememanager' );
					break;
			}
  	
		JToolBarHelper::save( 'save_css' );
		JToolBarHelper::apply( 'apply_css');
		JToolBarHelper::cancel('choose_css');
		JToolBarHelper::help( 'screen.templates' );
	}
	
	function chooseTemplateCSS()
	{
		global $mainframe;

		// Initialize some variables
		$option 	= JRequest::getCmd('option');
		$template	= JRequest::getVar('id', '', 'method', 'cmd');
		$editor	= JRequest::getCmd('editor');
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

    //echo JPATH_COMPONENT.'<br>';
    //echo JPATH_SITE.'<br>';
    
    jimport('joomla.filesystem.folder');
    
    switch($editor)
			{
				case 'CSS':
					// Determine template CSS directory
		      $dir = JPATH_SITE.DS.'components'.DS.$option.DS.'extensions'.DS.'jlextcsseditor'.DS.'assets'.DS.'css';
		      $files = JFolder::files($dir, '\.css$', false, false);
					break;

				case 'XML':
				  $dir = JPATH_SITE.DS.'administrator'.DS.'components'.DS.$option.DS.'assets'.DS.'extended';
				  $files = JFolder::files($dir, '\.xml$', false, false);
					break;
			}
			
		
    
    //echo $dir.'<br>';
    
		// List template .css files
		//jimport('joomla.filesystem.folder');
		//$files = JFolder::files($dir, '\.css$', false, false);

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');

		require_once (JPATH_SITE.DS.'components'.DS.$option.DS.'extensions'.DS.'jlextcsseditor'.DS.'admin'.DS. 'helpers'.DS.'admin.templates.html.php');
		TemplatesView::chooseCSSFiles($template, $dir, $files, $option, $client, $editor);
	}
	
	function editTemplateCSS()
	{
		global $mainframe;

		// Initialize some variables
		$option		= JRequest::getCmd('option');
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$template	= JRequest::getVar('id', '', 'method', 'cmd');
		$filename	= JRequest::getVar('filename', '', 'method', 'cmd');
    $editor	= JRequest::getCmd('editor');
    
    
		jimport('joomla.filesystem.file');

// 		if (JFile::getExt($filename) !== 'css') {
// 			$msg = JText::_('Wrong file type given, only CSS files can be edited.');
// 			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=choose_css&id='.$template, $msg, 'error');
// 		}

		//$content = JFile::read($client->path.DS.'templates'.DS.$template.DS.'css'.DS.$filename);
    switch($editor)
			{
				case 'CSS':
					// Determine template CSS directory
		      $dir = JPATH_SITE.DS.'components'.DS.$option.DS.'extensions'.DS.'jlextcsseditor'.DS.'assets'.DS.'css';
		      //$files = JFolder::files($dir, '\.css$', false, false);
					break;

				case 'XML':
				  $dir = JPATH_SITE.DS.'administrator'.DS.'components'.DS.$option.DS.'assets'.DS.'extended';
				  //$files = JFolder::files($dir, '\.xml$', false, false);
					break;
			}
    //$dir = JPATH_SITE.DS.'components'.DS.$option.DS.'extensions'.DS.'jlextcsseditor'.DS.'assets'.DS.'css';
    
    
    $content = JFile::read($dir.DS.$filename);
		if ($content !== false)
		{
			// Set FTP credentials, if given
			jimport('joomla.client.helper');
			$ftp =& JClientHelper::setCredentialsFromRequest('ftp');

			$content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');
//			require_once (JPATH_COMPONENT.DS.'admin.templates.html.php');
			require_once (JPATH_SITE.DS.'components'.DS.$option.DS.'extensions'.DS.'jlextcsseditor'.DS.'admin'.DS.'helpers'.DS.'admin.templates.html.php');
			TemplatesView::editCSSSource($template, $filename, $content, $option, $client, $ftp, $editor);
		}
		else
		{
			$msg = JText::sprintf('Operation Failed Could not open', $client->path.$filename);
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, $msg);
		}
	}

  function saveTemplateCSS()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$option			= JRequest::getCmd('option');
		$client			=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$template		= JRequest::getVar('id', '', 'post', 'cmd');
		$filename		= JRequest::getVar('filename', '', 'post', 'cmd');
		$filecontent	= JRequest::getVar('filecontent', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$editor	= JRequest::getCmd('editor');

// 		if (!$template) {
// 			$mainframe->redirect('index.php?option='.$option.'&view=jlextcsseditor&controller=jlextcsseditor&client='.$client->id, JText::_('Operation Failed').': '.JText::_('No template specified.'));
// 		}

		if (!$filecontent) {
			$mainframe->redirect('index.php?option='.$option.'&editor='.$editor.'&view=jlextcsseditor&controller=jlextcsseditor&client='.$client->id, JText::_('Operation Failed').': '.JText::_('Content empty.'));
		}

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');

    switch($editor)
			{
				case 'CSS':
					// Determine template CSS directory
		      $dir = JPATH_SITE.DS.'components'.DS.$option.DS.'extensions'.DS.'jlextcsseditor'.DS.'assets'.DS.'css';
		      //$files = JFolder::files($dir, '\.css$', false, false);
					break;

				case 'XML':
				  $dir = JPATH_SITE.DS.'administrator'.DS.'components'.DS.$option.DS.'assets'.DS.'extended';
				  //$files = JFolder::files($dir, '\.xml$', false, false);
					break;
			}
    //$dir = JPATH_SITE.DS.'components'.DS.$option.DS.'extensions'.DS.'jlextcsseditor'.DS.'assets'.DS.'css';
		$file = $dir.DS.$filename;

		// Try to make the css file writeable
		if (!$ftp['enabled'] && JPath::isOwner($file) && !JPath::setPermissions($file, '0755')) {
			JError::raiseNotice('SOME_ERROR_CODE', JText::_('Could not make the css file writable'));
		}

		jimport('joomla.filesystem.file');
		$return = JFile::write($file, $filecontent);

		// Try to make the css file unwriteable
		if (!$ftp['enabled'] && JPath::isOwner($file) && !JPath::setPermissions($file, '0644')) {
			JError::raiseNotice('SOME_ERROR_CODE', JText::_('Could not make the css file unwritable'));
		}

		if ($return)
		{
			$task = JRequest::getCmd('task');
			switch($task)
			{
				case 'apply_css':
					$mainframe->redirect('index.php?option='.$option.'&editor='.$editor.'&view=jlextcsseditor&controller=jlextcsseditor&client='.$client->id.'&task=edit_css&id='.$template.'&filename='.$filename,  JText::_('File Saved'));
					break;

				case 'save_css':
				default:
					$mainframe->redirect('index.php?option='.$option.'&editor='.$editor.'&view=jlextcsseditor&controller=jlextcsseditor&client='.$client->id.'&task=edit&cid[]='.$template, JText::_('File Saved'));
					break;
			}
		}
		else {
			$mainframe->redirect('index.php?option='.$option.'&editor='.$editor.'&view=jlextcsseditor&controller=jlextcsseditor&client='.$client->id.'&id='.$template.'&task=choose_css', JText::_('Operation Failed').': '.JText::sprintf('Failed to open file for writing.', $file));
		}
	}
	
	
}

?>
