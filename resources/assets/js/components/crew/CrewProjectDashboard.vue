<template>
    <div>
        <tabs>
            <tab :key="1" :name="'Open'" :active="'#open'">
                <project-job-card v-if="jobs" :jobs="jobs">
                    <template v-slot:job="{ job }">
                        <div class="clearfix">
                            <div class="float-right mt-4">
                                <button class="btn-blue font-bold py-2" @click="ignoreJob(job.id)">Ignore</button>
                                <button class="btn-green font-bold py-2">Apply</button>
                            </div>
                        </div>
                    </template>
                </project-job-card>
                <h1 v-else>No open jobs available yet.</h1>

            </tab>
            <tab :key="2" :name="'Applied'">
                <project-job-card v-if="submissions" :jobs="submissions"></project-job-card>
                <h1 v-else>You haven't applied for a job yet.</h1>
            </tab>
            <tab :key="3" :name="'Ignored'">
                <project-job-card v-if="ignoredJobs" :jobs="ignoredJobs">
                    <template v-slot:job="{ job }">
                        <div class="clearfix">
                            <div class="float-right mt-4">
                                <button class="btn-blue font-bold py-2" @click="unignoreJob(job.id)">Unignore</button>
                            </div>
                        </div>
                    </template>
                </project-job-card>
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

        created: function() {
            this.$store.dispatch('crew/fetchIgnoredJobs');
            this.$store.dispatch('crew/fetchSubmissions');
        },

        components: {
            tab: Tab,
            tabs: Tabs,
            'project-job-card': ProjectJobSmallInfoCard
        },

        computed: {
            ...mapGetters({
                ignoredJobs: 'crew/ignoredJobs',
                submissions: 'crew/submissions'
            })
        },

        methods: {
            ignoreJob: function(id) {
                this.$store.dispatch('crew/ignoreJob', id)
            },

            unignoreJob: function(id) {
                this.$store.dispatch('crew/unignoreJob', id)
            }
        }
    }
</script>