<template>
    <div class="flex flex-col h-full">
        <!-- top bar -->
        <div class="flex h-12 bg-grey-light">
            <div class="w-1/5 border-b border-r border-black flex items-center justify-center px-2">
                <button class="fa fa-search mr-2"></button>
                <input type="text" class="hidden rounded-full bg-white flex-1 px-3 mr-2" placeholder="Search">
                <div class="bg-white rounded-full h-5 flex-1 pl-3 mr-2 text-grey">
                    Search
                </div>
                <button class="fa fa-edit"></button>
            </div>
            <div class="w-4/5 text-md border-black border-b font-bold flex justify-center items-center">
                <div v-if="project.title">
                    {{ project.title }}: {{ thread.subject }}
                </div>
                <!-- TODO: right chevron goes here that links to the current recipient -->
                <!-- might have to add logic depending on the role -->
            </div>
        </div>
        <!-- main -->
        <div class="flex h-full">
            <!-- left pane -->
            <div class="flex w-1/5 border-r border-black">
                <cca-projects :role="role" :projects="projects" @onClickSetProject="onClickSetProject" />
                <cca-threads :threads="threads" @onClickSetThread="onClickSetThread" />
            </div>
            <cca-messages :user="user" :role="role" :messages="messages" />
        </div>
        <!-- bottom bar -->
        <div class="flex h-12 w-screen">
            <div class="w-1/5 flex border-t border-r border-black">
                <button
                    class="flex-1 flex justify-center items-center"
                    v-for="(role, index) in roles" :key="index"
                    :class="getColorByRole(role)"
                    @click="onClickSetRole(index)"
                >
                    {{ role }}
                </button>
            </div>
            <div class="w-4/5 bg-grey-light flex justify-between items-center p-3">
                <input type="text" class="w-64 rounded-full flex-1 mr-2 px-3" placeholder="Aa">
                <button class="fa fa-paper-plane mr-1"></button>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import { Form, HasError, AlertError } from 'vform'
    import { mapGetters } from 'vuex'

    export default {
        name: "MessagesDashboardComponent",

        props: {
            user: {
                type: Object,
                required: true,
            },
            roles: {
                type: Array,
                required: true
            },
        },

        data() {
            return {
                role: this.roles[0],
                form: new Form({
                }),
                projects: [],
                project: {},
                threads: [],
                thread: {},
                messages: [],
            }
        },

        mounted() {
            this.getProjects(this.role)
        },

        methods: {
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

            onClickSetRole(index) {
                this.setRole(index)

                this.projects = []
                this.project = {}
                this.threads = []
                this.messages = []

                this.getProjects()
            },

            setRole(index) {
                this.role = this.roles[index]
            },

            getProjects() {
                this.form.get('/api/' + this.role.toLowerCase() + '/projects')
                    .then(response => (this.projects = response.data.data))
            },

            onClickSetProject(project) {
                this.setProject(project)

                this.threads = []
                this.thread = {}
                this.messages = []
                this.getThreads()
            },

            setProject(project) {
                this.project = project
            },

            getThreads() {
                this.form.get('/api/' + this.role.toLowerCase() + '/projects/' + this.project.id + '/threads')
                    .then(response => this.threads = response.data.data);
            },

            onClickSetThread(thread) {
                this.messages = []

                this.setThread(thread)
                this.getMessages(thread)
            },

            setThread(thread) {
                this.thread = thread
            },

            getMessages() {
                this.form.get('api/threads/' + this.thread.id + '/messages')
                    .then(response => (this.messages = response.data.data))
            },

        }
    }
</script>
