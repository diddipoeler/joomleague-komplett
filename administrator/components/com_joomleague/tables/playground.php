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
* Playground Table class
*
* @package		Joomleague
* @since 0.1
*/
class TablePlayground extends JLTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id= NULL;
	var $name;
	/* alias for nice sef urls */
	var $alias;
	var $short_name;
	var $address;
	var $zipcode;
	var $city;
	var $country;
	var $max_visitors;
	var $picture;
	var $notes;
	var $club_id;
	var $website;
	/**
	 * stores extended info
	 *
	 * @var string
	 */
	var $extended;	
	var $ordering;
	var $checked_out;
	var $checked_out_time;
    var $unique_id;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__joomleague_playground', 'id', $db);
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
			$this->setError(JText::_('ERROR NAME REQUIRED'));
			return false;
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
	
}
?>
