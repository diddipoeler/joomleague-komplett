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
* Event Table class
*
* @package		Joomleague
* @since 0.1
*/
class TableJLTableFields extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id= NULL;

	
	var $tablename;
	var $fieldname;
  var $fieldtype;
  var $fieldnull;
  var $fieldkey;
  var $fielddefault;
  var $fieldextra;
  var $ordering;
  var $fieldlengh;
	var $visible;
	var $description;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct( & $db )
	{
		parent::__construct( '#__joomleague_jltable_fields', 'id', $db );
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
		/*
    if ( ! (( $this->event_type_id && $this->projectteam_id) || ( $this->notes && $this->event_sum)))
		{
			$this->setError( JText::_( 'CHECK FAILED' ) );
			return false;
		}
    */
		return true;
	}
}
?>