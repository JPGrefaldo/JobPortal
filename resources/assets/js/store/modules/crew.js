import * as types from '../mutation-types';

export const state = {
    department: {},
    departments: [],
    ignoredJobs: [],
    position: {},
    positions: [],
    selectedPosition: '',
    site: {},
    sites: [],
    submissions: [],
    existingCrewPositions: [],
    crewPositionInfo: [],
    crewPositionList: [],
};

export const getters = {
    department(state) {
        return state.department;
    },

    departments(state) {
        return state.departments;
    },

    ignoredJobs(state) {
        return state.ignoredJobs;
    },

    position(state) {
        return state.position;
    },

    positions(state) {
        return state.positions;
    },

    selectedPosition(state) {
        return state.selectedPosition;
    },

    site(state) {
        return state.site;
    },

    sites(state) {
        return state.sites;
    },

    submissions(state) {
        return state.submissions;
    },

    existingCrewPositions(state) {
        return state.existingCrewPositions;
    },

    crewPositionInfo(state) {
        return state.crewPositionInfo;
    },

    crewPositionList(state) {
        return state.crewPositionList;
    },
};

export const mutations = {
    [types.DEPARTMENT](state, payload) {
        state.department = payload;
    },

    [types.DEPARTMENTS](state, payload) {
        state.departments = payload;
    },

    [types.IGNORED_JOBS](state, payload) {
        state.ignoredJobs = payload;
    },

    [types.POSITION](state, payload) {
        state.position = payload;
    },

    [types.POSITIONS](state, payload) {
        state.positions = payload;
    },

    [types.SELECTED_POSITION](state, payload) {
        state.selectedPosition = payload;
    },

    [types.SITE](state, payload) {
        state.site = payload;
    },

    [types.SITES](state, payload) {
        state.sites = payload;
    },

    [types.SUBMISSIONS](state, payload) {
        state.submissions = payload;
    },

    [types.EXISTING_CREW_POSITIONS](state, payload) {
        state.existingCrewPositions = payload;
    },

    [types.CREW_POSITION_INFO](state, payload) {
        state.crewPositionInfo = payload;
    },

    [types.CREW_POSITION_LIST](state, payload) {
        state.crewPositionList = payload;
    },
};

export const actions = {
    fetchByDepartments(context) {
        axios.get('/api/crew/departments').then(response => {
            context.commit(types.DEPARTMENTS, response.data);
        });
    },

    fetchByPositions(context) {
        axios.get('/api/crew/positions').then(response => {
            context.commit(types.POSITIONS, response.data.positions);
        });
    },

    fetchBySites(context) {
        axios.get('/api/crew/sites').then(response => {
            context.commit(types.SITES, response.data.sites);
        });
    },

    fetchIgnoredJobs(context) {
        axios.get('/api/crew/jobs/ignored')
             .then(response => {
                 context.commit(types.IGNORED_JOBS, response.data.jobs);
             });
    },

    fetchSubmissions(context) {
        axios.get('/api/crew/jobs/submissions')
             .then(response => {
                 context.commit(types.SUBMISSIONS, response.data.jobs);
             });
    },

    checkExistingCrewPosition(context) {
        axios.get('/crew/crew-positions/check')
            .then(response => {
                context.commit(types.EXISTING_CREW_POSITIONS, response.data);
            });
    },

    fetchCrewPositionInfo(context) {
        axios.get('/crew/crew-positions/')
            .then(response => {
                context.commit(types.CREW_POSITION_INFO, response.data);
            });
    },

    updateCrewPositionInfo(context, data) {
        axios.put('/crew/positions/' + data.position, {
            bio              : data.bio,
            union_description: data.union_description,
            resume           : data.resume,
            reel_link        : data.reel_link,
            reel_file        : data.reel_file,
            gear             : data.gear,
            position         : data.position,
            method           : 'put'
        })
        .then(response => {
            window.location = '/crew/profile/edit';
        })
    },

    storeCrewPositionInfo(context, data) {
        axios.post('/crew/positions/' + data.position, {
            bio              : data.bio,
            union_description: data.union_description,
            resume           : data.resume,
            reel_link        : data.reel_link,
            reel_file        : data.reel_file,
            gear             : data.gear,
            position         : data.position,
            method           : 'post'
        })
        .then(response => {
            window.location = '/crew/profile/edit';
        })
    },

    checkPositionIfExist(context) {
        axios
            .get('/crew/positions/list')
            .then(response => {
                context.commit(types.CREW_POSITION_LIST, response.data);
            });
    },

    ignoreJob(context, jobId) {
        axios.post(`/api/crew/jobs/${jobId}/ignore`)
             .then(() => {
                 window.location.reload();
             });
    },

    unignoreJob(context, jobId) {
        axios.post(`/api/crew/jobs/${jobId}/unignore`)
             .then(() => {
                 window.location.reload();
             });
    }
};
