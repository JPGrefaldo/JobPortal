import * as types from '../mutation-types'

export const state = {
    list: [],
    thread: {}
}

export const getters = {
    list(state) {
        return state.list
    },

    thread(state) {
        return state.thread
    }
}

export const mutations = {
    [types.THREAD](state, payload) {
        state.thread = payload
    },
    [types.THREADS](state, payload) {
        state.list = payload
    },
}

export const actions = {
    fetch(context, role) {
        axios.get('/api/' + role.toLowerCase() + '/projects/' + this.project.id + '/threads')
            .then(response => context.commit( types.THREADS, response.data.data) );
    },
}