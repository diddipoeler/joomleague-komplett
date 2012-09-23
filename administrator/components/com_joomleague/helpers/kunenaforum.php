<?php

/**
 * @version		
 * @package		Joomleague
 * @subpackage	
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

//jimport('joomla.application.component.model');
//require_once (JPATH_COMPONENT.DS.'models'.DS.'item.php');

/**
 * @package		Joomla
 * @subpackage	Installation
 */
class JLKunenaForum
{

function getKunenaForum()
  {
  global $mainframe, $option;
  $mainframe	=& JFactory::getApplication();
  $db =& JFactory::getDBO();
  
  $query = "SELECT id
from #__components
where name like 'COM_KUNENA' ";

$db->setQuery( $query );
if ( $forumid = $db->loadResult() )
{
$mainframe->enqueueMessage(JText::_('JL_ADMIN_PROJECT_FORUM_EXIST_KUNENA_YES'),'');
return true;
}
else
{
$mainframe->enqueueMessage(JText::_('JL_ADMIN_PROJECT_FORUM_EXIST_KUNENA_NO'),'Error');
return false;
}

  
  }

function getKunenaCategories($sb_catid)
  {
  $db =& JFactory::getDBO();
  $sizelist = 1;  	
// 	echo '<pre>';
// 	print_r($children);
// 	echo '</pre>';
	$db->setQuery ( "SELECT a.id, a.name FROM #__kunena_categories AS a WHERE parent='0'  ORDER BY ordering" );
	$sections = $db->loadObjectList ();
  $categoryparent = empty($sections) ? 0 : $sections[0]->id;
  $catList = array();
	$catList[] = JHTML::_('select.option', 0, JText::_('COM_KUNENA_TOPLEVEL'));
	$categoryList = JLKunenaForum::KSelectList('sb_catid', $catList, 'class="inputbox" ', true, 'sb_catid', $sb_catid);
  
// 	echo 'getKunenaCategories<pre>';
// 	print_r($categoryList);
// 	echo '</pre>';
  
  return $categoryList;
  
  }
  
function KSelectList($name, $options=array(), $attr='', $sections=false, $id='', $selected=0) 
  {
  
		//$kunena_db = &JFactory::getDBO ();
		$list = JLKunenaForum::JJ_categoryArray ();

		$preoptions = count($options);
		foreach ( $list as $item ) 
    {
			if (!$preoptions && !$selected && ($sections || !$item->section)) 
      {
				$selected = $item->id;
			}
			$options [] = JHTML::_ ( 'select.option', $item->id, $item->treename, 'value', 'text', !$sections && $item->section);
		}

		if (!$id) $id = $name;
    $attr .= ' size="'.sizeof($options).'"';
		$catsList = JHTML::_ ( 'select.genericlist', $options, $name, $attr, 'value', 'text', $selected, $id );
		
//   echo 'KSelectList<pre>';
// 	print_r($catsList);
// 	echo '</pre>';
	
    return $catsList;
	}

function JJ_categoryArray($admin=0) 
  {
  $db =& JFactory::getDBO();

    // get a list of the menu items
	$query = "SELECT * FROM #__kunena_categories";

    $query .= " ORDER BY ordering, name";
    $db->setQuery($query);
    $items = $db->loadObjectList();

    // establish the hierarchy of the menu
    $children = array ();

    // first pass - collect children
    foreach ($items as $v) 
    {
        $pt = $v->parent;
        $list = isset($children[$pt]) ? $children[$pt] : array ();
        array_push($list, $v);
        $children[$pt] = $list;
        }

    // second pass - get an indent list of the items
    $array = JLKunenaForum::fbTreeRecurse(0, '', array (), $children, 10, 0, 1);
    
//   echo 'JJ_categoryArray<pre>';
// 	print_r($array);
// 	echo '</pre>';
	
    return $array;
    }
    
function fbTreeRecurse( $id, $indent, $list, &$children, $maxlevel=9999, $level=0, $type=1 ) 
    {

    if (isset($children[$id]) && $level <= $maxlevel) {
        foreach ($children[$id] as $v) {
            $id = $v->id;
			if (KUNENA_JOOMLA_COMPAT >= '1.6') {
				$pre     = '- ';
				$spacer = '- ';
			} elseif ( $type ) {
                $pre     = '&nbsp;';
                $spacer = '...';
            } else {
                $pre     = '- ';
                $spacer = '&nbsp;&nbsp;';
            }

            if ( $v->parent == 0 ) {
                $txt     = JLKunenaForum::kunena_htmlspecialchars($v->name);
            } else {
                $txt     = $pre . JLKunenaForum::kunena_htmlspecialchars($v->name);
            }
            $pt = $v->parent;
            $list[$id] = $v;
            $list[$id]->treename = $indent . $txt;
            $list[$id]->children = !empty($children[$id]) ? count( $children[$id] ) : 0;
            $list[$id]->section = ($v->parent==0);

            $list = JLKunenaForum::fbTreeRecurse( $id, $indent . $spacer, $list, $children, $maxlevel, $level+1, $type );
        }
    }
    return $list;
}

function kunena_htmlspecialchars($string, $quote_style=ENT_COMPAT, $charset='UTF-8') 
  {
	return htmlspecialchars($string, $quote_style, $charset);
}  

          
  
}

?>