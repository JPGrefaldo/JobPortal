import axios from 'axios';
import * as types from '../mutation-types';

// state
export const state = {
    user: null,
};

// getters
export const getters = {
    user: state => state.user,
};

// mutations
export const mutations = {
    [types.AUTH_FETCH_USER_SUCCESS](state, payload) {
        state.user = payload;
        localStorage.setItem('user', JSON.stringify(state.user));
    },

    [types.AUTH_LOGOUT](state) {
        state.user = null;
        localStorage.removeItem('user');
    },
};

// actions
export const actions = {
    async fetchUser({ commit }) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/user')
                .then(response => {
                    commit(types.AUTH_FETCH_USER_SUCCESS, response.data.user);
                    resolve(true);
                })
                .catch(e => {
                    resolve(e);
                });
        });
    },

    logout({ commit }) {
        commit(types.AUTH_LOGOUT);
    },
};
