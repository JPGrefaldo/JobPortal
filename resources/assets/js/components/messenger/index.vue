<template>
    <div class="flex flex-col h-full">
        <!-- top bar -->
        <div class="flex h-12 bg-grey-light">
            <search></search>
            <div class="w-4/5 text-md border-black border-b font-bold flex justify-center items-center">
                <div v-if="project.title">
                    {{ project.title }}: {{ thread.subject }}
                </div>
                <div v-else>No Project Selected</div>
            </div>
        </div>
        <!-- main -->
        <div class="flex h-full">
            <!-- left pane -->
            <div class="flex w-1/5 border-r border-black">
                <cca-projects :role="role" />
                <cca-threads :role="role"/>
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
    import Projects from './dashboard/Projects.vue'
    import Search from './dashboard/Search.vue'
    import Threads from './dashboard/Threads.vue'

    export default {
        name: "messaging",

        components: {
            'bottom-bar': BottomBar,
            'cca-messages': Messages,
            'cca-projects': Projects,
            'cca-threads': Threads,
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

        computed: {
            ...mapGetters({
                project: 'project/project',
                thread: 'thread/thread',
            })
        }
    }
</script>
