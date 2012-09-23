<?php 
/**
* @copyright	Copyright (C) 2007-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

defined( '_JEXEC' ) or die( 'Restricted access' ); // Check to ensure this file is included in Joomla!

JHTML::_( 'behavior.mootools' );
/**
 * Renders a Dynamic SQL element
 *
 * @package Joomleague
 * @subpackageParameter
 * @since1.5
 */

class JElementJLSQL extends JElement
{
	/**
	 * Element name
	 *
	 * @accessprotected
	 * @varstring
	 */
	var $_name = 'JLSQL';

	function fetchElement($name, $value, &$node, $control_name)
	{
		$db =& JFactory::getDBO();
		$db->setQuery($node->attributes('query'));
		$key = ($node->attributes('key_field') ? $node->attributes('key_field') : 'value');
		$val = ($node->attributes('value_field') ? $node->attributes('value_field') : $name);
		$doc =& JFactory::getDocument();
		$updates = $node->attributes('updates');
		$depends = $node->attributes('depends');
		if($updates){
			$view = $node->attributes('rawview');
			$doc->addScriptDeclaration("function update_".$updates."()
			{
				$('".$control_name.$updates."').onclick = function () { return false;};
				var combo = $('".$control_name.$name."');
				var value = combo.options[combo.selectedIndex].value;
				var postStr  = '';
				var url = '".JURI::base()."' + 'index.php?option=com_joomleague&view=".$view."&format=raw&".$name."='+value;
				var theAjax = new Ajax(url, {
					method: 'post',
					postBody : postStr
					});
				theAjax.addEvent('onSuccess', function(html) {
					var comboToUpdate = $('".$control_name.$updates."');
					var previousValue = comboToUpdate.selectedIndex>0 ? comboToUpdate.options[comboToUpdate.selectedIndex].value : -1;
					var msie = navigator.userAgent.toLowerCase().match(/msie\s+(\d)/);
					if(msie) {
						comboToUpdate.empty();
						comboToUpdate.outerHTML='<SELECT id=\"".$control_name.$updates."\" name=\"".$control_name."[".$updates."]\">'+html+'</SELECT>';
					}
					else {
						comboToUpdate.empty().setHTML(html);
					}
					if(previousValue!=-1){
						for (var i=0; i<comboToUpdate.options.length;i++) {
			 				if (comboToUpdate.options[i].value==previousValue) {
								comboToUpdate.selectedIndex = i;
								break;
			 				}
		  				}
	  				}
				});
				theAjax.request();
			}");
		}
		$html = JHTML::_('select.genericlist',  $db->loadObjectList(), ''.$control_name.'['.$name.']', 'class="inputbox"'.($updates ? ' onchange="javascript:update_'.$updates.'()"' : '').($depends ? ' onclick="javascript:update_'.$name.'()"' : ''), $key, $val, $value, $control_name.$name);
		return $html;
	}
}
