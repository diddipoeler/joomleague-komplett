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

jimport( 'joomla.application.component.controller' );
require_once ( JPATH_COMPONENT . DS . 'controllers' . DS . 'joomleague.php' );

/**
 * Joomleague Component Dfbkeys Controller
 *
 * @author	Dieter Plöger
 * @package	Joomleague
 * @since	1.5.0a
 *  
 */
class JoomleagueControllerjlextcsseditor extends JoomleagueCommonController
{

function __construct()
    {
        parent::__construct();
        $this->registerTask( 'edit_css' , 'edit_css' );
        $this->registerTask( 'choose_css' , 'choose_css' );
        $this->registerTask( 'edit' , 'edit' );
        
        $this->registerTask( 'save_css' , 'save_css' );
        $this->registerTask( 'apply_css' , 'apply_css' );
        
    }
    
function display()  
{

parent::display();
    
}    

function apply_css()
{
global $mainframe,$option;

$document	=& JFactory::getDocument();
$mainframe	=& JFactory::getApplication();
$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
$model		= $this->getModel ( 'jlextcsseditor' );
$model->saveTemplateCSS();

}

function save_css()
{
global $mainframe,$option;

$document	=& JFactory::getDocument();
$mainframe	=& JFactory::getApplication();
$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
$model		= $this->getModel ( 'jlextcsseditor' );
$model->saveTemplateCSS();

}
    
function edit_css()
{
global $mainframe,$option;

$document	=& JFactory::getDocument();
$mainframe	=& JFactory::getApplication();
$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
$model		= $this->getModel ( 'jlextcsseditor' );
$model->_EDIT_CSS($client);
$model->editTemplateCSS();

}

function choose_css()
{
global $mainframe,$option;

$document	=& JFactory::getDocument();
$mainframe	=& JFactory::getApplication();
$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
$model		= $this->getModel ( 'jlextcsseditor' );

// $model->_CHOOSE_CSS($client);
// $model->chooseTemplateCSS();

JRequest::setVar('hidemainmenu',0);
//JRequest::setVar('layout','info');
JRequest::setVar('view','jlextcsseditor');
JRequest::setVar('edit',true);
JRequest::setVar('controller','jlextcsseditor');

parent::display();
				
}      
    
    
}    


?>
