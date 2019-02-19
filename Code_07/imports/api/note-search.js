import { Index, MinimongoEngine } from 'meteor/easy:search';

export const NotesIndex = new Index({
	collection: Notes,
	fields: ['text'],
	engine: new MinimongoEngine({
		sort() {
			return {
				createdAt: -1,
			}
		},
	}),
	defaultSearchOptions: {
		limit: 20,
	},
});