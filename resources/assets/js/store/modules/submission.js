import {
    SUBMISSION,
    SUBMISSIONS
} from '../mutation-types.js';


export const state = {
    submission: {},
    submissions: []
};

export const getters = {
    submission(state) {
        return state.submission
    },

    submissions(state) {
        return state.submissions
    }
}

export const mutations = {
    [SUBMISSION](state, payload) {
        state.submission = payload
    },

    [SUBMISSIONS](state, payload) {
        state.submissions = payload
    }
}

export const actions = {
    fetch(context, id) {
        axios.get(`/api/project/job/${id}/submissions`)
             .then(response => {
                 context.commit(response.data.submissions)
             })
    }
}
