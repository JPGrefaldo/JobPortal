import axios from 'axios'
import * as types from '../mutation-types'

// state
export const state = {
    user: null
}

// getters
export const getters = {
    user: state => state.user
}

// mutations
export const mutations = {
    [types.AUTH_FETCH_USER_SUCCESS] (state, payload) {
        state.user = user
        localStorage.setItem('user', JSON.stringify(state.user))
    },

    [types.AUTH_LOGOUT] (state) {
        state.user = null
    }
}

// actions
export const actions = {
    async fetchUser ({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get('/api/user')
                .then(({ data }) => {
                    commit(types.AUTH_FETCH_USER_SUCCESS, {
                        user: data
                    })
                    resolve(true)
                }).catch(e => {
                    resolve(e)
                })
        })
    },

    logout ({ commit }) {
        commit(types.AUTH_LOGOUT)
    }
}
