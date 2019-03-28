import * as types from '../mutation-types'

export const state = {
    job: {
        persons_needed: 1 
    },
    jobs:[],
    list: [],
    project: {
        production_name_public: true,
        remotes: []
    },
    types: []
}

export const getters = {
    job(state) {
        return state.job
    },

    jobs(state) {
        return state.jobs
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

    [types.JOBS](state, payload) {
        // When updating
        let i = state.jobs.findIndex(o => o.id === payload.id)
        if(i != -1){
            state.jobs[i] = payload
            return
        }

        // When getting data from the server
        if(payload.length > 1 || payload.length == 1 && state.jobs.length == 0){
            state.jobs = payload
            return
        }

        state.jobs.push(payload)
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

    fetchByTypes(context){
        axios.get('/api/producer/project/type')
             .then(response => {
                 context.commit(types.PROJECT_TYPES, response.data.projectType)
             })
    },

    fetchProjectJobs(context){
        return axios.get('/api/producer/project/jobs')
                    .then(response => {
                        context.commit(types.JOBS, response.data.jobs)
                    })
    },

    saveProject(context, project){
        return axios.post('/api/producer/projects', project)
    },

    saveProjectJob(context, job){
        return axios.post('/api/producer/project/jobs', job)
                    .then(response => {
                        context.commit(types.JOBS, response.data.job)
                    })
    },

    updateProject(context, project){
        return axios.put(`/api/producer/projects/${project.id}`, project)
    },

    updateProjectJob(context, job){
        return axios.put(`/api/producer/project/jobs/${job.id}`, job)
                    .then(response => {
                        context.commit(types.JOBS, response.data.job)
                    })
    },

    deleteProjectJob(context, job){
        return axios.delete(`/api/producer/project/jobs/${job}`)
    },
}