Accounts.ui.config({
  passwordSignupFields: 'USERNAME_ONLY',
});

Template.registerHelper('facebookUserPicture', () => {
	if (Meteor.user() && Meteor.user().services && Meteor.user().services.facebook) {
		var user = Meteor.user();
		var facebookId = user.services.facebook.id;
		var pictureUrl = 'http://graph.facebook.com/' + facebookId + '/picture?type=square&height=160&width=160';
		return pictureUrl;
	}
});

Template.loginButtons.rendered = function() {
	Tracker.autorun(function() {
		Accounts._loginButtonsSession.get('dropdownVisible');
		Accounts._loginButtonsSession.set('dropdownVisible', true);
	});
};