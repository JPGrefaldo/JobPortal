import * as types from '../mutation-types'

export const state = {
    departments: [],
    positions: [],
    sites: []
}

export const getters = {
    departments(state){
        return state.departments
    },

    positions(state){
        return state.positions
    },

    sites(state){
        return state.sites
    },
}

export const mutations = {
    [types.DEPARTMENTS](state, payload){
        state.departments = payload
    },

    [types.POSITIONS](state, payload){
        state.positions = payload
    },

    [types.SITES](state, payload){
        state.sites = payload
    },
}

export const actions = {
    fetchPositions(context){
        axios.get('/api/crew/positions')
             .then(response => {
                 context.commit(types.POSITIONS, response.data.positions)
             })
    }
}