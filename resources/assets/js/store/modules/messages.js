import * as types from '../mutation-types'
let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

export const state = {
    data: [],
}

export const getters = {
    data(state) {
        return state.data
    }
}

export const mutations = {
    [types.MESSAGES](state, payload){
        state.data = payload
    }
}

export const actions = {
    fetch(context, thread) {
        axios.get('api/threads/' + thread + '/messages')
        .then(response => (context.commit(types.MESSAGES, response.data.data)))
    },
}