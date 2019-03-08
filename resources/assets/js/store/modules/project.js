import * as types from '../mutation-types'

export const state = {
    list: [],
    project: {},
    projectTypes: []
}

export const getters = {
    list(state) {
        return state.list
    },

    project(state) {
        return state.project
    },

    projectType(state) {
        return state.projectType
    },
}

export const mutations = {
    [types.PROJECT](state, payload) {
        state.project = payload
    },

    [types.PROJECTS](state, payload) {
        state.list = payload
    },

    [types.PROJECT_TYPES](state, payload) {
        state.projectType = payload
    },
}

export const actions = {
    fetch(context, role){
        axios.get('/api/' + role + '/projects')
             .then(
                response => context.commit(types.PROJECTS, response.data.data)
            )
    }
    //TODO: ajax request to get project types
}