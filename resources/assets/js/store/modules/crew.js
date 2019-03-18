import * as types from '../mutation-types'

export const state = {
    department: {},
    departments: [],
    position: {},
    positions: [],
    site: {},
    sites: []
}

export const getters = {
    department(state){
        return state.department
    },

    departments(state){
        return state.departments
    },

    position(state){
        return state.position
    },

    positions(state){
        return state.positions
    },

    site(state){
        return state.site
    },

    sites(state){
        return state.sites
    },
}

export const mutations = {
    [types.DEPARTMENT](state, payload){
        state.department = payload
    },

    [types.DEPARTMENTS](state, payload){
        state.departments = payload
    },

    [types.POSITION](state, payload){
        state.position = payload
    },

    [types.POSITIONS](state, payload){
        state.positions = payload
    },

    [types.SITE](state, payload){
        state.site = payload
    },

    [types.SITES](state, payload){
        state.sites = payload
    },
}

export const actions = {
    fetchDepartments(context){
        axios.get('/api/crew/departments')
             .then(response => {
                 context.commit(types.DEPARTMENTS, response.data.departments)
             })
    },

    fetchPositions(context){
        axios.get('/api/crew/positions')
             .then(response => {
                 context.commit(types.POSITIONS, response.data.positions)
             })
    },

    fetchSites(context){
        axios.get('/api/crew/sites')
             .then(response => {
                 context.commit(types.SITES, response.data.sites)
             })
    }
}