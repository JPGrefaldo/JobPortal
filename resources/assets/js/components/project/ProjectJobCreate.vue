<template>
    <div v-if="positions">
        <div v-for="position in positions" :key="position.id">
            <div class="p-2 border-t-2 border-grey-lighter bg-grey-lighter">
                <div class="py-2">
                    <div class="md:flex">
                        <div class="w-full pb-4">
                            <label class="checkbox-control">
                                <h3 class="text-md">{{ position.name }}</h3>
                                <input type="checkbox" v-model="selectedPosition['selected' + position.id]" :value="position.id" @change="selected(position.id)"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <project-job-form  v-show="selectedPosition['selected' + position.id]" :position="position" :project="project"></project-job-form>

            </div>
        </div>
    </div>
</template>

<script>
    import { alert } from '../../mixins'
    import { mapGetters } from 'vuex'
    import ProjectJobForm from './ProjectJobForm.vue'

    export default {
        mixins: [ 
            alert 
        ],
        
        components: {
            'project-job-form' : ProjectJobForm
        },

        data() {
            return {
                lastPositionId: 0
            }
        },

        mounted(){
            this.$store.dispatch('crew/fetchPositions')
        },

        computed:{
            ...mapGetters({
                positions: 'crew/positions',
                project: 'project/project',
                selectedPosition: 'crew/selectedPosition'
            })
        },

        methods: {
            selected(id){
                this.hideOpenedPositionCard()

                if(typeof(this.project.jobs) != 'undefined'){
                    let job = this.project.jobs.find(o => o.position_id == id)

                     if (typeof(job) != 'undefined'){
                        job.position_id = id
                        this.$store.commit('project/JOB', job)
                        return
                    }
                }

                // Store the id globally to be used in hiding the the job fields 
                this.lastPositionId = id
                this.$store.commit('project/JOB', {})
            },

            hideOpenedPositionCard(){
                // Fixed overlapping open position card when multiple checkboxes is selected
                if (this.lastPositionId != 0){
                    this.selectedPosition[`selected${this.lastPositionId}`] = false
                }
            }
        }
    }
</script>