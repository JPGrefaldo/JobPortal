<template>
    <main class="float-left w-full py-md md:py-lg px-3">
        <div class="container">
            <project-side-nav :projects="projects"></project-side-nav>
            
            <!-- Content Section
            ******************************************-->
            <div class="md:w-3/4 float-left">
                <div class="pb-4 md:pb-8">
                    <a href="/producer/projects" class="h4 text-grey">
                        <span class="btn-arrow-back mr-2 inline-block"></span>
                        Back to project list
                    </a>
                </div>

                <project-job-info class="bg-white mt-4 rounded p-4 md:p-8 shadow" :job="job" :project="project"></project-job-info>

                <!-- Submissions Section
                ******************************************-->
                <div class="py-6 md:flex justify-between">
                    <h3 class="text-md mb-3">Submissions
                        <span class="badge bg-white">{{submissions.length}}</span>
                    </h3>
                    <div class="block">
                        <a href="#" class="btn-outline inline-block mr-2 mb-1 md:mb-0">export "yes" selections</a>
                        <a href="#" class="btn-outline inline-block bg-green text-white">CONTACT ALL “YES” SELECTIONS</a>
                    </div>
                </div>

                <div class="md:hidden w-full md:w-1/4 float-left md:mb-3">
                    <div class="has-menu relative">
                        <div class="flex justify-between justify-center items-center rounded-lg w-full float-left mb-4 py-3 px-3 border border-grey-light bg-white cursor-pointer text-sm">
                            <div>Unseen
                                <span class="badge">5</span>
                            </div>
                            <span class="btn-toggle float-right"></span>
                        </div>
                        <div class="menu w-full shadow-md bg-white absolute py-3 font-body border text-sm border-grey-light">
                            <ul class="list-reset text-left">
                                <li class="py-2 px-4">
                                    <a href="#" class="block text-blue-dark hover:text-green">View profile</a>
                                </li>
                                <li class="py-2 px-4">
                                    <a href="#" class="block text-blue-dark hover:text-green">Subscription</a>
                                </li>
                                <li class="py-2 px-4">
                                    <a href="#" class="block text-blue-dark hover:text-green">Settings</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <ul class="hidden md:block list-reset font-header text-right px-md py-6">
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Subscription</a>
                        </li>
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Password</a>
                        </li>
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 border-b-2 border-red hover:text-green">Add manager</a>
                        </li>
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Notification setttings</a>
                        </li>
                        <li class="block py-4">
                            <a href="#" class="text-blue-dark font-semibold py-2 hover:text-green">Close account</a>
                        </li>
                    </ul>
                </div>

                <div class="hidden md:flex justify-between border-b-2 border-grey-light">
                    <div>
                        <ul class="list-reset flex items-center">
                            <li class="mr-4">
                                <a class="border-b-2 border-red block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green"
                                    href="#">unseen
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">seen
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="list-reset flex items-center">
                            <li class="mr-4">
                                <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                                    <span class="font-thin">"Yes"</span>
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>
                            <li class="mr-4">
                                <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                                    <span class="font-thin">"no"</span>
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="block py-4 tracking-wide block font-bold leading-none uppercase text-sm text-blue-dark hover:text-green" href="#">Marked
                                    <span class="font-thin">"maybe"</span>
                                    <span class="badge bg-white">5</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <!-- Cards Section
                ******************************************-->
                <div v-if="isCrewComplete(submissions)">
                    <h3 class="text-md py-6">Approved Submissions</h3>
                    <div class="w-full float-left grid-cards">
                        <div v-for="submission in submissions" :key="submission.id">
                            <submissions-card :job="job" :submission="submission" v-if="submission.approved_at !== null"></submissions-card>
                        </div>
                    </div>
                    <div class="border-2 border-gray-900 w-full float-left grid-cards"></div>
                        <div class="w-full float-left grid-cards">
                            <div v-for="submission in submissions" :key="submission.id">
                            <submissions-card :job="job" :submission="submission" v-if="submission.approved_at === null"></submissions-card>
                        </div>
                    </div>
                </div>
                <div class="w-full float-left py-6 grid-cards" v-else>
                    <div v-for="submission in submissions" :key="submission.id">
                        <submissions-card :job="job" :submission="submission"></submissions-card>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import { mapGetters } from 'vuex'
    import TheProjectSideNav from '../TheProjectSideNav.vue'
    import TheProjectJobInfoCard from '../project/TheProjectJobInfoCard.vue'
    import TheProjectJobSubmissionsCard from '../project/TheProjectJobSubmissionsCard.vue'

    export default {
        props: ['job', 'project', 'submissions'],

        components: {
            'project-side-nav' : TheProjectSideNav,
            'project-job-info' : TheProjectJobInfoCard,
            'submissions-card' : TheProjectJobSubmissionsCard
        },

        created: function() {
            this.$store.dispatch('project/fetch')
            this.$store.dispatch('project/fetchAllApprovedCount')
            this.$store.dispatch('project/fetchAllPendingCount')
        },

        computed: {
            ...mapGetters({
                'projects': 'project/list',
            })
        },

        methods: {
            isCrewComplete(submissions)
            {
                let approvedSubmissions = 0;
                for (let i=0; i<submissions.length; i++) {
                    if (!!submissions[i].approved_at) {
                        approvedSubmissions++
                    } 
                } 
 
                return this.job.persons_needed === approvedSubmissions
            }            
        }
    }
</script>