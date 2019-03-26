<template>
     <div class="card mb-8">
        <div class="w-full mb-6">
            <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Project details</h3>
        </div>
        <div class="md:flex py-3">
            <div class="md:w-1/3 pr-6">
                <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Project title</span>  
                <small class="block md:text-right text-red">{{ errors.first('title') }}</small>
            </div>
            <div class="md:w-2/3">
                <input 
                        class="form-control w-full" 
                        name="title" 
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
                <small class="block md:text-right text-red">{{ errors.first('Production Company') }}</small>
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
                    <input type="checkbox" v-model="project.production_name_public"/>
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
                                v-model="project.remotes"
                                @click="allSitesSelected"/>
                        <div class="control-indicator"></div>
                    </label>

                    <div v-show="isAllSitesNotChecked">
                        <label v-for="site in remotes" :key="site.id" class="checkbox-control mb-2">
                            {{ site.name }}
                            <input 
                                    name="Post add on these websites"
                                    type="checkbox"
                                    :checked="site.checked"
                                    @change="selected(site)"
                            >
                            <div class="control-indicator"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 pb-4 text-right border-t-2 border-grey-lighter">
            <input type="hidden" v-model="project.id" />
            <a href="#" class="text-grey bold mr-4 hover:text-green">Cancel</a>
            <button type="button" class="btn-green" @click="submitProject">SAVE CHANGES</button>
        </div>

        <div class="w-full pt-8 mt-8 mb-8 block border-t-2 border-grey-lighter">
            <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Work positions needed</h3>
        </div>

        <cca-project-job-create v-if="project.id"></cca-project-job-create>

        <project-job-list></project-job-list>
    </div>
</template>

<script>
    import { alert } from '../../mixins'
    import { mapGetters } from 'vuex'
    import ProjectJobCreate from './ProjectJobCreate.vue'
    import ProjectJobList from './ProjectJobList.vue'

    export default {
        props: {
            mode: {
                type: String,
                required: true
            }
        },

        mixins: [ 
            alert 
        ],

        components: {
            'cca-project-job-create': ProjectJobCreate,
            'project-job-list' : ProjectJobList
        },

        data() {
            return {
                isAllSitesNotChecked: true,
            }
        },

        mounted() {
            this.$store.dispatch('crew/fetchBySites')
            this.$store.dispatch('project/fetchByTypes')
        },

        computed: {
            ...mapGetters({
                project: 'project/project',
                projectTypes: 'project/types',
                sites: 'crew/sites',
            }),

            remotes: function(){
                let result = []

                this.sites.forEach(site => {
                    this.project.remotes.forEach(remote => {
                        if (site.id === remote.site_id){
                             site.checked = true
                        }
                    })
                    result.push(site)
                })
                return result
            },
        },

        methods: {
            allSitesSelected(){
                if (!this.isAllSitesNotChecked){
                    this.isAllSitesNotChecked = true
                    return
                }
                
                this.project.remotes = []
                this.isAllSitesNotChecked = false
            },

            selected(site){
                site.checked = !site.checked
                this.project.remotes = []
            },

            submitProject(){
                this.$validator.validateAll()

                if (this.errors.all().length == 0){
                    let endpoint = this.mode == 'edit' ? 'project/updateProject' : 'project/saveProject'

                    if(this.project.remotes.length != 1 && this.project.remotes[0] != 'all'){
                        this.project.remotes = this.getRemoteIds(this.sites.filter(site => site.checked))
                    }

                    this.$store
                        .dispatch(endpoint, this.project)
                        .then(response => {
                            this.displaySuccess(response)
                            this.$store.commit('project/PROJECT', response.data.project)
                        })
                }
            },

            getRemoteIds(remotes){
                let remoteIds = []

                remotes.forEach(remote => {
                    remoteIds.push(remote.id)
                })

                return remoteIds
            }
        }
    }
</script>