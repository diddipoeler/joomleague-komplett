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

jimport('joomla.application.component.model');
require_once (JLG_PATH_ADMIN.DS.'models'.DS.'list.php');

/**
 * Joomleague 
 *
 * @author	
 * @package	JoomLeague
 * @since	0.1
 */

class JoomleagueModeljlextensions extends JoomleagueModelList
{

function getJoomleagueExtensions()
{
global $mainframe;

$topath = JPATH_SITE.DS.'components'.DS.'com_joomleague'.DS.'extensions';
$installextensions = JFolder::folders($topath);

return $installextensions;

}

function deleteExtensions()
{
global $mainframe;
$post = JRequest::get('post');
$cid = JRequest::getVar('cid',array(),'post','array');
$folder_name = JRequest::getVar('folder_name',array(),'post','array');


foreach ( $cid as $key => $value )
{
$deletepath = JPATH_SITE.DS.'components'.DS.'com_joomleague'.DS.'extensions'.DS.$folder_name[$value];

if( JFolder::delete($deletepath) )
{
$mainframe->enqueueMessage(JText::_('Extension -> '.$folder_name[$value].' wurdde gel&ouml;scht!'),'Notice');
}
else
{
$mainframe->enqueueMessage(JText::_('Extension -> '.$folder_name[$value].' wurdde nicht gel&ouml;scht!'),'Error');
}

}


}

}


?>