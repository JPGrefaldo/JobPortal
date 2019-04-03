<template>
    <div>
        <div class="md:flex py-3">
            <div class="md:w-1/3 pr-6">
                <span class="block md:text-right mt-4 font-header text-blue-dark font-semibold mb-3">Select a department</span>  
            </div>
            <div class="md:w-2/3">
                <select class="form-control w-full text-grey-dark" v-model="department">
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
                        v-model="position" 
                >
                    <option v-for="item in positionsByDepartments" :key="item.id" :value="item.id">{{ item.name }}</option>
                </select>
            </div>
        </div>

        <div v-if="department && position">
            <project-job-form :mode="'create'" :submitProjectJob="submitProjectJob"></project-job-form>
        </div>
    </div>
</template>

<script>
    import { alert } from '../../mixins'
    import { mapGetters } from 'vuex'
    import ProjectJobForm from './ProjectJobForm.vue'

    export default {
        data() {
            return {
                allPositions: [],
                department: null,
                position: null
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
                departments: 'crew/departments',
                positions: 'crew/positions',
                job: 'project/job',
                project: 'project/project',

            }),

            positionsByDepartments: function() {
                if (this.allPositions.length === 0){
                    this.allPositions = this.positions
                }

                if (typeof(this.department) != 'undefined'){
                    return this.allPositions.filter(o => o.department_id == this.department)
                }
                
                return this.allPositions
            }
        },

        methods: {
            submitProjectJob(){
                if (!this.project.id) return

                this.$validator
                    .validateAll()
                    .then(() => {
                        if (this.$validator.errors.items.length === 0){
                            this.job.project_id  = this.project.id
                            this.job.position_id = this.position

                            this.$store.dispatch('project/saveProjectJob', this.job)
                            
                            this.resetState()
                            this.$swal(
                                        'Job Added!',
                                        'The job has been added.',
                                        'success'
                                    )
                        }
                    })
            },

            resetState(){
                this.department = null
                this.position   = null
                this.$store.commit('project/JOB', { persons_needed: 1})
            }
        },

        mounted() {
            this.$store.dispatch('crew/fetchByDepartments')
            this.$store.dispatch('crew/fetchByPositions')
        }
    }
</script>