<?php
/**
 * @copyright	Copyright (C) 2006-2012 JoomLeague.net. All rights reserved.
 * @license		GNU/GPL,see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License,and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * Joomleague Component Item Model
 *
 * @author Julien Vonthron <julien.vonthron@gmail.com>
 * @package   Joomleague
 * @since 0.1
 */
if(!class_exists('JoomleagueModelItem')) {
class JoomleagueModelItem extends JModel
{
	/**
	 * item id
	 *
	 * @var int
	 */
	var $_id=null;

	/**
	 * Project data
	 *
	 * @var array
	 */
	var $_data=null;

	/**
	 * cache for project data
	 * @var object
	 */
	var $_project=null;

	/**
	 * Constructor
	 *
	 * @since 0.1
	 */
	function __construct()
	{
		parent::__construct();

		$array=JRequest::getVar('cid',array(0),'','array');
		$edit=JRequest::getVar('edit',true);
		if($edit){$this->setId((int)$array[0]);}
	}

	/**
	 * Method to set the item identifier
	 *
	 * @access	public
	 * @param	int item identifier
	 */
	function setId($id)
	{
		// Set item id and wipe data
		$this->_id=$id;
		$this->_data=null;
	}

	/**
	 * Method to get an item
	 *
	 * @since 0.1
	 */
	function &getData()
	{
		// Load the item data
		if (!$this->_loadData()){$this->_initData();}
		return $this->_data;
	}

	/**
	 * Tests if item is checked out
	 *
	 * @access	public
	 * @param	int	A user id
	 * @return	boolean	True if checked out
	 * @since	0.1
	 */
	function isCheckedOut($uid=0)
	{
		if ($this->_loadData())
		{
			if ($uid){return ($this->_data->checked_out && $this->_data->checked_out != $uid);}
			return $this->_data->checked_out;
		}
	}

	/**
	 * Method to checkin/unlock the item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function checkin()
	{
		if ($this->_id)
		{
			$project =& $this->getTable();
			if (! $project->checkin($this->_id))
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return false;
	}

	/**
	 * Method to checkout/lock the item
	 *
	 * @access	public
	 * @param	int	$uid	User ID of the user checking the item out
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function checkout($uid=null)
	{
		if ($this->_id)
		{
			// Make sure we have a user id to checkout the article with
			if (is_null($uid))
			{
				$user =& JFactory::getUser();
				$uid=$user->get('id');
			}
			// Lets get to it and checkout the thing...
			$project =& $this->getTable();
			if (!$project->checkout($uid,$this->_id))
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * Method to store the item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data,$table='')
	{
		if ($table=='')
		{
			$row =& $this->getTable();
		}
		else
		{
			$row =& JTable::getInstance($table,'Table');
		}

		// Bind the form fields to the items table
		if (!$row->bind($data))
		{
			$this->setError(JText::_('JL_ADMIN_ITEM_MODEL_ERROR_BIND'));
			return false;
		}

		// Create the timestamp for the date
		$row->checked_out_time=gmdate('Y-m-d H:i:s');

		// if new item,order last,but only if an ordering exist
		if ((isset($row->id)) && (isset($row->ordering)))
		{
			if (!$row->id && $row->ordering!=NULL)
			{
				$row->ordering=$row->getNextOrder();
			}
		}

		// Make sure the item is valid
		if (!$row->check())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		// Store the item to the database
		if (!$row->store())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return $row->id;
	}

	/**
	 * Method to move an item
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function move($direction)
	{
		$row =& $this->getTable();
		if (!$row->load($this->_id))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if (!$row->move($direction))
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

	/**
	 * Method to save item order
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveorder($cid=array(),$order)
	{
		$row =& $this->getTable();
		// update ordering values
		for ($i=0; $i < count($cid); $i++)
		{
			$row->load((int) $cid[$i]);
			if ($row->ordering != $order[$i])
			{
				$row->ordering=$order[$i];
				if (!$row->store())
				{
					$this->setError($this->_db->getErrorMsg());
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * Return project data
	 * @param int id,default to selected project (stored in session)
	 * @return object
	 */
	function getProject($id=0)
	{
		$option='com_joomleague';
		$mainframe=&JFactory::getApplication();
		if (!$id) {
			$id=$mainframe->getUserState($option.'project',0);
		}

		if (empty($this->_project) || $id != $this->_project->id)
		{
			$query='SELECT * FROM #__joomleague_project WHERE id='.$this->_db->Quote($id);
			$this->_db->setQuery($query,0,1);
			$this->_project=$this->_db->loadObject();
		}
		return $this->_project;
	}

	/**
	 * Method to export one or more leagues
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5.0a
	 */
	function export($cid=array(),$table, $record_name)
	{
		if (count($cid))
		{
			$mdlJLXExports = JModel::getInstance("jlxmlexports", 'JoomleagueModel');
			JArrayHelper::toInteger($cid);
			$cids=implode(',',$cid);
			$query="SELECT * FROM #__joomleague_".$table." WHERE id IN ($cids)";
			$this->_db->setQuery($query);
			$exportData=$this->_db->loadObjectList();
			$output="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
			// open the clubs
			$output .= "<".$table."s>\n";
			// get the version of JoomLeague
			$output .= $mdlJLXExports->_addToXml($mdlJLXExports->_getJoomLeagueVersion());
			$tabVar='  ';
			$record_name=$record_name;
			foreach ($exportData as $name=>$value)
			{
				$output .= "<record object=\"".JoomleagueHelper::stripInvalidXml($record_name)."\">\n";
				foreach ($value as $name2=>$value2)
				{
					if (($name2!='checked_out') && ($name2!='checked_out_time'))
					{
						$output .= $tabVar.'<'.$name2.'><![CDATA['.JoomleagueHelper::stripInvalidXml(trim($value2)).']]></'.$name2.">\n";
						#echo "<pre>".$name2."#".$value2."<br /></pre>";
					}
				}
				$output .= "</record>\n";
			}
			unset($name,$value);
			// close leagues
			$output .= '</'.$table.'s>';
			
			$mdlJLXExports->downloadXml($output, $table);
			
			// close the application
			$app =& JFactory::getApplication();
			$app->close();
		}
	}
	
	function publishorig($pks=array(),$value=1)
	{
		$user 				=& JFactory::getUser();
		$datenow			=& JFactory::getDate();
		$table				= $this->getTable();
		$table->modified	= $datenow->toMySQL();
		$table->modified_by = $user->get('id');
		// Attempt to change the state of the records.
		if (!$table->publish($pks, $value, $user->get('id'))) {
			$this->setError($table->getError());
			return false;
		}
		return true;
	}
	
	/**
	 * Generic Publish/Unpublish function
	 *
	 * @access public
	 * @param array An array of id numbers
	 * @param integer 0 if unpublishing, 1 if publishing
	 * @param integer The id of the user performnig the operation
	 * @since 1.0.4
	 */
	function publish( $cid=null, $publish=1, $user_id=0 )
	{
		JArrayHelper::toInteger( $cid );
		if($user_id==0) {
			$user		=& JFactory::getUser();
			$user_id	= (int) $user->get('id');
		}
		$publish	= (int) $publish;
		$table		= $this->getTable();
		$k			= $table->_tbl_key;
		$datenow =& JFactory::getDate();
		
		if (count( $cid ) < 1)
		{
			if ($table->$k) {
				$cid = array( $table->$k );
			} else {
				$this->setError("No items selected.");
				return false;
			}
		}

		$cids = $k . '=' . implode( ' OR ' . $k . '=', $cid );
		
		/*
		 if(!in_array( 'modified', $this->_db->getTableFields($table->_tbl))) {
			$query_add = 'ALTER TABLE ' . $table->_tbl . ' ADD `modified` DATETIME NULL';
			$this->_db->setQuery( $query_add );
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		if(!in_array( 'modified_by', $this->_db->getTableFields($table->_tbl))) {
			$query_add = 'ALTER TABLE ' . $table->_tbl . ' ADD `modified_by` INT NULL';
			$this->_db->setQuery( $query_add );
			if (!$this->_db->query())
			{
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		*/
				
		$query = 'UPDATE '. $table->_tbl;
		$query .= ' SET published = ' . (int) $publish;
		$query .= ' , modified = ' . $this->_db->Quote($datenow->toMySQL()) ;
		$query .= ' , modified_by = ' . (int) $user_id;
		$query .= ' WHERE ('.$cids.')';
		

		$checkin = in_array( 'checked_out', array_keys($table->getProperties()) );
		if ($checkin)
		{
			$query .= ' AND (checked_out = 0 OR checked_out = '.(int) $user_id.')';
		}

		$this->_db->setQuery( $query );
		if (!$this->_db->query())
		{
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		if (count( $cid ) == 1 && $checkin)
		{
			if ($table->_db->getAffectedRows() == 1) {
				$table->checkin( $cid[0] );
				if ($table->$k == $cid[0]) {
					$table->published = $publish;
				}
			}
		}
		$this->setError('');
		return true;
	}
	
} 
}
?>