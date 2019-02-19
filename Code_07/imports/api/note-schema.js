import SimpleSchema from 'simpl-schema';
SimpleSchema.extendOptions(['autoform']);

Notes = new Mongo.Collection("notes");

Notes.allow({
  insert: function(userId, doc) {
    return !!userId;
  },
});
NoteSchema = new SimpleSchema({
  text: {
    type: String,
    label: "Note here!",
    min: 1,
    max: 1000,
    autoform: {
      type: 'textarea',
      tabindex: '1'
    },
  },
  owner: {
    type: String,
    autoform: {
      type: "hidden",
    },
    autoValue: function() {
      return this.userId;
    },
  },
  createdAt: {
    type: Date,
    autoform: {
      type: 'hidden',
    },
    autoValue: function() {
      return new Date();
    },
  },
}, {
  tracker: Tracker
});
Notes.attachSchema(NoteSchema);