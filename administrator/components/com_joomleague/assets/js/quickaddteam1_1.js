/**
 * provides autocomplete code for quickadd, for mootools 1.1
 */
Autocompleter.Ajax.JsonQuickAddTeam = Autocompleter.Ajax.Base.extend({

	queryResponse: function(resp) {
		this.setTeamid('');
		this.parent(resp);
		var choices = Json.evaluate(resp || false);		
		if (!choices || !choices.totalCount) return;
		this.updateChoices(choices.rows);
	},

	updateChoices: function(choices) {
//		console.log(choices);
		this.choices.empty();
		this.selected = null;
		if (!choices || !choices.length) return;
		if (this.options.maxChoices < choices.length) choices.length = this.options.maxChoices;
		choices.each(this.options.injectChoice || function(choice, i){
			var el = new Element('li', {'teamid': choice.id }).setHTML(this.markQueryValue(choice.name));
			el.inputValue = choice.name;
			this.addChoiceEvents(el).injectInside(this.choices);
		}, this);
		this.showChoices();
	},
	

	choiceSelect: function(el) {
		this.observer.value = this.element.value = el.inputValue;
		this.hideChoices();
		this.setTeamid(el.getProperty('teamid'));
		this.fireEvent('onSelect', [this.element], 20);
	},
	
	setTeamid: function(id) {
		$('cteamid').value = id;
	}
});

window.addEvent('domready',function () {
	var searchInput=$('quickadd');

	//A simple spinner div,display-toggled during request
	var indicator=new Element('div',{
	 class: 'autocompleter-loading',
	 styles: {'display': 'none'}
	}).injectAfter($('submit')); // appended after the input

	var completer=new Autocompleter.Ajax.JsonQuickAddTeam(searchInput,
	             quickaddsearchurl,{
		                 postVar: 'query',
		                 minLength: 3,
		                 onRequest: function(el) {
		                	 indicator.setStyle('display','');
		              },
		         onComplete: function(el) {
	     indicator.setStyle('display','none');
	 }
	});

});