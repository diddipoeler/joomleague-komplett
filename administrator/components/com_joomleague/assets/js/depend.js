/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license	GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/**
 * javascript for dependant element xml parameter
 * 
 * 
 */
	// add update of field when fields it depends on change.
	window.addEvent('domready', function() {
		$$('.depend').each(function(element){
			var depends = element.getProperty('depends');
			var myelement = element;
			depends.split(',').each(function(el){
				$E('select[id$=params'+el+']').addEvent('change', function(event){
					update_depend(myelement);
				});				
			});

			update_depend(myelement);
		});
		
		$$('.mdepend').addEvent('click', function() {
			// rebuild hidden field list
			var sel = new Array();
			var i = 0;
			this.getElements('option').each(function(el){
				if (el.getProperty('selected')) {
					sel[i++] = el.value;
				}
			});
			this.getParent().getElement('input').value = sel.join("|");
		}).fireEvent('click');
	});
	
	// update dependant element function
	function update_depend(element)
	{
		var combo = element;
		var value = combo.getProperty('current');
		var depends = combo.getProperty('depends').split(',');
		var dependquery = '';
		depends.each(function(str){
			dependquery += '&'+str+'='+$E('select[id$=params'+str+']').value;
		});

		var task = combo.getProperty('task');
		var postStr  = '';
		var url = 'index.php?option=com_joomleague&controller=ajax&task='+task+dependquery;
		var theAjax = new Ajax(url, {
			method: 'post',
			postBody : postStr
			});
		theAjax.addEvent('onSuccess', function(response) {
			var options = eval('(' + response + ')'); 
			if (combo.getProperty('isrequired') == 0) { // first option is 'select', keep it
				options.unshift(combo.options[0]);
			}
			combo.empty();
			options.each(function(el){
				var re = new RegExp(el.value);
				if (value != null && value.match(re)) {
					new Element('option', {value:el.value, selected:'selected'}).setText(el.text).injectInside(combo);
				}
				else {
					new Element('option', {value:el.value}).setText(el.text).injectInside(combo);
				}
			});
			combo.fireEvent('click');
		});
		theAjax.request();
	}