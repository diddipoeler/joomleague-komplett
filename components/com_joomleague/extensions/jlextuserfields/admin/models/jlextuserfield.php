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
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
require_once (JPATH_COMPONENT.DS.'models'.DS.'item.php');

/**
 * Joomleague Component 
 *
 * @author	Marco Vaninetti <martizva@libero.it>
 * @package	JoomLeague
 * @
 */
class JoomleagueModeljlextuserfield extends JoomleagueModelItem
{

/**
	 * Method to load content
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = 'SELECT * FROM #__joomleague_jltable_fields WHERE id='.(int)$this->_id;
			$this->_db->setQuery($query);
			$this->_data=$this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}
	
/**
	 * Method to initialise
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
		  $jltableid = JRequest::getInt( "jltableid", 0 );
      $table = 'JLTableTables';
      $jltablerow =& JTable::getInstance( $table, 'Table' );
      $jltablerow->load($jltableid);
      
			$userfields=new stdClass();
			$userfields->id			 = 0;
			$userfields->tablename	 = $jltablerow->tablename;
			$userfields->fieldname	 = null;
			$userfields->fieldtype		 = 0;
			$userfields->fieldnull			 = null;
			$userfields->fieldkey	 = null;
			$userfields->fielddefault		 = null;

			$userfields->fieldextra	 = 0;
			$userfields->userfield		 = 1;

			$userfields->ordering	 = 0;
			$userfields->fieldlengh = 0;
			$userfields->visible		 = null;
			$userfields->description		= null;
			$userfields->checked_out	= null;
			$this->_data			 = $userfields;
			return (boolean) $this->_data;
		}
		return true;
	}	

  /**
	 * Method to remove 
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	0.1
	 */
	function delete( $cid=array() )
	{
		if (count($cid))
		{
		$jltableid = JRequest::getInt( "jltableid", 0 );
		$table = 'JLTableTables';
    $jltablerow =& JTable::getInstance( $table, 'Table' );
    $jltablerow->load($jltableid);


			JArrayHelper::toInteger($cid);
			$cids=implode(',', $cid);
			
			/*
      $query="UPDATE #__joomleague_project_team SET division_id=0 WHERE division_id IN ($cids)";
			$this->_db->setQuery($query);
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			$query="UPDATE #__joomleague_treeto SET division_id=0 WHERE division_id IN ($cids)";
			$this->_db->setQuery($query);
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			*/
			
			$query="DELETE FROM #__joomleague_jltable_fields WHERE id IN ($cids)";
			$this->_db->setQuery($query);
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}
	
function createColumn( $table, $column, $type) 
{
		global $acl, $migrate;
		$mainframe	=& JFactory::getApplication();
		//$database = &JFactory::getDBO();
		$ck_obj = NULL;
		$sql="SELECT * FROM `".$table."` LIMIT 1";
		$this->_db->setQuery($sql);
		if ($this->_db->loadObject($ck_obj) && array_key_exists($column, $ck_obj)) 
    {
			return $this->updateColumn( $table, $column, $type);
		} 
    else 
    {
			$sql="ALTER TABLE `$table` ADD `$column` $type";
			$this->_db->SetQuery($sql);
			$ret = $this->_db->query();
			if( !$ret ) 
      {
				$this->_error .= get_class( $this )."::createColumn failed <br />" . $this->_db->getErrorMsg();
				$mainframe->enqueueMessage('createColumn<pre>'.print_r($this->_db->getErrorMsg(),true).'</pre><br>','Error');
        return false;
			} 
      else 
      {
        $mainframe->enqueueMessage(JText::_('JL_ADMIN_USER_FIELDS_CREATE_FIELD'),'Notice');
				return true;
			}
		}
	}
	
function deleteColumn( $table, $column) 
{
		global $acl, $migrate, $database;
		$mainframe	=& JFactory::getApplication();
		//$database = &JFactory::getDBO();

		$sql="ALTER TABLE `$table` DROP `$column`";
		$this->_db->SetQuery($sql);
		$ret = $this->_db->LoadResult();
		if( !$ret ) 
    {
			$this->_error .= get_class( $this )."::deleteColumn failed <br />" . $this->_db->getErrorMsg();
			return false;
		} 
    else 
    {
      $mainframe->enqueueMessage(JText::_('JL_ADMIN_USER_FIELDS_DELETE_FIELD'),'Notice');
			return true;
		}
	}
	
function updateColumn( $table, $column, $type) 
{
		global $acl, $migrate, $database;
		$mainframe	=& JFactory::getApplication();
		//$database = &JFactory::getDBO();

    
			
		$sql="ALTER TABLE `".$table."` CHANGE `".$column."` `".$column."` ".$type;
		$this->_db->setQuery($sql);
		$ret = $this->_db->query();
		if( !$ret ) 
    {
			$this->_error .= get_class( $this )."::updateColumn failed <br />" . $this->_db->getErrorMsg();
			$mainframe->enqueueMessage('updateColumn<pre>'.print_r($this->_db->getErrorMsg(),true).'</pre><br>','Error');
      return false;
		} 
    else 
    {
      $mainframe->enqueueMessage(JText::_('JL_ADMIN_USER_FIELDS_UPDATE_FIELD'),'Notice');
			return true;
		}
	}  	  	

}

?>