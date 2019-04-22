import * as types from '../mutation-types';

export const state = {
    job: {
        persons_needed: 1,
    },
    project: {
        production_name_public: true,
        remotes: [],
    },
    approved: [],
    jobs: [],
    list: [],
    pending: [],
    types: [],
    approvedCount: 0,
    pendingCount: 0
};

export const getters = {
    approved(state) {
        return state.approved
    },

    approvedCount(state) {
        return state.approvedCount
    },

    job(state) {
        return state.job;
    },

    jobs(state) {
        return state.jobs;
    },

    list(state) {
        return state.list;
    },

    pending(state) {
        return state.pending;
    },

    pendingCount(state) {
        return state.pendingCount;
    },

    project(state) {
        return state.project;
    },

    types(state) {
        return state.types;
    },
};

export const mutations = {
    [types.PROJECT_APPROVED](state, payload) {
        state.approved = payload;
    },

    [types.PROJECT_APPROVED_COUNT](state, payload) {
        state.approvedCount = payload;
    },

    [types.JOB](state, payload) {
        state.job = payload;
    },

    [types.JOBS](state, payload) {
        // When updating
        let i = state.jobs.findIndex(o => o.id === payload.id);
        if (i != -1) {
            state.jobs[i] = payload;
            return;
        }

        // When getting data from the server
        if (payload.length > 1 || (payload.length == 1 && state.jobs.length == 0)) {
            state.jobs = payload;
            return;
        }

        state.jobs.push(payload);
    },

    [types.PROJECT_PENDING](state, payload) {
        state.pending = payload;
    },

    [types.PROJECT_PENDING_COUNT](state, payload) {
        state.pendingCount = payload;
    },

    [types.PROJECT](state, payload) {
        state.project = payload;
    },

    [types.PROJECTS](state, payload) {
        state.list = payload;
    },

    [types.PROJECT_TYPES](state, payload) {
        state.types = payload;
    },
};

export const actions = {
    fetch(context) {
        axios
            .get('/api/producer/projects')
            .then(response => context.commit(types.PROJECTS, response.data.projects));
    },

    fetchAllApproved(context) {
        axios.get('/api/producer/projects/approved')
            .then(response => context.commit(types.PROJECTS, response.data.projects));
    },

    fetchAllApprovedCount(context) {
        axios.get('/api/producer/projects/approved?count=true')
            .then(response => context.commit(types.PROJECT_APPROVED_COUNT, response.data.count));
    },

    fetchAllPending(context) {
        axios.get('/api/producer/projects/pending')
            .then(response => context.commit(types.PROJECTS, response.data.projects));
    },

    fetchAllPendingCount(context) {
        axios.get('/api/producer/projects/pending?count=true')
            .then(response => context.commit(types.PROJECT_PENDING_COUNT, response.data.count));
    },

    fetchByTypes(context) {
        axios.get('/api/producer/projects/type').then(response => {
            context.commit(types.PROJECT_TYPES, response.data.projectType);
        });
    },

    fetchProjectJobs(context) {
        return axios.get('/api/producer/projects/jobs').then(response => {
            context.commit(types.JOBS, response.data.jobs);
        });
    },

    saveProject(context, project) {
        return axios.post('/api/producer/projects', project);
    },

    saveProjectJob(context, job) {
        return axios.post('/api/producer/projects/jobs', job).then(response => {
            context.commit(types.JOBS, response.data.job);
        });
    },

    updateProject(context, project) {
        return axios.put(`/api/producer/projects/${project.id}`, project);
    },

    updateProjectJob(context, job) {
        return axios.put(`/api/producer/projects/jobs/${job.id}`, job).then(response => {
            context.commit(types.JOBS, response.data.job);
        });
    },

    deleteProjectJob(context, job) {
        return axios.delete(`/api/producer/projects/jobs/${job}`);
    },
};
