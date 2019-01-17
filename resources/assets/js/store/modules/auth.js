import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
    user: null,
    token: null,
}

// getters
export const getters = {
    user: state => state.user,
    token: state => state.token,
    check: state => state.user !== null
}

// mutations
export const mutations = {
    [types.AUTH_SAVE_TOKEN] (state, { token, remember }) {
        state.token = token
    },

    [types.AUTH_FETCH_USER_SUCCESS] (state, { user }) {
        state.user = user
    },

    [types.AUTH_LOGOUT] (state) {
        state.user = null
    }
}

// actions
export const actions = {
    saveToken ({ commit, dispatch }, payload) {
        commit(types.AUTH_SAVE_TOKEN, payload)
    },

    async fetchUser ({ commit }, payload) {
        return new Promise((resolve, reject) => {
            axios.get('/api/user')
                .then(({ data }) => {
                    commit(types.AUTH_FETCH_USER_SUCCESS, {
                        user: data
                    })
                    resolve(true)
                }).catch(e => {
                    resolve(false)
                })
        })
    },

    logout ({ commit }) {
        commit(types.AUTH_LOGOUT)
    }
}
