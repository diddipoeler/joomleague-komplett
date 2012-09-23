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

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * View class for the import screen
 *
 * @package		Joomla
 * @subpackage	JoomLeague
 * @since		1.5
 */
class JoomleagueViewjlextensions extends JLGView
{

	function display($tpl = null)
	{
		
		//initialise variables
		$document	= & JFactory::getDocument();
		$user 		= & JFactory::getUser();
    $uri =& JFactory::getURI();
		$this->assignRef('request_url',$uri->toString());
		// Get data from the model
		$model = & $this->getModel();
		$jlextensions = & $model->getJoomleagueExtensions();

		//assign vars to the template
		$this->assignRef('jlextensions',	$jlextensions);
		JToolBarHelper::custom('jlextensionsdelete','delete','delete',JText::_('JL_DELETE_EXTENSIONS'),false);
		parent::display($tpl);
	}

}
?>