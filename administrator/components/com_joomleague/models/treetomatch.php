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

jimport( 'joomla.application.component.model' );
require_once ( JPATH_COMPONENT . DS . 'models' . DS . 'item.php' );

/**
 * Joomleague Component treetomatch Model
 *
 * @author	comraden
 * @package	JoomLeague
 * @
 */
class JoomleagueModelTreetomatch extends JoomleagueModelItem
{
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if ( empty( $this->_data ) )
		{
			$query ='	SELECT ttm.*
					FROM #__joomleague_treeto_match AS ttm
					WHERE ttm.id = ' . (int) $this->_id;

			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if ( empty( $this->_data ) )
		{
			$treetomatch = new stdClass();
			$treetomatch->node_id			= 0;
			$treetomatch->match_id			= 0;
			$treetomatch->checked_out		= 0;
			$treetomatch->checked_out_time	= 0;
			$treetomatch->modified			= null;
			$treetomatch->modified_by		= null;
			
			$this->_data			= $treetomatch;
			return (boolean) $this->_data;
		}
		return true;
	}

}
?>