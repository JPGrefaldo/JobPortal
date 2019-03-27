<template>
    <div>
        <div class="w-full pt-8 mt-8 mb-8 block border-t-2 border-grey-lighter">
            <h3 class="text-blue-dark font-semibold text-lg mb-1 font-header">Project's Job Added</h3>
        </div>

        <div v-if="jobs.length > 0">
            <div v-for="item in jobs" :key="item.id">
                <div class="flex mb-4 items-center">
                    <span class="w-full mt-4 font-header text-blue-dark font-semibold mb-3">{{item.position.name}}</span>
                    <button 
                        class="flex-no-shrink p-2 ml-4 mr-2 border-2 rounded bg-blue hover:bg-blue-dark text-white"
                        @click="edit(item)"
                    >
                        Edit
                    </button>
                    <button 
                        class="flex-no-shrink p-2 ml-2 border-2 rounded text-red border-red hover:text-white hover:bg-red"
                        @click="deleteProjectJob(item.id)"
                    >
                        Remove
                    </button>
                </div>

                <div v-if="jobId === item.id">
                    <project-job-form></project-job-form>
                    <div class="flex justify-center mt-4">
                        <button class="flex-grow btn-green" @click.stop="submitProjectJob">SAVE CHANGES</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
    import ProjectJobForm from './ProjectJobForm.vue'

    export default {
        components: {
            'project-job-form' : ProjectJobForm
        },

        data(){
            return {
                jobId: 0
            }
        },

        computed:{
            ...mapGetters({
                job: 'project/job',
                jobs: 'project/jobs',
            }),
        },

        methods: {
            edit(job){
                this.jobId = job.id
                this.$store.commit('project/JOB', job)
            },

            submitProjectJob() {
                this.$store
                    .dispatch('project/updateProjectJob', this.job)
                    .then(() => {
                        this.jobId = 0

                        this.$swal(
                            'Updated!',
                            'The job has been updated.',
                            'success'
                        )
                    })
                           
            },

            deleteProjectJob(job) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                         if(result.value) {
                             this.$store
                             .dispatch('project/deleteProjectJob', job)
                             .then(response => {
                                 if (response.data === 204) {
                                    location.reload()
                                }
                             })
                         }
                        
                })

            }
        }
    }
</script>