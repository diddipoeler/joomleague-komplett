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
jimport('joomla.filter.input');

/**
 * Statistic Table class
 *
 * @package	Joomleague
 * @since	1.5
 */
class TableStatistic extends JLTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * stat name
	 * @var string
	 */
	var $name;
	/**
	 * alias for nice sef urls
	 * @var string
	 */
	var $alias;
	
	/**
	 * short form (abbreviation) of the name
	 * @var string
	 */
	var $short;
	/**
	 * icon path
	 * @var string
	 */
	var $icon;

	/**
	 * Handling class
	 * @var string
	 */
	var $class;
	/**
	 * is the stat calculated ?
	 * @var int
	 */
	var $calculated;
	/**
	 * base parameters for the stat (from base.xml)
	 * @var string
	 */
	var $baseparams;
	/**
	 * parameters for the stat (from xml)
	 * @var string
	 */
	var $params;
	/**
	 * short note (to distinguish stat with same name)
	 * @var string
	 */
	var $note;

	var $sports_type_id;	
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
		parent::__construct('#__joomleague_statistic', 'id', $db);
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
		if (empty($this->name)) {
			$this->setError(JText::_('NAME REQUIRED'));
			return false;
		}
		
		if (empty($this->short)) {
			$this->short = strtoupper(substr($this->name, 0, 4));
		}
	
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
	
	/**
	 * extends bind to include class params (non-PHPdoc)
	 * @see administrator/components/com_joomleague/tables/JLTable#bind($array, $ignore)
	 */
	function bind($array, $ignore = '')
	{
		if (key_exists( 'baseparams', $array ) && is_array( $array['baseparams'] ))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['baseparams']);
			$array['baseparams'] = $registry->toString();
		}
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			//for multilist select of statistic_views param
			$array['params']['statistic_views'] = implode( ',', $array['params']['statistic_views'] );
			
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}
		return parent::bind($array, $ignore);
	}
}
?>