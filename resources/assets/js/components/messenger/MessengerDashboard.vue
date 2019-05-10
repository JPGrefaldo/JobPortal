<template>
    <div class="flex flex-col h-full">
        <!-- top bar -->
        <div class="flex h-12 bg-grey-light">
            <search></search>
            <div
                class="w-4/5 text-md border-black border-b font-bold flex justify-center items-center"
            >
                <div v-if="project.title">{{ project.title }}: <a :href="'/users/' + user.hash_id + '/crew/profile'">{{ thread.subject }}</a></div>
                <div v-else>No Project Selected</div>
            </div>
        </div>
        <!-- main -->
        <div class="flex h-full">
            <!-- left pane -->
            <div class="flex w-1/5 border-r border-black">
                <cca-projects :role="role" />
                <cca-threads :role="role" />
            </div>
            <cca-messages :user="user" :role="role" />
        </div>
        <bottom-bar :roles="roles" :user="user"></bottom-bar>
    </div>
</template>

<script type="text/javascript">
import { mapGetters } from 'vuex';
import { Form, HasError, AlertError } from 'vform';
import MessengerDashboardBarAction from './MessengerDashboardBarAction.vue';
import MessengerDashboardBarSearch from './MessengerDashboardBarSearch.vue';
import MessengerDashboardProjectList from './MessengerDashboardProjectList.vue';
import MessengerDashboardThreadList from './MessengerDashboardThreadList.vue';
import MessengerMessages from './MessengerMessages.vue';

export default {
    name: 'messaging',

    components: {
        'bottom-bar': MessengerDashboardBarAction,
        'cca-messages': MessengerMessages,
        'cca-projects': MessengerDashboardProjectList,
        'cca-threads': MessengerDashboardThreadList,
        search: MessengerDashboardBarSearch,
    },

    props: {
        user: {
            type: Object,
            required: true,
        },
        roles: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            role: this.roles[0],
        };
    },

    computed: {
        ...mapGetters({
            project: 'project/project',
            thread: 'thread/thread',
        }),
    },
};
</script>
