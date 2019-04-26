<template>
    <div class="flex flex-col h-full">
        <!-- top bar -->
        <div class="flex h-12 bg-grey-light">
            <div class="w-1/5 text-md border-black border-b font-bold flex justify-center items-center">
                Pending Projects
            </div>
            <div class="w-4/5 text-md border-black border-b font-bold flex justify-center items-center">
                Description
            </div>
        </div>
        <div class="flex h-full">
            <div class="flex w-1/5 border-r border-black">
                <div v-if="projects.length === 0"  class="w-full">
                    <div class="flex p-4 justify-center text-dark">
                        Select a project
                    </div>
                </div>
                <div v-else class="w-full">
                    <button
                        v-for="project in projects"
                        :key="project.id"
                        class="flex justify-center p-2 hover:bg-grey-light w-full text-left"
                        @click="onClickPendingProject(project.id)"
                    >
                        <div class="p-2 flex-1">
                            <div class="mb-1">{{ project.title }}</div>
                        </div>
                    </button>
                </div>
            </div>
            <div class="flex w-4/5 border-r border-black">
                <div v-if="selectedProject === null">
                    <div class="p-2 flex-1">
                        <div class="mb-1 text-grey">No selected item</div>
                    </div>
                </div>
                <div v-else class="w-full m-4">
                    <div class="bg-white shadow-md mb-8 rounded border border-grey-light">
                        <div class="bg-white shadow-md rounded border border-grey-light p-8">
                            <div class="w-full mb-6 flex justify-between">
                                <h3 class="text-blue-dark font-semibold text-lf mb-1 font-header">{{ projects[selectedProject - 1].title }}</h3>
                                <p>Production: {{ projects[selectedProject - 1].production }}</p>
                            </div>
                            <div class="md:flex">
                                <div class="md:w-1/4 mb-4 md:mb-0">
                                    <h3 class="text-grey">Details</h3>
                                </div>
                                <div class="md:w-3/4 mb-4 md:mb-0">
                                    <p>{{ projects[selectedProject - 1].description }}</p>
                                </div>
                            </div>
                            <div class="md:flex">
                                <div class="md:w-1/4 mb-4 md:mb-0">
                                    <h3 class="text-grey">Location</h3>
                                </div>
                                <div class="md:w-3/4 mb-4 md:mb-0">
                                    <p>{{ projects[selectedProject - 1].location }}</p>
                                </div>
                            </div>
                            <div class="md:flex">
                                <div class="md:w-1/4 mb-4 md:mb-0">
                                    <h3 class="text-grey">Owner</h3>
                                </div>
                                <div class="md:w-3/4 mb-4 md:mb-0">
                                    <p>{{ projects[selectedProject - 1].owner }}</p>
                                </div>
                            </div>
                            <div class="md:flex">
                                <div class="md:w-1/4 mb-4 md:mb-0">
                                    <h3 class="text-grey">Project Type</h3>
                                </div>
                                <div class="md:w-3/4 mb-4 md:mb-0">
                                    <p>{{ projects[selectedProject - 1].project_type }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-grey-lighter pb-2 md:pb-8 px-2 md:px-8 border-t border-grey-light rounded-b">
                            <div class="flex justify-between items-center pt-4">
                                <div>
                                    <a @click.prevent="onClickApproveProject()" class="btn-green-outline">
                                        Approve
                                    </a>
                                    <a @click.prevent="onClickDisapproveProject()" class="btn-green-outline">
                                        Disapprove
                                    </a>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { alert } from '../../mixins';

export default {
    data() {
        return {
            projects: [],
            selectedProject: null
        }
    },

    mixins: [alert],

    methods: {
        fetchPendingProjects: function() {
            axios.get('/api/admin/projects/unapproved')
                .then(response => {
                    this.projects = response.data.projects
                })
        },
        onClickPendingProject: function(projectId) {
            this.selectedProject = projectId
        },
        onClickApproveProject: function() {
            axios.put(`/admin/projects/${this.selectedProject}/approve`)
                .then(response => {
                    this.displaySuccess(response)
                    this.selectedProject = null
                    this.fetchPendingProjects()
                })
        },
        onClickDisapproveProject: function() {
            axios.put(`/admin/projects/${this.selectedProject}/unapprove`)
                .then(response => {
                    this.displaySuccess(response)
                    this.selectedProject = null
                    this.fetchPendingProjects()
                })
        }
    },
    mounted() {
        this.fetchPendingProjects()
    }
}
</script>

