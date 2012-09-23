<?php
/**
* @version		$Id: templatelist.php 470 2010-01-31 19:38:29Z And_One $
* @package		Joomla.Framework
* @subpackage	Parameter
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a filelist element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementTemplatelist extends JElement
{
	/**
	* Element name
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = 'Templatelist';

	function fetchElement($name, $value, &$node, $control_name)
	{
		jimport( 'joomla.filesystem.folder' );

		// path to images directory
		$path		= JPATH_ROOT.DS.$node->attributes('directory');
		$filter		= $node->attributes('filter');
		$exclude	= $node->attributes('exclude');
		$folders	= JFolder::folders($path, $filter);

		$options = array ();
		foreach ($folders as $folder)
		{
			if ($exclude)
			{
				if (preg_match( chr( 1 ) . $exclude . chr( 1 ), $folder )) {
					continue;
				}
			}
			$options[] = JHTML::_('select.option', $folder, $folder);
		}

		if (!$node->attributes('hide_none')) {
			array_unshift($options, JHTML::_('select.option', '-1', '- '.JText::_('Do not use').' -'));
		}

		if (!$node->attributes('hide_default')) {
			array_unshift($options, JHTML::_('select.option', '', '- '.JText::_('Use default').' -'));
		}
		$doc = &JFactory::getDocument();
		$doc->addScriptDeclaration('
  function getPosition(element) 
{
    var pos = { y: 0, x: 0 };

    if(element)
    {
         var elem=element;
         while(elem && elem.tagName.toUpperCase() != \'BODY\')
         {
              pos.y += elem.offsetTop;
              pos.x += elem.offsetLeft;
              elem = elem.offsetParent;
         }
    }
    return pos;
}

function scrollToPosition(elementId) 
{
    var a,element,dynPos;
    element = $(elementId);
    a = getPosition(element);
    dynPos = a.y;
    window.scroll(a.x,dynPos);
  
}  
  ');
global $mainframe;
		$select = '<table><tr><td>'.JHTML::_('select.genericlist',  $options, ''
		.$control_name.'['.$name.']', 'class="inputbox" onchange="$(\'TemplateBild\').src=\''.$mainframe->getCfg('live_site').'/modules/mod_joomleague_nextmatch_ext/tmpl/\'+this.options[this.selectedIndex].value+\'/template.png\';"', 'value', 'text', $value, $control_name.$name);
		$select .= '<br /><br />'.JText::_($node->attributes('details')).'</td><td style="text-align:right;background-color:grey;padding:4px;margin:20px;width:200px;height:150px;">
		'.JHTML::_('image','modules/mod_joomleague_nextmatch_ext/tmpl/'.$value.'/template.png', 'TemplateBild', 'id="TemplateBild" width="200"').'
		</td></tr></table>';
		return $select;
	}
}
 