import * as types from '../mutation-types'

export const state = {
    job: {
        persons_needed: 1 
    },
    list: [],
    project: {
        jobs: [],
        sites: []
    },
    types: []
}

export const getters = {
    job(state) {
        return state.job
    },

    list(state) {
        return state.list
    },

    project(state) {
        return state.project
    },

    types(state) {
        return state.types
    },
}

export const mutations = {
    [types.JOB](state, payload) {
        state.job = payload
    },

    [types.PROJECT](state, payload) {
        state.project = payload
    },

    [types.PROJECTS](state, payload) {
        state.list = payload
    },

    [types.PROJECT_TYPES](state, payload) {
        state.types = payload
    },
}

export const actions = {
    fetch(context, role){
        axios.get('/api/' + role + '/projects')
             .then(
                response => context.commit(types.PROJECTS, response.data.data)
            )
    },

    fetchTypes(context){
        axios.get('/api/producer/project/type')
             .then(response => {
                 context.commit(types.PROJECT_TYPES, response.data.projectType)
             })
    },

    saveProjectJob(context, params){
        return axios.post('/api/producer/projects', params)
    }
}