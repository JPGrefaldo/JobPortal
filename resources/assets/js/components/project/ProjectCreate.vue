<template>
    <main class="md:w-3/4 float-left">
        <div class="card mb-8">
            <div class="w-full mb-6">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Project details</h3>
            </div>
            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project title</span>  
                </div>
                <div class="md:w-2/3">
                    <input v-model="project.title" type="text" class="form-control w-full" placeholder="Project title">
                </div>
            </div>
            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-1 font-header text-blue-dark font-semibold mb-3">Production company name <br> <small class="font-normal text-grey">(or your name if individual)</small></span>  
                </div>
                <div class="md:w-2/3">
                    <input v-model="project.production_name" type="text" class="form-control w-full mb-4" placeholder="Company or individual name">
                    <label class="checkbox-control"><span class="text-grey text-sm">Show production company name publicly</span>
                        <input v-model="project.production_name_public" type="checkbox"/>
                        <div class="control-indicator"></div>
                    </label>
                </div>
            </div>
            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project type</span>  
                </div>
                <div class="md:w-2/3">
                    <select v-model="project.project_type_id" class="form-control w-full text-grey-dark">
                        <option v-for="projectType in projectTypes" :key="projectType.id" v-bind:value="projectType.id">{{ projectType.name }}</option>
                    </select>
                </div>
            </div>
            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project information</span>  
                </div>
                <div class="md:w-2/3">
                    <textarea v-model="project.description" class="form-control w-full h-48" placeholder="Project details"></textarea>
                </div>
            </div>

            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project city/area</span>  
                </div>
                <div class="md:w-2/3">
                    <input v-model="project.location" class="form-control w-full" type="text">
                </div>
            </div>

            <div class="py-6">
                <div class="md:flex">
                    <div class="md:w-1/3 pr-8">
                        <span class="font-bold font-header text-blue-dark block md:text-right mb-3">Post add on these websites:</span>
                    </div>
                    <div class="md:w-2/3 text-blue-dark">
                        <label class="checkbox-control mb-6">Check all
                            <input type="checkbox" v-model="project.sites" value="all" @click="allSitesSelected"/>
                            <div class="control-indicator"></div>
                        </label>

                        <div v-show="isAllSitesNotChecked">
                            <label v-for="site in sites" :key="site.id" class="checkbox-control mb-2">
                                {{ site.name }}
                                <input v-model="project.sites" :value="site.id" type="checkbox">
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full pt-8 mt-8 mb-8 block border-t-2 border-grey-lighter">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Work positions needed</h3>
            </div>
            <div v-if="departments">
                <ul class="flex list-reset rounded w-auto">
                    <li>
                        <input  class="hover:text-white hover:bg-blue text-blue border-r border-grey-light px-3 py-2"
                                v-model="department.name" type="button" 
                                v-for="department in departments" :key="department.id" 
                                @click="showByDepartment(department.id)">
                    </li>
                </ul>
            </div>

            <cca-position></cca-position>

            <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                <button type="button" class="btn-green" @click="submit">SAVE CHANGES</button>
            </div>

        </div>
    </main>
</template>

<script>
    import { alert } from '../../mixins'
    import { mapGetters } from 'vuex'
    import ErrorNotification from './ErrorNotification.vue'
    import ProjectJobCreate from './ProjectJobCreate.vue'

    export default {
        mixins: [ 
            alert 
        ],

        components: {
            'cca-position': ProjectJobCreate,
            'error-notification': ErrorNotification
        },

        data() {
            return {
                isAllSitesNotChecked: true,
                allPositions: [],
                errors: []
            }
        },

        mounted() {
            this.$store.dispatch('crew/fetchDepartments')
            this.$store.dispatch('crew/fetchSites')
            this.$store.dispatch('project/fetchTypes')
        },

        computed: {
            ...mapGetters({
                departments: 'crew/departments',
                positions: 'crew/positions',
                project: 'project/project',
                projectTypes: 'project/types',
                sites: 'crew/sites',
            })
        },

        methods: {
            submit(){
                if (! this.hasErrors()){
                    this.$store
                        .dispatch('project/saveProjectJob', this.project)
                        .then(response => this.displaySuccess(response))
                }
            },

            showByDepartment(id){
                if (this.allPositions.length === 0){
                    this.allPositions = this.positions
                }

                let positions = this.allPositions.filter(o => o.department_id == id)
                this.$store.commit('crew/POSITIONS', positions)
            },

            allSitesSelected(){
                this.project.sites = []
                
                if(this.isAllSitesNotChecked){
                    this.isAllSitesNotChecked = false
                    return
                }
                this.isAllSitesNotChecked = true
            },

            hasErrors(){
                this.errors = []

                if (! this.project.title){
                    this.errors.push('Project Title is required')
                }

                if (! this.project.production_name){
                    this.errors.push('Production Name is required')
                }

                if (! this.project.project_type_id){
                    this.errors.push('Project Type is required')
                }

                if (! this.project.description){
                    this.errors.push('Project Description is required')
                }

                if (! this.project.location){
                    this.errors.push('Area/City is required')
                }
                
                if (! this.project.production_name_public){
                    this.errors.push('Production Name Public is required')
                }

                if(this.project.jobs.length === 0){
                    this.errors.push('Position Needed is required')
                }

                if(this.project.sites.length == 0) {
                    this.errors.push('Post add on these websites is required')
                }

                if (this.errors.length > 0){
                    return true
                }

                return false
            }
        }
    }
</script>