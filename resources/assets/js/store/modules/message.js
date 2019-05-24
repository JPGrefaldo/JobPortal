import * as types from '../mutation-types';

export const state = {
    list: [],
};

export const getters = {
    list(state) {
        return state.list;
    },
};

export const mutations = {
    [types.MESSAGES](state, payload) {
        state.list = payload;
    },
};

export const actions = {
    fetch(context, thread) {
        axios
            .get('api/messenger/threads/' + thread + '/messages')
            .then(response => context.commit(types.MESSAGES, response.data.data));
    },

    save(context, params) {
        axios.post('api/messenger/project/' + params.project + '/messages', params).then(response => {
            //TODO: Update the message list
        });
    },

    saveReply(context, params) {
        axios.put('api/messenger/threads/' + params.thread + '/messages', params).then(response => {
            //TODO: Update the message list
        });
    },

    saveAsTemplate(context, message) {
        return axios.post('/api/producer/messages/templates', message)
    }
};
