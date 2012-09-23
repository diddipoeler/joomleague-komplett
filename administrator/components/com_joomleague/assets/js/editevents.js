/**
 * @copyright Copyright (C) 2005-2012 JoomLeague.net. All rights reserved.
 * @license GNU/GPL, see LICENSE.php Joomla! is free software. This version may
 *          have been modified pursuant to the GNU General Public License, and
 *          as distributed it includes or is derivative of works licensed under
 *          the GNU General Public License or other free or open source software
 *          licenses. See COPYRIGHT.php for copyright notices and details.
 */

window.addEvent('domready', function() {
	updatePlayerSelect();
	if($('team_id')) {
		$('team_id').addEvent('change', updatePlayerSelect);

		//ajax remove event
		$ES('input.button-delete').addEvent('click', deleteevent);

		$('save-new').addEvent(
				'click',
				function() {
					var url = baseajaxurl + '&task=saveevent';
					var player = $('teamplayer_id').value;
					var event = $('event_type_id').value;
					var team = $('team_id').value;
					//var token = $('token').value;
					var time = $('event_time').value;
					if (team != 0 && event != 0) {
						var myXhr = new XHR( {
							method : 'post',
							onRequest : reqsent,
							onFailure : reqfailed,
							onSuccess : eventsaved
						});
						var querystring = 'teamplayer_id=' + player
								+ '&projectteam_id=' + team + '&event_type_id='
								+ event + '&event_time=' + time + '&match_id='
								+ matchid + '&event_sum='
								+ $('event_sum').value
								+ '&notice='
								+ $('notice').value
								//+ '&'
								//+ token
								;
						//alert(querystring);
						myXhr.send(url, querystring);
					}
				});
	}
	        $('save-new-comment').addEvent(
					'click',
					function() {
						var url = baseajaxurl + '&task=saveevent';
						var player = 0;
						var event = 0;
						var team = 0;
						var ctype = $('ctype').value;
						var comnt = $('notes').value
						var time = $('c_event_time').value;
						if (ctype != 0 && comnt != '') {
							var myXhr = new XHR( {
								method : 'post',
								onRequest : reqsent,
								onFailure : reqfailed,
								onSuccess : commentsaved
							});
							var querystring = 'teamplayer_id=' + player
									+ '&projectteam_id=' + team + '&event_type_id='
									+ event + '&event_time=' + time + '&match_id='
									+ matchid + '&event_sum='
									+ ctype + '&notes='
									+ comnt;
							myXhr.send(url, querystring);
						}
					});
	});

function reqsent() {
	$('ajaxresponse').addClass('ajax-loading');
	$('ajaxresponse').setText('');
}

function reqfailed() {
	$('ajaxresponse').removeClass('ajax-loading');
	$('ajaxresponse').setText(response);
}

function eventsaved(response) {
	$('ajaxresponse').removeClass('ajax-loading');
	// first line contains the status, second line contains the new row.
	var resp = response.split("\n");
	var td;
	if (resp[0] != '0') {
		// create new row in substitutions table
		var newrow = new Element('tr', {
			id : 'row-' + resp[0]
		});
		new Element('td').setText(
				$('team_id').options[$('team_id').selectedIndex].text)
				.injectInside(newrow);
		new Element('td')
				.setText(
						$('teamplayer_id').options[$('teamplayer_id').selectedIndex].text)
				.injectInside(newrow);
		new Element('td')
				.setText(
						$('event_type_id').options[$('event_type_id').selectedIndex].text)
				.injectInside(newrow);
		new Element('td').setText($('event_sum').value).injectInside(newrow);
		new Element('td').setText($('event_time').value).injectInside(newrow);
		new Element('td', {
			title : $('notice').value
		}).addClass("hasTip").setText(trimstr($('notice').value, 20)).injectInside(newrow);
		var deletebutton = new Element('input', {
			id : 'delete-' + resp[0],
			type : 'button',
			value : str_delete
		}).addClass('inputbox button-delete').addEvent('click', deleteevent);
		var td = new Element('td').appendChild(deletebutton).injectInside(newrow);
		newrow.injectBefore($('row-new'));
		$('ajaxresponse').setText('Event saved');
	} else {
		$('ajaxresponse').setText(resp[1]);
	}
}

	function commentsaved(response) {
		$('ajaxresponse').removeClass('ajax-loading');
		// first line contains the status, second line contains the new row.
		var resp = response.split("\n");
		var td;
		if (resp[0] != '0') {
			// create new row in comments table
			var newrow = new Element('tr', {
				id : 'row-' + resp[0]
			});
			new Element('td').injectInside(newrow);
			new Element('td').setText($('c_event_time').value).injectInside(newrow);
			new Element('td', {
				title : $('notes').value
			}).addClass("hasTip").setText($('notes').value).injectInside(newrow);
			var deletebutton = new Element('input', {
				id : 'delete-' + resp[0],
				type : 'button',
				value : str_delete
			}).addClass('inputbox button-delete').addEvent('click', deleteevent);
			var td = new Element('td').appendChild(deletebutton).injectInside(newrow);
			newrow.injectBefore($('row-new-comment'));
			$('ajaxresponse').setText('Comment saved').style.color='green';
		} else {
			$('ajaxresponse').setText(resp[1]).style.color='red';
		}
	}

function deleteevent() {
	var eventid = this.id.substr(7);

	var url = baseajaxurl + '&task=removeEvent';
	if (eventid) {
		var myXhr = new XHR( {
			method : 'post',
			onRequest : reqsent,
			onFailure : reqfailed,
			onSuccess : eventdeleted,
			rowid : eventid
		});
		var querystring = 'event_id=' + eventid;
		myXhr.send(url, querystring);
	}
}

function eventdeleted(response) {
	var resp = response.split("\n");
	if (resp[0] != '0') {
		var currentrow = $('row-' + this.options.rowid);
		currentrow.remove();
	}

	$('ajaxresponse').removeClass('ajax-loading');
	$('ajaxresponse').setText(resp[1]);
}

function updatePlayerSelect() {
	if($('cell-player'))
	$('cell-player').empty().appendChild(
			getPlayerSelect($('team_id').selectedIndex));
}
/**
 * return players select for specified team
 *
 * @param int )
 *            for home, 1 for away
 * @return dom element
 */
function getPlayerSelect(index) {
	// homeroster and awayroster must be defined globally (in the view calling
	// the script)
	var roster = rosters[index];
	// build select
	var select = new Element('select', {
		id : "teamplayer_id"
	});
	for ( var i = 0, n = roster.length; i < n; i++) {
		new Element('option', {
			value : roster[i].value
		}).setText(roster[i].text).injectInside(select);
	}
	return select;
}

function trimstr(str, mylength) {
	return (str.length > mylength) ? str.substr(0, mylength - 3) + '...' : str;
}