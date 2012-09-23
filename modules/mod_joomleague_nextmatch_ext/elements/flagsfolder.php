<?php

defined('_JEXEC') or die('Restricted access');
jimport( 'joomla.filesystem.folder' );
class JElementFlagsFolder extends JElement
{

	var	$_name = 'flagsfolder';

	function fetchElement($name, $value, &$node, $control_name){

    $folderlist1 	= JFolder::folders(JPATH_ROOT.DS.'images', '', true, true, array(0=>'system'));
    $folderlist2 	= JFolder::folders(JPATH_ROOT.DS.'media', '', true, true, array(0=>'system'));
    $folderlist = array();
    foreach($folderlist1 AS $key=>$val) $folderlist[] = str_replace(JPATH_ROOT.DS, '', $val);
    foreach($folderlist2 AS $key=>$val) $folderlist[] = str_replace(JPATH_ROOT.DS, '', $val);
		$items = array(JHTML::_('select.option',  '', '- '.JText::_('Do not use').' -' ));

		foreach ( $folderlist as $folder ) {
			$items[] = JHTML::_('select.option',  $folder, '&nbsp;'.$folder );
		}
		

		$output= JHTML::_('select.genericlist',  $items, ''.$control_name.'['.$name.']', 'class="inputbox"', 'value', 'text', $value );
		return $output;
	}
}
 