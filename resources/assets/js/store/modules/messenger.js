export default {
    state: {
        // form: new Form({
        // }),
        crew: [
            'bg-green',
            'hover:bg-green-dark',
        ],
        producer: [
            'bg-blue',
            'hover:bg-blue-dark',
        ],
        messages: [],
        projects: [],
        threads: [],
        project: {},
        role: {},
        thread: {},
    },

    getters: {
        form(state) {
            return state.form
        },
        
        crew(state) {
            return state.crew
        },

        messages(state) {
            return state.messages
        },
        
        producer(state) {
            return state.producer
        },

        project(state) {
            return state.project
        },
        
        projects(state) {
            return state.projects
        },

        role(state) {
            return state.role
        },
        
        thread(state) {
            return state.thread
        },
        
        threads(state) {
            return state.threads
        },
    },

    mutations: {
        FORM(state, payload) {
            state.form = payload
        },

        CREW(state, payload) {
            state.crew = payload
        },

        MESSAGES(state, payload) {
            state.messages = payload
        },

        PROJECT(state, payload) {
            state.project = payload
        },

        PROJECTS(state, payload) {
            state.projects = payload
        },

        PRODUCER(state, payload) {
            state.producer = payload
        },

        ROLE(state, payload) {
            state.role = payload
        },

        THREAD(state, payload) {
            state.thread = payload
        },

        THREADS(state, payload) {
            state.threads = payload
        },   
    },

    actions: {
        getColorByRole: function (role) {
            const colorDictionary = {
                Producer: [
                    'bg-blue',
                    'hover:bg-blue-dark',
                ],
                Crew: [
                    'bg-green',
                    'hover:bg-green-dark',
                ]
            }

            return colorDictionary[role]
        },

        isSender: function (message) {
            return message.user_id === this.user.id
        },

        onClickRequestFlag: function (message) {
            this.requestFlag(message);
        },

        async requestFlag (message) {
            const result = await this.displayRequestFlagForm();

            if (!result.value) {
                return
            }

            const response = await this.submitRequestFlagForm(message, result)

            this.displaySuccess(response);
        },

        displayRequestFlagForm: function () {
            return this.$swal({
                title: 'Report this message',
                text: 'Help us understand what\'s happening with this message.',
                input: 'textarea',
                inputPlaceholder: 'Enter reason',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Flag message'
            });
        },

        submitRequestFlagForm: function (message, result) {
            this.form.message_id = message.id;
            this.form.reason = result.value;

            const response = this.form.post('/pending-flag-messages')

            this.form.message_id = '';
            this.form.reason = '';

            return response;
        },

        displaySuccess: function (response) {
            this.$swal({
                title: '',
                text: response.data.message,
                type: 'success',
            });
        }
    }
}