export default {
    namespaced: true,

    state: () => ({
        sideBarOpen: true,
        windowFlow: 'columns',
        visibility: {},
    }),

    mutations: {
        'toggle-sidebar': (state) => {
            state.sideBarOpen = !state.sideBarOpen;
        },

        'window-flow': (state, {type}) => {
            state.windowFlow = type;
        },

        'register-column': (state, {column, defaultVisibility = true}) => {
            state.visibility[column] = defaultVisibility;
        },

        'toggle-column': (state, {column}) => {
            state.visibility[column] = !state.visibility[column];
        },
    },

    getters: {
        windowFlow: (state) => {
            return state.windowFlow;
        },

        columnVisibility: (state) => (column) => {
            return state.visibility[column]
        },

    },
};
