import * as types from '../mutation-types'

export const state = {
    list: [],
}

export const getters = {
    list(state) {
        return state.list
    }
}

export const mutations = {
    [types.MESSAGES](state, payload){
        state.list = payload
    }
}

export const actions = {
    fetch(context, thread) {
        axios.get('api/threads/' + thread + '/messages')
        .then(response => (context.commit(types.MESSAGES, response.data.data)))
    },
}