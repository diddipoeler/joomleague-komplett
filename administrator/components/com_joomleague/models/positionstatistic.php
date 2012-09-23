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
 * Joomleague Component positionstatistic Model
 *
 * @author Marco Vaninetti <martizva@libero.it>
 * @package   Joomleague
 * @since
 */
class JoomleagueModelPositionstatistic extends JoomleagueModelItem
{
	/**
	 * Method to remove position statistics
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function delete( $cid = array() )
	{
		$result = false;

		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = '	DELETE
						FROM #__joomleague_position_statistic
						WHERE position_id IN ( ' . $cids . ' )';

			$this->_db->setQuery( $query );
			if ( !$this->_db->query() )
			{
				$this->setError( $this->_db->getErrorMsg() );
				return false;
			}
		}
		return true;
	}


	/**
	 * Method to load  data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function _loadData()
	{
		return true;
	}

	/**
	 * Method to initialise data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		return true;
	}


	/**
	 * Method to update position statistic
	 *
	 * @access	public
	 * @return	boolean	True on success
	 *
	 */
	function store($data)
	{
 		$result	= true;
		$peid	= (isset($data['position_statistic']) ? $data['position_statistic'] : array());
		JArrayHelper::toInteger( $peid );
		$peids = implode( ',', $peid );
		
		$query = ' DELETE	FROM #__joomleague_position_statistic '
		       . ' WHERE position_id = ' . $data['id']
		       ;
		if (count($peid)) {
			$query .= '   AND statistic_id NOT IN  (' . $peids . ')';
		}

		$this->_db->setQuery( $query );
		if( !$this->_db->query() )
		{
			$this->setError( $this->_db->getErrorMsg() );
			$result = false;
		}

		for ( $x = 0; $x < count($peid); $x++ )
		{
			$query = "UPDATE #__joomleague_position_statistic SET ordering='$x' WHERE position_id = '" . $data['id'] . "' AND statistic_id = '" . $peid[$x] . "'";
 			$this->_db->setQuery( $query );
			if( !$this->_db->query() )
			{
				$this->setError( $this->_db->getErrorMsg() );
				$result= false;
			}
		}
		for ( $x = 0; $x < count($peid); $x++ )
		{
			$query = "INSERT IGNORE INTO #__joomleague_position_statistic (position_id, statistic_id, ordering) VALUES ( '" . $data['id'] . "', '" . $peid[$x] . "','" . $x . "')";
			$this->_db->setQuery( $query );
			if ( !$this->_db->query() )
			{
				$this->setError( $this->_db->getErrorMsg() );
				$result= false;
			}
		}
		return $result;
	}

}
?>