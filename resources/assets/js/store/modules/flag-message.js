import axios from 'axios'

const state = {
    flags: []
}
const getters = {
    allFlags: (state) => state.flags
}

const actions = {
    async fetchFlags({ commit }) {
        const response = await axios.get('api/admin/flags')

        commit('setFlags', response.data)
    }
}

const mutations = {
    setFlags: (state, flags) => (state.flags = flags),
}

export default {
    state,
    getters,
    actions,
    mutations
}