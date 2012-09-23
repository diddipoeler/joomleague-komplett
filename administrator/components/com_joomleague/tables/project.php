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
* Project Table class
*
* @package		Joomleague
* @since 1.5
*/
class TableProject extends JLTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	var $name;
	/**
	 * alias for nice sef urls
	 * @var string
	 */
	var $alias;
	var $league_id;
	var $season_id;

	var $admin;
	var $editor;

	var $master_template;
	var $sub_template_id;		// Points to a template which uses the same master template as defined in $master_template
								// but has only some settings diuffering from the master_template
	var $extension;

	var $serveroffset;
	var $project_type;			// Default is: 'SIMPLE_LEAGUE'
								// Contents may be: 'SIMPLE_LEAGUE', 'DIVISIONS_LEAGUE', 'SIMPLE_KO', 'TOURNAMENT_MODE'
	var $teams_as_referees;
	var $sports_type_id;		// Default is: 'Soccer'
								// Contents may be: 'Soccer', 'Football', 'Hockey', 'Water Polo', *eSports'

	var $start_date;
	var $start_time;

	var $current_round_auto;
	var $current_round;
	var $auto_time;

	var $game_regular_time;

	var $game_parts;
	var $halftime;
	var $points_after_regular_time;	// Default is: '3,1,1'

	var $use_legs;

	var $allow_add_time;
	var $add_time;
	var $points_after_add_time;		// Default is: '3,1,1'
	var $points_after_penalty;

	var $fav_team;
	var $fav_team_highlight_type;
	var $fav_team_color;
	var $fav_team_text_color;
	var $fav_team_text_bold;


	var $template;

	var $enable_sb;
	var $sb_catid;
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
	var $picture;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db)
	{
		parent::__construct( '#__joomleague_project', 'id', $db );
	}

	/**
	* Overloaded bind function
	*
	* @acces public
	* @param array $hash named array
	* @return null|string	null is operation was satisfactory, otherwise returns an error
	* @see JTable:bind
	* @since 1.5
	*/
	function bind( $array, $ignore = '' )
	{
		if ( key_exists( 'params', $array ) && is_array( $array['params'] ) )
		{
			$registry = new JRegistry();
			$registry->loadArray( $array['params'] );
			$array['params'] = $registry->toString();
		}
		if ( key_exists( 'comp_params', $array ) && is_array( $array['comp_params'] ) )
		{
			$registry = new JRegistry();
			$registry->loadArray( $array['comp_params'] );
			$array['comp_params'] = $registry->toString();
		}
    	//print_r( $array );exit;
		return parent::bind( $array, $ignore );
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
		// setting alias
		if ( empty( $this->alias ) )
		{
			$this->alias = JFilterOutput::stringURLSafe( $this->name );
		}
		else {
			$this->alias = JFilterOutput::stringURLSafe( $this->alias ); // make sure the user didn't modify it to something illegal...
		}
		return true;
	}
}
?>