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
class JoomleagueControllerjlextuserfield extends JoomleagueCommonController
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


function newField()	
{
JRequest::setVar('hidemainmenu',0);
JRequest::setVar('layout','formfield');
JRequest::setVar('view','jlextuserfield');
JRequest::setVar('edit',true);
JRequest::setVar('new',true);

parent::display();

}

function editField()	
{
JRequest::setVar('hidemainmenu',0);
JRequest::setVar('layout','formfield');
JRequest::setVar('view','jlextuserfield');
JRequest::setVar('edit',true);
JRequest::setVar('new',false);

parent::display();

}

function removeField()
	{
		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger( $cid );
    $jltableid = JRequest::getInt( "jltableid", 0 );
    
		if ( count( $cid ) < 1 )
		{
			JError::raiseError( 500, JText::_( 'JL_GLOBAL_SELECT_TO_DELETE' ) );
		}

		$model = $this->getModel( 'jlextuserfield' );

		if ( !$model->delete( $cid ) )
		{
			echo "<script> alert('" . $model->getError(true) . "'); window.history.go(-1); </script>\n";
		}
    else
    {
    JError::raiseNotice( 500, JText::_( 'JL_GLOBAL_SELECT_DELETE' ) );
    }
		$this->setRedirect( 'index.php?option=com_joomleague&controller=jlextuserfields&view=jlextuserfields&jltableid='.$jltableid );
	}
	
function save()	
{
// Check for request forgeries
		JRequest::checkToken() or die( 'JL_GLOBAL_INVALID_TOKEN' );
    $jltableid = JRequest::getInt( "jltableid", 0 );
		$post	= JRequest::get( 'post' );
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];
    
    
		$model = $this->getModel( 'jlextuserfield' );

		if ( $model->store( $post ) )
		{
		  $insertid = $model->_db->insertid();
		  
		  $row_field =& JTable::getInstance('jlextuserfield', 'Table');
      $row_field->load($insertid);
      $row_table =& JTable::getInstance('jltabletables', 'Table');
      $row_table->load($jltableid);
      $model->createColumn( $row_table->tablename, $row_field->fieldname, $row_field->fieldtype.'('.$row_field->fieldlengh.')'  );
			$msg = JText::_( 'JL_ADMIN_USER_FIELDS_CTRL_SAVED' ).' '.$insertid;

		}
		else
		{
			$msg = JText::_( 'JL_ADMIN_USER_FIELDS_CTRL_ERROR_SAVE' ) . $model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();

		if ( $this->getTask() == 'save' )
		{
			$link = 'index.php?option=com_joomleague&controller=jlextuserfields&view=jlextuserfields&jltableid='.$jltableid;
		}
		else
		{
			//$link = 'index.php?option=com_joomleague&controller=jlextuserfields&task=editField&cid[]=' . $post['id'];
			$link = 'index.php?option=com_joomleague&controller=jlextuserfields&view=jlextuserfields&jltableid='.$jltableid;
		}

		$this->setRedirect( $link, $msg );



}

function apply()	
{
// Check for request forgeries
		JRequest::checkToken() or die( 'JL_GLOBAL_INVALID_TOKEN' );
    $jltableid = JRequest::getInt( "jltableid", 0 );
		$post	= JRequest::get( 'post' );
		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];
    
    
		$model = $this->getModel( 'jlextuserfield' );

		if ( $model->store( $post ) )
		{
		  $row_field =& JTable::getInstance('jlextuserfield', 'Table');
      $row_field->load( $post['id'] );
      $row_table =& JTable::getInstance('jltabletables', 'Table');
      $row_table->load($jltableid);
      $model->updateColumn( $row_table->tablename, $row_field->fieldname, $row_field->fieldtype.'('.$row_field->fieldlengh.')'  );
      
			$msg = JText::_( 'JL_ADMIN_USER_FIELDS_CTRL_SAVED' );

		}
		else
		{
			$msg = JText::_( 'JL_ADMIN_USER_FIELDS_CTRL_ERROR_SAVE' ) . $model->getError();
		}

		// Check the table in so it can be edited.... we are done with it anyway
		$model->checkin();

		if ( $this->getTask() == 'save' )
		{
			$link = 'index.php?option=com_joomleague&controller=jlextuserfields&view=jlextuserfields&jltableid='.$jltableid;
		}
		else
		{
			//$link = 'index.php?option=com_joomleague&controller=jlextuserfields&task=editField&cid[]=' . $post['id'];
			$link = 'index.php?option=com_joomleague&controller=jlextuserfields&view=jlextuserfields&jltableid='.$jltableid;
		}

		$this->setRedirect( $link, $msg );



}  



}

?>