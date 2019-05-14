import * as types from '../mutation-types.js';


export const state = {
    submission: {},
    submissions: [],
    approvedSubmissions: []
};

export const getters = {
    submission(state) {
        return state.submission
    },

    submissions(state) {
        return state.submissions
    },

    approvedSubmissions(state) {
        return state.approvedSubmissions
    }
}

export const mutations = {
    [types.SUBMISSION](state, payload) {
        state.submission = payload
    },

    [types.SUBMISSIONS](state, payload) {
        state.submissions = payload
    },

    [types.APPROVED_SUBMISSIONS](state, payload) {
        state.approvedSubmissions = payload
    }
}

export const actions = {
    fetch(context, id) {
        axios.get(`/api/project/job/${id}/submissions`)
             .then(response => {
                 context.commit(types.SUBMISSIONS, response.data.submissions)
             })
    },

    fetchAllApproved(context, id) {
        return axios.get(`/api/producer/projects/jobs/${id}/submissions/all-approved`)
             .then(response => {
                 context.commit(types.APPROVED_SUBMISSIONS, response.data.submissions)
             })
    },

    approve(context, id) {
        axios.post(`/api/producer/projects/approve/submissions/${id}`)
    },

    reject(context, id) {
        axios.post(`/api/producer/projects/reject/submissions/${id}`)
    },

    restore(context, id) {
        axios.post(`/api/producer/projects/restore/submissions/${id}`)
    },

    swap(context, submissions) {
        axios.post(`/api/producer/projects/swap/submissions/${submissions.toReject}/${submissions.toApprove}`)
    }
}
