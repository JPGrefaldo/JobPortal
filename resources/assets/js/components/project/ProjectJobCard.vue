<template>
    <div class="bg-white mt-4 rounded p-8 shadow">
        <job-info :job="job" :project="project" />
        <div class="flex pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
            <button class="btn-outline text-white p-4"
                :class="[applied ? 'bg-grey-light cursor-not-allowed' : 'bg-green']"
                @click.prevent.stop="applyJob(job.id)"
                :disabled="applied">{{applied ? 'applied' : 'apply'}}</button>
        </div>
    </div>
</template>

<script>
import TheProjectJobInfoCard from './TheProjectJobInfoCard';
import { alert } from '../../mixins';

export default {
    name: 'ProjectJobCard',
    mixins: [alert],
    components: { 'job-info': TheProjectJobInfoCard },
    props: {
        job: Object,
        project: Object,
    },
    data() {
      return {
        applied: false,
      }
    },
    methods: {
      checkSubmission: function(){
        axios
          .get(`crew/projects/submitted/jobs/${this.job.id}`)
          .then(({data}) => {
              if(data){
                  this.applied = true
              }
           });
       },

      applyJob: function(jobId){
        axios
          .post(`/crew/jobs/${jobId}/apply`)
          .then(({data}) => {
              if(data.message == 'success'){
                  this.applied = true
              }
         }).catch( error => {
            if(error.response.status == 401){
              this.displayError("Please sign-in")
            }

            if(error.response.status == 400){
                this.displayError("Please upload a general resume")
            }
         })
      }
    },
    mounted(){
        this.$nextTick(function () {
            this.checkSubmission();
        });
    }
}
</script>