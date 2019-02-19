Meteor.methods({
	'notes.remove' (noteId) {
		Notes.remove(noteId);
	}
});

if (Meteor.isServer) {
	Meteor.publish('notes', function() {
		return Notes.find({
			owner: this.userId,
		});
	});
	Meteor.publish("users", function() {
		return Meteor.users.find({
			_id: this.userId,
		}, {
			fields: {
				'services.google.picture': 1,
				'services.google.email': 1,
				'services.facebook.id': 1,
				'services.facebook.email': 1,
			}
		});
	});
	Meteor.publish('notesCount', function() {
		Counts.publish(this, 'notesCount', Notes.find({
			owner: this.userId,
		}));
	});
}

if (Meteor.isClient) {
	Meteor.subscribe('notes');
	Meteor.subscribe('users');
	Meteor.subscribe('notesCount');
}