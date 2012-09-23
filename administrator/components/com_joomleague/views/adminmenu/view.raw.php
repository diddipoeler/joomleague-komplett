<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' ); 

/**
 * Seems to be mandatory if we want to make some AJAX calls from
 * administrator side. For instance it's necessary to make project raw view work.
 *
 * @static
 * @package		Joomleague
 * @since 0.1
 */
class JoomleagueViewAdminmenu extends JLGView
{
	/**
     * view AJAX display method
     * @return void
     **/
    function display($tpl = null)
    {
    } 
}
?>