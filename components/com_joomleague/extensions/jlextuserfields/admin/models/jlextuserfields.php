<?php
/**
 * @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );
//require_once ( JPATH_COMPONENT . DS . 'models' . DS . 'project.php' );
//require_once (JPATH_COMPONENT.DS.'models'.DS.'list.php');

/**
 * Joomleague Component Adminmenu Model
 *
 * @author Marco Vaninetti <martizva@alice.it>
 * @package   Joomleague
 * @since 0.1
 */
class JoomleagueModeljlextuserfields extends JModel
{

function getJLTables()
	{
		$query = '	SELECT	id,
							tablename
					FROM #__joomleague_jltable_tables
					ORDER BY tablename ASC';

		$this->_db->setQuery( $query );

		if ( !$result = $this->_db->loadObjectList() )
		{
			$this->setError($this->_db->getErrorMsg());
			return false;

		}
		else
		{
			return $result;
		}
	}
	
function getJLTableFields()
{
$option='com_joomleague';
$mainframe =& JFactory::getApplication();
// $post = JRequest::get( 'post' );
// $jltable = JRequest::getVar("jltable");
$jltableid = JRequest::getInt( "jltableid", 0 );

$table = 'JLTableTables';
$jltablerow =& JTable::getInstance( $table, 'Table' );
$jltablerow->load($jltableid);

// echo 'post<br><pre>',print_r($post,true),'</pre><br>';
// echo 'REQUEST<br><pre>',print_r($_REQUEST,true),'</pre><br>';

$mainframe->enqueueMessage(JText::_('tabelle  -> '.$jltablerow->tablename),'Notice');
//$mainframe->enqueueMessage(JText::_('tabelleid  -> '.$jltableid),'Notice');

$query = "	SELECT jlf.*	
					FROM #__joomleague_jltable_fields as jlf
					inner join #__joomleague_jltable_tables as jlt
					on jlt.tablename = jlf.tablename
					where jlt.id = ".$jltableid."
					ORDER BY jlf.ordering ASC";

		$this->_db->setQuery( $query );

		if ( !$result = $this->_db->loadObjectList() )
		{
			$this->setError($this->_db->getErrorMsg());
			return false;

		}
		else
		{
			return $result;
		}

}	
	
}

?>