FlowRouter.route('/', {
	name: 'home',
	triggersEnter: [checkLoggedIn],
	action: function() {
		BlazeLayout.render('layout', {
			top: 'header',
			main: 'home',
			sidebar: 'sidebar',
		});
	}
});

FlowRouter.route('/login', {
	name: 'login',
	triggersEnter: [function() {
		Meteor.startup(function() {
			$('html, body').addClass('login-page');
		});
	}],
	action: function() {
		BlazeLayout.render('layout', {
			main: 'login',
		});
	},
	triggersExit: [function() {
		Meteor.startup(function() {
			$('html, body').removeClass('login-page');
		});
	}],
});

Accounts.onLogin(function() {
	FlowRouter.go('home');
});

function checkLoggedIn() {
	if (!Meteor.userId()) {
		FlowRouter.go('login');
	}
};

if (Meteor.isClient) {
	BlazeLayout.setRoot('body');
};