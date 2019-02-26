import * as types from '../mutation-types'

export const state = {
    project: {},
    list: [],
}

export const getters = {
    project(state) {
        return state.project
    },
    
    list(state) {
        return state.list
    },
}

export const mutations = {
    [types.PROJECT](state, payload) {
        state.project = payload
    },

    [types.PROJECTS](state, payload) {
        state.list = payload
    },
}

export const actions = {
    fetch(context, role){
        axios.get('/api/' + role + '/projects')
             .then(
                response => context.commit(types.PROJECTS, response.data.data)
            )
    }
}