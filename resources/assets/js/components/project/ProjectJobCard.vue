<template>
  <div class="bg-white mt-4 rounded p-8 shadow">
     <job-info :job="job" :project="project"/>
    <div class="flex pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
      <button class="btn-outline bg-green text-white p-4" @click.prevent.stop="applyJob(job.id)" :disabled="applied">{{applied ? 'applied' : 'apply'}}</button>
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
      applyJob: function(job){
        axios
          .post(`/crew/job/${job}/apply`)
          .then(({data}) => {
         }).catch( error => {
            if(error.response.status == 401){
              this.displayError("Please sign-in")
            }
         })
      }
    }
}
</script>