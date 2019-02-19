import {
	Notes
} from '/imports/api/note-schema.js';
import {
	NotesIndex
} from '/imports/api/note-search.js';

// noteSearch
Template.noteSearch.helpers({
	inputAttributes: function() {
		return {
			'id': 'noteSearch',
			'type': 'search',
		};
	},
	notesIndex: function() {
		return NotesIndex;
	},
});

// noteInput
Template.noteInput.helpers({
	textCount: function() {
		return Session.get('textCount');
	}
});
Template.noteInput.events({
	'keyup #noteField': function(event) {
		var $target = $(event.target);
		var $noteSubmit = $('.note-submit');
		var textMax = 1000;
		var textLength = $target.val().length;
		var textRemaining = textMax - textLength;
		var textClear = '';
		if ($target.val() !== '') {
			$noteSubmit.removeClass('disabled');
			Session.set('textCount', textRemaining);
		} else {
			$noteSubmit.addClass('disabled');
			Session.set('textCount', textMax);
		}
		if (event.ctrlKey && event.keyCode == 13) {
			event.preventDefault();
			$target.submit();
			Session.set('textCount', textMax);
			if ($target.val() !== '') {
				Materialize.toast('Flow!', 3000, 'rounded');
			}
		}
	},
	'submit': function(event) {
		event.preventDefault();
		var textMax = '1000';
		Session.set('textCount', textMax);
	},
});
Template.noteInput.onRendered(function() {
	var textMax = '1000';
	Session.set('textCount', textMax);
});

// noteList
Template.noteList.helpers({
	notes: function() {
		return Notes.find({});
	},
	resultsCount: function() {
		return NotesIndex.getComponentDict().get('count');
	},
	notesIndex: function() {
		return NotesIndex;
	},
	loadMoreAttributes: function() {
		return {
			class: 'btn waves-effect waves-light',
		};
	},
	noteMessage: function() {
		var getCount = Counts.get('notesCount');
		if (getCount < 1) {
			return 'Please Note...';
		}
	},
	noResultMessage: function() {
		var getCount = Counts.get('notesCount');
		if (getCount > 0) {
			return 'No Result!';
		}
	},
	modalContent: function() {
		return Session.get('modalContent');
	},
});
Template.noteList.onRendered(function() {
	$('.modal').modal();
});

// note
Template.noteItem.helpers({
	dateFormater: function(dateTime) {
		return moment(dateTime).fromNow();
	},
});
Template.noteItem.events({
	'click .note-remove': function(event) {
		event.preventDefault();
		Meteor.call('notes.remove', this._id);
	},
	'click .modal-trigger': function(event) {
		var $target = $(event.target);
		var $card = $target.parents('.card');
		var $modalText = $card.find('.note-text').html();
		Session.set('modalContent', $modalText);
	},
});