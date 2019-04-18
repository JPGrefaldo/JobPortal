<template>
    <main class="float-left w-full py-md md:py-lg px-3">
        <div class="container">
            <div class="w-full pb-8 border-b-2 mb-8 border-grey-light md:flex justify-between items-center">
                <h1 class="font-header text-blue-dark text-xl md:text-2xl font-semibold mb-3 md:mb-0">My projects</h1>
                <a class="btn-green-outline" href="/producer/projects/create">Add new project</a>
            </div>

            <div class="md:hidden w-full md:w-1/4 float-left md:mb-3">
                <div class="has-menu relative">
                    <div class="flex justify-between justify-center items-center rounded-lg w-full float-left mb-4 py-3 px-3 border border-grey-light bg-white cursor-pointer text-sm">
                        All projects
                        <span class="btn-toggle float-right"></span>
                    </div>
                    <div class="menu w-full shadow-md bg-white absolute py-3 font-body border text-sm border-grey-light">
                        <ul class="list-reset text-left">
                            <li class="py-2 px-4">
                                <a class="block text-blue-dark hover:text-green" href="#">View profile</a>
                            </li>
                            <li class="py-2 px-4">
                                <a class="block text-blue-dark hover:text-green" href="#">Subscription</a>
                            </li>
                            <li class="py-2 px-4">
                                <a class="block text-blue-dark hover:text-green" href="#">Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <ul class="hidden md:block list-reset font-header text-right px-md py-6">
                    <li class="block py-4">
                        <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#">Active projects</a>
                    </li>
                    <li class="block py-4">
                        <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#">Inactive projects</a>
                    </li>
                    <li class="block py-4">
                        <a class="text-blue-dark font-semibold py-2 border-b-2 border-red hover:text-green" href="#">Add
                            manager</a>
                    </li>
                    <li class="block py-4">
                        <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#">Pending projects</a>
                    </li>
                    <li class="block py-4">
                        <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#">Close account</a>
                    </li>
                </ul>
            </div>

            <aside class="hidden md:block w-1/4 float-left pr-4">
                <ul class="list-reset font-header text-left py-6">
                    <li class="block py-4">
                        <a :class="{'border-b-2 border-red ': activeTab == 'all'}" class="text-blue-dark font-semibold py-2 hover:text-green" href="#" @click.stop="loadProjects('all')">
                            All projects
                            <div class="badge bg-white ml-2">{{ projects.length }}</div>
                        </a>
                    </li>
                    <li class="block py-4">
                        <a :class="{'border-b-2 border-red ': activeTab == 'active'}" class="text-blue-dark font-semibold py-2 hover:text-green" href="#" @click.stop="loadProjects('active')">
                            Active projects
                            <div class="badge bg-white ml-2">{{ projectApprovedCount }}</div>
                        </a>
                    </li>
                    <li class="block py-4">
                        <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#" @click.stop="loadProjects('inactive')">
                            Inactive projects
                            <div class="badge bg-white ml-2">1000</div>
                        </a>
                    </li>
                    <li :class="{'border-b-2 border-red ': activeTab == 'pending'}" class="block py-4">
                        <a class="text-blue-dark font-semibold py-2 hover:text-green" href="#" @click.stop="loadProjects('pending')">
                            Pending projects
                            <div class="badge bg-white ml-2">{{ projectPendingCount }}</div>
                        </a>
                    </li>
                </ul>
                <div class="py-6 pr-8">
                    <h4 class="text-grey mb-4">HOW IT WORKS VIDEO</h4>
                    <a class="pb-66 h-none rounded relative block" href="#"
                       style="background: url(/images/th2.jpg); background-size:cover;">
                        <span class="btn-play w-10 h-10"></span>
                    </a>
                </div>
                <div class="">
                    <h4 class="text-grey leading-loose">Need help?
                        <br>
                        <a class="text-green" href="#">Contact support</a>
                    </h4>
                </div>
            </aside>

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
                            <div class="flex justify-between items-center">
                                <h3 class="text-blue-dark font-semibold text-md mb-1 font-header"> {{ job.position.name }} <span
                                        class="badge"><strong>{{ job.persons_needed }}</strong> needed</span></h3>
                                <div>
                                    <span class="h4 mr-2 text-yellow inline-block text-xs"><i
                                            class="fas fa-pause mr-1"></i>paused</span>
                                    <a class="btn-more inline-block" href="#"></a>
                                </div>
                            </div>
                            <div class="bg-grey-lighter rounded p-3 md:p-6 md:flex mt-4">
                                <div class="md:w-1/2 px-2">
                                    <div class="block text-sm text-blue-dark py-1">
                                        <strong>PAY:</strong> {{ pay(job.pay_rate, job.pay_type.name) }}
                                    </div>
                                    <div class="block text-sm text-blue-dark py-1">
                                        <strong>UNION</strong> (but accepting non-union submissions)
                                    </div>
                                    <div class="block text-sm text-blue-dark py-1">
                                        <strong>EQUIPMENT:</strong> provided by production
                                    </div>
                                </div>
                                <div class="md:w-1/2 px-2">
                                    <div class="block text-sm text-blue-dark py-1">
                                        <strong>PRODUCTION TITLE:</strong> {{ project.title }}
                                    </div>
                                    <div class="block text-sm text-blue-dark py-1">
                                        <strong>PRODUCTION COMPANY: </strong> {{ project.production_name }}
                                    </div>
                                    <div class="block text-sm text-blue-dark py-1">
                                        <strong>LOCATION: </strong> {{ project.location }}
                                    </div>
                                </div>
                            </div>
                            <div class="md:flex mt-6">
                                <div class="w-full md:w-1/4">
                                    <h4 class="text-grey mb-3 md:mb-0 mt-1">Project details</h4>
                                </div>
                                <div class="w-full md:w-3/4">
                                    <p> {{ project.description | truncate(truncLength) }}
                                        <a class="text-sm" href="#" @click.stop="showProjectJobModal(job)">MORE</a>
                                    </p>
                                </div>
                            </div>
                            <div class="md:flex mb-4 pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
                                <a class="h4 mr-6" href="#"><i class="fas fa-search mr-2"></i>Search staff for this
                                    position</a>
                                <a class="flex justify-between mt-4 md:mt-0 block btn-outline bg-green text-white"
                                   href="#">View
                                    submissions <span class="ml-4 badge badge-white">26</span></a>
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
    import { format, modals } from '../../mixins'
    import ProjectForm from '../project/ProjectJobForm.vue'
    import ProjectJobViewModal from '../project/ProjectJobCreateModal.vue'

    export default {
        mixins: [format, modals],

        components: {
            'project-form': ProjectForm,
            'project-job-view-modal': ProjectJobViewModal
        },

        data() {
            return {
                activeTab: 'all',
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
                projects: 'project/list',
                projectApprovedCount: 'project/approvedCount',
                projectPendingCount: 'project/pendingCount',
            })
        },

        methods: {
            loadProjects: function (type) {
                this.activeTab = type

                if(type === 'all') {
                    this.$store.dispatch('project/fetch')
                }

                if(type === 'active') {
                    this.$store.dispatch('project/fetchAllApproved')
                }

                if(type === 'pending') {
                    this.$store.dispatch('project/fetchAllPending')
                }
            },

            status: function(status) {
                return status == 0 ? 'NOT YET APPROVED' : 'APPROVED'
            },

            showProjectModal: function (project) {
                this.projectViewModal(project)
            },

            showProjectJobModal: function (job) {
                this.projectJobViewModal(job)
            },

            showRoleModal: function (project) {
                this.$store.commit('project/PROJECT', project)
                this.showModal = true
            }
        }
    }
</script>
