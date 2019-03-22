<template>
    <main class="md:w-3/4 float-left">
        <div class="card mb-8">
            <div class="w-full mb-6">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Project details</h3>
            </div>
            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project title</span>  
                    <small class="block md:text-right text-red" v-show="errors.has('Project Title')">{{ errors.first('Project Title') }}</small>
                </div>
                <div class="md:w-2/3">
                    <input 
                          class="form-control w-full" 
                          name="Project Title" 
                          placeholder="Project title"
                          type="text" 
                          v-model="project.title" 
                          v-validate="'required'"
                    >
                </div>
            </div>
            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-1 font-header text-blue-dark font-semibold mb-3">Production company name <br> <small class="font-normal text-grey">(or your name if individual)</small></span>  
                    <small class="block md:text-right text-red" v-show="errors.has('Production Company')">{{ errors.first('Production Company') }}</small>
                </div>
                <div class="md:w-2/3">
                    <input 
                          class="form-control w-full mb-4" 
                          name="Production Company" 
                          placeholder="Company or individual name"
                          type="text" 
                          v-model="project.production_name" 
                          v-validate="'required'" 
                    >

                    <label class="checkbox-control"><span class="text-grey text-sm">Show production company name publicly</span>
                        <input v-model="project.production_name_public" type="checkbox"/>
                        <div class="control-indicator"></div>
                    </label>
                </div>
            </div>
            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project type</span>  
                    <small class="block md:text-right text-red" v-show="errors.has('Project Type')">{{ errors.first('Project Type') }}</small>
                </div>
                <div class="md:w-2/3">
                    <select 
                            class="form-control w-full text-grey-dark"
                            name="Project Type"
                            v-model="project.project_type_id" 
                            v-validate="'required'" 
                    >
                        <option v-for="projectType in projectTypes" :key="projectType.id" v-bind:value="projectType.id">{{ projectType.name }}</option>
                    </select>
                </div>
            </div>
            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project information</span>  
                    <small class="block md:text-right text-red" v-show="errors.has('Project Information')">{{ errors.first('Project Information') }}</small>
                </div>
                <div class="md:w-2/3">
                    <textarea 
                              class="form-control w-full h-48"
                              name="Project Information"
                              placeholder="Project details"
                              v-model="project.description"
                              v-validate="'required'"
                    ></textarea>
                </div>
            </div>

            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project city/area</span>  
                    <small class="block md:text-right text-red" v-show="errors.has('Project Location')">{{ errors.first('Project Location') }}</small>
                </div>
                <div class="md:w-2/3">
                    <input 
                          class="form-control w-full"
                          name="Project Location"
                          placeholder="Project location"
                          type="text"
                          v-model="project.location"
                          v-validate="'required'"
                    >
                </div>
            </div>

            <div class="py-6">
                <div class="md:flex">
                    <div class="md:w-1/3 pr-8">
                        <span class="font-bold font-header text-blue-dark block md:text-right mb-3">Post add on these websites:</span>
                        <small class="block md:text-right text-red" v-show="errors.has('Post add on these websites')">{{ errors.first('Post add on these websites') }}</small>
                    </div>
                    <div class="md:w-2/3 text-blue-dark">
                        <label class="checkbox-control mb-6">Check all
                            <input
                                  name="Post add on these websites"
                                  type="checkbox"
                                  value="all"
                                  v-model="project.sites"
                                  v-validate="'required'"
                                  @click="allSitesSelected"/>
                            <div class="control-indicator"></div>
                        </label>

                        <div v-show="isAllSitesNotChecked">
                            <label v-for="site in sites" :key="site.id" class="checkbox-control mb-2">
                                {{ site.name }}
                                <input 
                                      name="Post add on these websites"
                                      type="checkbox" 
                                      v-model="project.sites"
                                      :value="site.id">
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
                <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
                <button type="button" class="btn-green" @click="submitProject">SAVE CHANGES</button>
            </div>

            <div class="w-full pt-8 mt-8 mb-8 block border-t-2 border-grey-lighter">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Work positions needed</h3>
            </div>

            <!-- <cca-departments-tab></cca-departments-tab> -->

            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Select a department</span>  
                </div>
                <div class="md:w-2/3">
                    <select class="form-control w-full text-grey-dark" v-model="project.department">
                        <option disabled :selected="true">Please select one</option>
                        <option v-for="item in departments" :key="item.id" v-bind:value="item.id">{{ item.name }}</option>
                    </select>
                </div>
            </div>

            <div class="md:flex py-3">
                <div class="md:w-1/3 pr-6">
                    <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Select a position</span>  
                </div>
                <div class="md:w-2/3">
                    <select 
                            class="form-control w-full text-grey-dark"
                            name="position"
                            v-model="project.position" 
                    >
                        <option v-for="item in positionsByDepartments" :key="item.id" :value="item.id">{{ item.name }}</option>
                    </select>
                </div>
            </div>

            <cca-project-job-form :position="project.position" v-if="project.department && project.position"></cca-project-job-form>

            <div class="w-full pt-8 mt-8 mb-8 block border-t-2 border-grey-lighter">
                <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Project's Job Added</h3>
            </div>
            <div v-if="jobs">
                <div v-for="job in jobs" :key="job.id" class="flex mb-4 items-center">
                    <span class="w-full mt-4 font-header text-blue-dark font-semibold mb-3">{{job.position.name}}</span>
                    <button class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded bg-blue hover:bg-blue-dark text-white">Edit</button>
                    <button class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red hover:text-white hover:bg-red">Remove</button>
                </div>
            </div>

        </div>
    </main>
</template>

<script>
    import { alert } from '../../mixins'
    import { mapGetters } from 'vuex'
    import Departments from './Departments.vue'
    import ProjectJobForm from './ProjectJobForm.vue'

    export default {
        mixins: [ 
            alert 
        ],

        components: {
            'cca-departments-tab': Departments,
            'cca-project-job-form': ProjectJobForm
        },

        data() {
            return {
                allPositions: [],
                isAllSitesNotChecked: true,
                project: {
                    sites: []
                },
            }
        },

        mounted() {
            this.$store.dispatch('crew/fetchByDepartments')
            this.$store.dispatch('crew/fetchBySites')
            this.$store.dispatch('crew/fetchByPositions')
            this.$store.dispatch('project/fetchByTypes')
        },

        computed: {
            ...mapGetters({
                departments: 'crew/departments',
                positions: 'crew/positions',
                jobs: 'project/jobs',
                projectTypes: 'project/types',
                sites: 'crew/sites',
            }),

            positionsByDepartments: function() {
                if (this.allPositions.length === 0){
                    this.allPositions = this.positions
                }

                if (typeof(this.project.department) != 'undefined'){
                    return this.allPositions.filter(o => o.department_id == this.project.department)
                }
                
                return this.allPositions
            }
        },

        methods: {
            allSitesSelected(){
                if(this.isAllSitesNotChecked){
                    this.project.sites = []
                    this.isAllSitesNotChecked = false
                    return
                }
                this.isAllSitesNotChecked = true
            },

            submitProject(){
                this.$validator.validateAll()

                if (this.errors.all().length == 0){
                    this.$store
                        .dispatch('project/saveProject', this.project)
                        .then(response => {
                            this.displaySuccess(response)
                            this.$store.commit('project/PROJECT', response.data.project)
                        })
                }
            },
        }
    }
</script>