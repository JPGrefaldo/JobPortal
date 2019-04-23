<template>
    <main class="float-left w-full py-md md:py-lg px-3">
        <div class="container">

            <project-side-nav :projects="projects"></project-side-nav>

            <div class="w-full md:w-3/4 float-left" v-if="projects">
                <project-job-view-modal v-if="showModal" @close="showModal = false"></project-job-view-modal>
                
                <div 
                    class="bg-white shadow-md rounded mb-8 border border-grey-light"
                    v-for="project in projects"
                    :key="project.id"
                >
                    <div class="p-8">
                        <div class="w-full mb-6 flex justify-between">
                            <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">{{ project.title }}<span
                                    class="badge">24 submissions</span></h3>
                            <a class="btn-more" :href="`/producer/projects/edit/${project.id}`"></a>
                        </div>
                        <div class="md:flex">
                            <div class="md:w-1/4 mb-4 md:mb-0">
                                <h3 class="text-grey">Project details</h3>
                            </div>
                            <div class="md:w-3/4">
                                <p> {{ project.description | truncate(truncLength) }}
                                    <a class="text-sm" href="#" @click.stop="showProjectModal(project)">READ MORE</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-grey-lighter pb-2 md:pb-8 px-2 md:px-8 border-t border-grey-light rounded-b">
                        <div class="flex justify-between items-center pt-4">
                            <div>
                                <a class="h4" href="#">{{ project.jobs.length }} ROLES <span class="btn-toggle inline-block ml-1"></span></a>
                                <span class="badge bg-white ml-2">0 active</span>
                                <span class="badge bg-white">2 paused</span>
                            </div>
                            <a class="btn-outline" href="#" @click.stop="showRoleModal(project)">add role</a>
                        </div>

                        <div class="bg-white mt-4 rounded p-4 md:p-8 shadow" v-for="job in project.jobs" :key="job.id">
                            <project-info :job="job" :project="project"></project-info>

                            <div class="md:flex mb-4 pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
                                <a class="h4 mr-6" href="#"><i class="fas fa-search mr-2"></i>Search staff for this
                                    position</a>
                                <a class="flex justify-between mt-4 md:mt-0 block btn-outline bg-green text-white" :href="`/projects/${project.id}/jobs/${job.id}/submissions`">
                                    View submissions 
                                    <span class="ml-4 badge badge-white">26</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </main>
</template>

<script>
    import { mapGetters } from 'vuex'
    import { modals } from '../../mixins'
    import ProjectForm from '../project/ProjectJobForm.vue'
    import ProjectJobViewModal from '../project/ProjectJobCreateModal.vue'
    import TheProjectJobInfoCard from '../project/TheProjectJobInfoCard.vue'
    import TheProjectSideNav from '../TheProjectSideNav.vue'

    export default {
        mixins: [modals],

        components: {
            'project-form': ProjectForm,
            'project-job-view-modal': ProjectJobViewModal,
            'project-side-nav': TheProjectSideNav,
            'project-info': TheProjectJobInfoCard
        },

        data() {
            return {
                showModal: false,
                truncLength: 100
            }
        },

        created() {
            this.$store.dispatch('project/fetch')
            this.$store.dispatch('project/fetchAllApprovedCount')
            this.$store.dispatch('project/fetchAllPendingCount')
        },

        computed: {
            ...mapGetters({
                projects: 'project/list'
            })
        },

        methods: {
            status: function(status) {
                return status == 0 ? 'NOT YET APPROVED' : 'APPROVED'
            },

            showProjectModal: function (project) {
                this.projectViewModal(project)
            },

            showRoleModal: function (project) {
                this.$store.commit('project/PROJECT', project)
                this.showModal = true
            }
        }
    }
</script>
