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

// Include library dependencies
jimport( 'joomla.filter.input' );

/**
 * Joomleague Person Table class
 *
 * @package	JoomLeague
 * @since 	1.50a
 */
class TableTeamPlayer extends JLTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

  /**
   * project team id the player belongs too
   * @var int
   */
	var $projectteam_id;

	var $person_id;

	/**
	 * default position
	 * @var int
	 */
	var $project_position_id;

	/**
	 * is still in team ?
	 * @var int
	 */
	var $active = 1;

	/**
	 * player number on jersey
	 * @var unknown_type
	 */
	var $jerseynumber;

	/**
	 * complementary info for player in this team
	 * @var unknown_type
	 */
	var $notes = null;

	/**
	 * stores project depending picture
	 *
	 * @var string
	 */
	var $picture = null;

	var $injury;
	var $injury_date;
	var $injury_end;
	var $injury_detail;
	var $injury_date_start;
	var $injury_date_end;

	var $suspension;
	var $suspension_date;
	var $suspension_end;
	var $suspension_detail;
	var $susp_date_start;
	var $susp_date_end;

	var $away;
	var $away_date;
	var $away_end;
	var $away_detail;
	var $away_date_start;
	var $away_date_end;

	/**
	 * stores extended info
	 *
	 * @var string
	 */
	var $extended;

	var $published=1;
	var $ordering;
	var $checked_out;
	var $checked_out_time;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db)
	{
		parent::__construct( '#__joomleague_team_player', 'id', $db );
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 * @since 1.0
	 */
	function check()
	{
		//should check name unicity
		return true;
	}


	/**
	 * Default delete method
	 **
	 * @access public
	 * @return true if successful otherwise returns and error message
	 */
	function delete( $oid=null )
	{
		//TODO: check that there are no events and and matches associated to this player

		$k = $this->_tbl_key;
		if ($oid) {
			$this->$k = intval( $oid );
		}

		$query = 'DELETE FROM '.$this->_db->nameQuote( $this->_tbl ).
				' WHERE '.$this->_tbl_key.' = '. $this->_db->Quote($this->$k);
		$this->_db->setQuery( $query );

		if ($this->_db->query())
		{
			return true;
		}
		else
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
	}

	function canDelete($id)
	{
		// cannot be deleted if assigned to games
		$query = ' SELECT COUNT(id) FROM #__joomleague_match_player '
		       . ' WHERE teamplayer_id = '. $this->_db->Quote($id)
		       . ' GROUP BY teamplayer_id ';
		$this->_db->setQuery($query, 0, 1);
		$res = $this->_db->loadResult();
		
		if ($res) {
			$this->setError(Jtext::sprintf('PLAYER ASSIGNED TO %d GAMES', $res));
			return false;
		}
		
		// cannot be deleted if has events
		$query = ' SELECT COUNT(id) FROM #__joomleague_match_event '
		       . ' WHERE teamplayer_id = '. $this->_db->Quote($id)
		       . ' GROUP BY teamplayer_id ';
		$this->_db->setQuery($query, 0, 1);
		$res = $this->_db->loadResult();
		
		if ($res) {
			$this->setError(JText::sprintf('%d EVENTS ASSIGNED TO PLAYER', $res));
			return false;
		}
		
		// cannot be deleted if has stats
		$query = ' SELECT COUNT(id) FROM #__joomleague_match_statistic '
		       . ' WHERE teamplayer_id = '. $this->_db->Quote($id)
		       . ' GROUP BY teamplayer_id ';
		$this->_db->setQuery($query, 0, 1);
		$res = $this->_db->loadResult();
		
		if ($res) {
			$this->setError(JText::sprintf('%d STATS ASSIGNED TO PLAYER', $res));
			return false;
		}
		
		return true;
	}
}
?>