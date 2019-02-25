<template>
    <div class="flex flex-col h-full">
        <!-- top bar -->
        <div class="flex h-12 bg-grey-light">
            <search></search>
            <div class="w-4/5 text-md border-black border-b font-bold flex justify-center items-center">
                <!-- <div v-if="project.title">
                    {{ project.title }}: {{ thread.subject }}
                </div> -->
                <!-- TODO: right chevron goes here that links to the current recipient -->
                <!-- might have to add logic depending on the role -->
            </div>
        </div>
        <!-- main -->
        <div class="flex h-full">
            <!-- left pane -->
            <div class="flex w-1/5 border-r border-black">
                <cca-projects :role="role" @onClickSetProject="onClickSetProject" />
                <cca-threads :threads="threads" @onClickSetThread="onClickSetThread" />
            </div>
            <cca-messages :user="user" :role="role" />
        </div>
        <bottom-bar :roles="roles" :user="user" ></bottom-bar>
    </div>
</template>

<script type="text/javascript">
    import { mapGetters } from 'vuex'
    import { Form, HasError, AlertError } from 'vform'
    import BottomBar from './dashboard/BottomBar.vue'
    import Messages from './messages/index.vue'
    import Search from './dashboard/Search.vue'

    export default {
        name: "messaging",

        components: {
            'bottom-bar': BottomBar,
            'cca-messages': Messages,
            'search': Search
        },

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
                role: this.roles[0]
            }
        },

        mounted() {
            this.$store.dispatch('project/fetch', this.role)
        },

        computed: {
            ...mapGetters({
                project : 'project/project',
            })
        },

        methods: {
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

            onClickSetThread(thread) {
                this.messages = []

                this.setThread(thread)
                this.getMessages(thread)
            },

            setThread(thread) {
                this.thread = thread
            },
        }
    }
</script>
