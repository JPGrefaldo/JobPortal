import * as types from '../mutation-types'

export const state = {
    project: {},
    projects: [],
}

export const getters = {
    project(state) {
        return state.project
    },
    
    projects(state) {
        return state.projects
    },
}

export const mutations = {
    [types.PROJECT](state, payload) {
        state.project = payload
    },

    [types.PROJECTS](state, payload) {
        state.projects = payload
    },
}

export const actions = {
    fetch(context, role){
        axios.get('/api/' + role.toLowerCase() + '/projects')
             .then(response => ( context.commit(types.PROJECTS, response.data )))
    }
}