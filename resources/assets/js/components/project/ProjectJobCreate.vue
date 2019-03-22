<template>
    <div v-if="positions">
        <div v-for="position in positions" :key="position.id">
            <div class="p-2 border-t-2 border-grey-lighter bg-grey-lighter">
                <div class="py-2">
                    <div class="md:flex">
                        <div class="w-full pb-4">
                            <label class="checkbox-control">
                                <h3 class="text-md">{{ position.name }}</h3>
                                <input type="checkbox"  v-model="needed['selected' + position.id]" :value="position.id" @change="selected(position.id)"/>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>
                </div>
                
                <project-job-form :position="position" :project="project" v-show="needed['selected' + position.id]" ></project-job-form>

            </div>
        </div>
    </div>
</template>

<script>
    import { alert } from '../../mixins'
    import { mapGetters } from 'vuex'
    import ProjectJobForm from './ProjectJobForm.vue'

    export default {
        props: {
            positions: {
                type: Array,
                required: true
            },
        },

        data() {
            return {
                lastPositionId: 0,
                needed: []
            }
        },

        mixins: [ 
            alert 
        ],
        
        components: {
            'project-job-form' : ProjectJobForm
        },

        computed:{
            ...mapGetters({
                project: 'project/project',
                selectedPosition: 'crew/selectedPosition'
            })
        },

        methods: {
            selected(id){
                this.needed[this.selectedPosition] = !! this.needed[this.selectedPosition]

                if(this.needed[this.selectedPosition]){
                    this.$store.commit('crew/SELECTED_POSITION', `selected${id}`)
                }

                let job = this.project.jobs.find(o => o.position_id == id)

                if (typeof(job) != 'undefined'){
                    job.position_id = id
                    this.$store.commit('project/JOB', job)
                }
            },
        },
    }
</script>