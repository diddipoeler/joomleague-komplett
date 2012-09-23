<?php defined('_JEXEC') or die('Restricted access'); // Check to ensure this file is included in Joomla!

jimport('joomla.application.component.view');

/**
 * AJAX View class for the Joomleague component
 *
 * @static
 * @package	JoomLeague
 * @since	1.5
 */
class JoomleagueViewPersons extends JLGView
{
	/**
	* view AJAX display method
	* @return void
	**/
	function display($tpl=null)
	{
		// Get some data from the model
		$db =& JFactory::getDBO();
		$db->setQuery("	SELECT	pl.id AS value, concat(pl.lastname,',',pl.firstname,' (',pl.birthday,')',' (',pl.id,')') AS pid
						FROM #__joomleague_person pl ORDER BY pl.lastname");
		$dropdrowlistoptions= JHTML::_('select.options',$db->loadObjectList(),'value','pid');
		echo $dropdrowlistoptions;
	}

}
?>