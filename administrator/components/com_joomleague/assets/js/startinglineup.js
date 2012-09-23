/**
* @copyright	Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
	window.addEvent('domready', function() {
		$ES('input.move-right').addEvent('click', function() {
			$('changes_check').value=1;
			var posid = this.id.substr(10);
			move($('roster'), $('position'+posid));
		});

		$ES('input.move-left').addEvent('click', function() {
			$('changes_check').value=1;
			var posid = this.id.substr(9);
			move($('position'+posid),$('roster'));
		});

		$ES('input.move-up').addEvent('click', function() {
			$('changes_check').value=1;
			var posid = this.id.substr(7);
			moveOptionUp('position'+posid);
		});

		$ES('input.move-down').addEvent('click', function() {
			$('changes_check').value=1;
			var posid = this.id.substr(9);
			moveOptionDown('position'+posid);
		});

		// staff
		$ES('input.smove-right').addEvent('click', function() {
			$('changes_check').value=1;
			var posid = this.id.substr(11);
			move($('staff'), $('staffposition'+posid));
		});

		$ES('input.smove-left').addEvent('click', function() {
			$('changes_check').value=1;
			var posid = this.id.substr(10);
			move($('staffposition'+posid),$('staff'));
		});

		$ES('input.smove-up').addEvent('click', function() {
			$('changes_check').value=1;
			var posid = this.id.substr(8);
			moveOptionUp('staffposition'+posid);
		});

		$ES('input.smove-down').addEvent('click', function() {
			$('changes_check').value=1;
			var posid = this.id.substr(10);
			moveOptionDown('staffposition'+posid);
		});

		if(document.startingSquadsForm) {
			// on submit select all elements of select lists
			$('startingSquadsForm').addEvent('submit', function(event) {
				$ES('select.position-starters').each( function(element) {
					selectAll(element);
				});

				$ES('select.position-staff').each( function(element) {
					selectAll(element);
				});
			});
		}
		// ajax save substitution
		$ES('input.button-save').addEvent('click', function() {
			var url = baseajaxurl+'&task=savesubst';
			var rowid = this.id.substr(5);
			var playerin = $('in').value;
			var playerout = $('out').value;
			var position = $('project_position_id').value;
			var time = $('in_out_time').value;
			if (playerin != 0 || playerout != 0) {
				var myXhr = new XHR(
										{
										method: 'post',
										onRequest: substRequest,
										onSuccess: substSaved,
										onFailure: substFailed,
										rowid: rowid
										}
				);
				var querystring = 'in='+playerin
												 +'&out='+playerout
												 +'&project_position_id='+position
												 +'&in_out_time='+time
												 +'&teamid='+teamid
												 +'&matchid='+matchid;
				myXhr.send(url, querystring);
			}
			//alert('in: '+playerin+' / out: '+playerout);
		});
		// ajax remove substitution
		$ES('input.button-delete').addEvent('click', deletesubst);

	});

	function substRequest()
	{
		$('ajaxresponse').addClass('ajax-loading');
		$('ajaxresponse').setText('');
	}

	function deletesubst()
	{
		var substid = this.id.substr(7);
		//alert('remove '+substid);
		var url = baseajaxurl+'&task=removeSubst';
		if (substid) {
			var myXhr = new XHR(
									{
									method: 'post',
									onRequest: substRequest,
									onSuccess: substRemoved,
									onFailure: substFailed,
									substid: substid
									}
			);
			var querystring = 'substid='+substid;
			myXhr.send(url, querystring);
		}
	}

	function substSaved(response)
	{
		$('ajaxresponse').removeClass('ajax-loading');
		var currentrow = $('row-'+this.options.rowid);
		// first line contains the status, second line contains the new row.
		var resp = response.split("\n");
		if (resp[0] != '0') {
			// create new row in substitutions table
			var newrow = new Element('tr', {id:'sub-'+resp[0]});
			new Element('td').setText($('out').options[$('out').selectedIndex].text).injectInside(newrow);
			new Element('td').setText($('in').options[$('in').selectedIndex].text).injectInside(newrow);
			new Element('td').setText($('project_position_id').options[$('project_position_id').selectedIndex].text).injectInside(newrow);
			new Element('td').setText($('in_out_time').value).injectInside(newrow);
			var deletebutton = new Element('input', {id:'delete-'+resp[0], type:'button', value:str_delete}).addClass('inputbox button-delete').addEvent('click', deletesubst);
			var td = new Element('td').appendChild(deletebutton).injectInside(newrow);
			newrow.injectBefore(currentrow);
			$('ajaxresponse').setText('Saved');
		}
		else {
			$('ajaxresponse').setText(resp[1]);
		}
	}

	function substFailed()
	{
		$('ajaxresponse').removeClass('ajax-loading');
		$('ajaxresponse').setText(response);
	}

	function substRemoved(response)
	{
		var resp = response.split("\n");
		if (resp[0] != '0') {
			var currentrow = $('sub-'+this.options.substid);
			currentrow.remove();
		}

		$('ajaxresponse').removeClass('ajax-loading');
		$('ajaxresponse').setText(resp[1]);
	}


	function move(fbox, tbox) {
			 var arrFbox = new Array();
			 var arrTbox = new Array();
			 var arrLookup = new Array();
			 var i;
			 for(i=0; i<tbox.options.length; i++) {
						arrLookup[tbox.options[i].text] = tbox.options[i].value;
						arrTbox[i] = tbox.options[i].text;
			 }
			 var fLength = 0;
			 var tLength = arrTbox.length
			 for(i=0; i<fbox.options.length; i++) {
						arrLookup[fbox.options[i].text] = fbox.options[i].value;
						if(fbox.options[i].selected && fbox.options[i].value != "") {
								 arrTbox[tLength] = fbox.options[i].text;
								 tLength++;
						} else {
								 arrFbox[fLength] = fbox.options[i].text;
								 fLength++;
						}
			 }
			 fbox.length = 0;
			 tbox.length = 0;
			 var c;
			 for(c=0; c<arrFbox.length; c++) {
						var no = new Option();
						no.value = arrLookup[arrFbox[c]];
						no.text = arrFbox[c];
						fbox[c] = no;
			 }
			 for(c=0; c<arrTbox.length; c++) {
				var no = new Option();
				no.value = arrLookup[arrTbox[c]];
				no.text = arrTbox[c];
				tbox[c] = no;
			 }
	}

	function selectAll(box) {
		for(var i=0; i<box.options.length; i++) {
			box.options[i].selected = true;
		}
	}

	function moveOptionUp(selectId)
	{
		var selectList = document.getElementById(selectId);
		var selectOptions = selectList.getElementsByTagName('option');
		for (var i = 1; i < selectOptions.length; i++) {
			var opt = selectOptions[i];
			if (opt.selected) {
				selectList.removeChild(opt);
				selectList.insertBefore(opt, selectOptions[i - 1]);
				return true;
			}
		}
	}

	function moveOptionDown(selectId)
	{
		var selectList = document.getElementById(selectId);
		var selectOptions = selectList.getElementsByTagName('option');
		for (var i = 0; i < selectOptions.length-1; i++) {
			var opt = selectOptions[i];
			if (opt.selected) {
				var next = selectOptions[i + 1];
				selectList.removeChild(next);
				selectList.insertBefore(next, selectOptions[i]);
				return true;
			}
		}
	}