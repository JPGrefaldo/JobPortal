<template>
    <div>
        <button class="btn btn-green float-right mt-2 py-3">Subscribe</button>
        <tabs>
            <tab :key="1" :name="'Open'" :active="'#open'">
                <project-job-card v-if="jobs" :jobs="jobs" :mode="'open'"></project-job-card>
                <h1 v-else>No open jobs available yet.</h1>
            </tab>
            <tab :key="2" :name="'Applied'"><h1>Applied</h1></tab>
            <tab :key="3" :name="'Ignored'">
                <project-job-card v-if="ignoredJobs" :jobs="ignoredJobs" :mode="'ignored'"></project-job-card>
                <h1 v-else>You don't have ignored job.</h1>
            </tab>
        </tabs>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import Tab from '../_partials/Tab.vue'
    import Tabs from '../_partials/Tabs.vue'
    import ProjectJobSmallInfoCard from '../_partials/Card/ProjectJobSmallInfoCard.vue'

    export default {
        props: {
            jobs: {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                index: 0
            }
        },

        components: {
            tab: Tab,
            tabs: Tabs,
            'project-job-card': ProjectJobSmallInfoCard
        },

        computed: {
            ...mapGetters({
                ignoredJobs: 'crew/ignoredJobs'
            })
        },

        created: function() {
            this.$store.dispatch('crew/fetchIgnoredJobs');
        }
    }
</script>