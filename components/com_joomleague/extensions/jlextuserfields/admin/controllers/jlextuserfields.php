<?php
/**
* @copyright	Copyright (C) 2005-2010 JoomLeague.de. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller' );
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.archive');
require_once ( JPATH_COMPONENT . DS . 'controllers' . DS . 'joomleague.php' );


/**
 * Joomleague Component 
 *
 * @author	Dieter Plöger
 * @package	Joomleague
 * @since	1.5.0a
 */
class JoomleagueControllerjlextuserfields extends JoomleagueCommonController
{

function __construct()
    {
        parent::__construct();
//         $this->registerTask( 'save' , 'Save' );
//         $this->registerTask( 'apply' , 'Apply' );
//         $this->registerTask( 'cancel' , 'Close' );
//         $this->registerTask('edit','display');
//         $this->registerTask('insert','display');
//         $this->registerTask('selectpage','display');
    }

function createColumn( $table, $column, $type) {
		global $acl, $migrate;
		$database = &JFactory::getDBO();
		$ck_obj = NULL;
		$sql="SELECT * FROM `".$table."` LIMIT 1";
		$database->setQuery($sql);
		if ($database->loadObject($ck_obj) && array_key_exists($column, $ck_obj)) {
			return $this->updateColumn( $table, $column, $type);
		} else {
			$sql="ALTER TABLE `$table` ADD `$column` $type";
			$database->SetQuery($sql);
			$ret = $database->query();
			if( !$ret ) {
				$this->_error .= get_class( $this )."::createColumn failed <br />" . $this->_db->getErrorMsg();
				return false;
			} else {
				return true;
			}
		}
	}
	
function deleteColumn( $table, $column) {
		global $acl, $migrate, $database;
		$database = &JFactory::getDBO();

		$sql="ALTER TABLE `$table` DROP `$column`";
		$database->SetQuery($sql);
		$ret = $database->LoadResult();
		if( !$ret ) {
			$this->_error .= get_class( $this )."::deleteColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}
  
function updateColumn( $table, $column, $type) {
		global $acl, $migrate, $database;
		$database = &JFactory::getDBO();

		$sql="ALTER TABLE `".$table."` CHANGE `".$column."` `".$column."` ".$type;
		$database->setQuery($sql);
		$ret = $database->query();
		if( !$ret ) {
			$this->_error .= get_class( $this )."::updateColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} else {
			return true;
		}
	}  	


}

?>