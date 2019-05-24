import * as types from '../mutation-types';

export const state = {
    list: [],
    participant: {},
    participants: [],
    thread: {},
};

export const getters = {
    list(state) {
        return state.list;
    },

    participant(state) {
        return state.participant;
    },

    participants(state) {
        return state.participants;
    },

    thread(state) {
        return state.thread;
    },
};

export const mutations = {
    [types.PARTICIPANT](state, payload) {
        state.participant = payload;
    },

    [types.PARTICIPANTS](state, payload) {
        state.participants = payload;
    },
    [types.THREAD](state, payload) {
        state.thread = payload;
    },
    [types.THREADS](state, payload) {
        state.list = payload;
    },
};

export const actions = {
    fetch(context, params) {
        axios
            .get('/api/' + params.role + '/projects/' + params.project + '/threads')
            .then(response => context.commit(types.THREADS, response.data.data));
    },

    searchParticipants(context, params) {
        axios
            .post(`/api/threads/${params.thread}/search`, { keyword: params.keyword })
            .then(response => {
                if (response.data.data) {
                    context.commit(types.PARTICIPANTS, response.data.data);
                }

                if (response.data.message) {
                    context.commit(types.PARTICIPANTS, response.data.message);
                }
            });
    },
};
