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
 * Joomleague TeamStaff Table class
 *
 * @package	JoomLeague
 * @since	1.50a
 */
class TableTeamStaff extends JLTable
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
	 * stores project depending picture
	 *
	 * @var string
	 */
	var $picture = null;

	/**
	 * complementary info for player in this team
	 * @var unknown_type
	 */
	var $notes = null;

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
		parent::__construct( '#__joomleague_team_staff', 'id', $db );
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

	function canDelete($id)
	{
		// the staff cannot be deleted if assigned to games
		$query = ' SELECT COUNT(id) FROM #__joomleague_match_staff '
		       . ' WHERE team_staff_id = '. $this->_db->Quote($id)
		       . ' GROUP BY team_staff_id ';
		$this->_db->setQuery($query, 0, 1);
		$res = $this->_db->loadResult();
		
		if ($res) {
			$this->setError(Jtext::sprintf('STAFF ASSIGNED TO %d GAMES', $res));
			return false;
		}
		
		// the staff cannot be deleted if has stats
		$query = ' SELECT COUNT(id) FROM #__joomleague_match_staff_statistic '
		       . ' WHERE team_staff_id = '. $this->_db->Quote($id)
		       . ' GROUP BY team_staff_id ';
		$this->_db->setQuery($query, 0, 1);
		$res = $this->_db->loadResult();
		
		if ($res) {
			$this->setError(JText::sprintf('%d STATS ASSIGNED TO STAFF', $res));
			return false;
		}
		
		return true;
	}
}
?>