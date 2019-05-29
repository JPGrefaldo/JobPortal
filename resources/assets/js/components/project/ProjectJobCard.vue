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
          .get(`crew/jobs/${this.job.id}`)
          .then(({data}) => {
              if(data.submitted){
                  this.applied = true
              }
           });
       },

      applyJob: function(jobId){
        let content = `
          <div class="md:flex py-2">
            <textarea class="w-full form-control h-24" placeholder="Submission notes" id="note"></textarea>
          </div>
          `

        this.$swal({
          title: 'Add Notes',
          html: content,
          showCloseButton: true,
          confirmButtonText: 'Save and Apply'
        })
        .then(result => {
          if (result.value) {
            const content = this.$swal.getContent()
            const $       = content.querySelector.bind(content)
            const note    = $('textarea[id=note]').value
            const params  = {jobId:jobId, note:note}

            this.$store.dispatch('submission/store', params)

            // axios
            //   .post(`/crew/jobs/${jobId}`)
            //   .then(({data}) => {
            //       if(data.message == 'success'){
            //           this.applied = true
            //       }
            // }).catch( error => {
            //     if(error.response.status == 401){
            //       this.displayError("Please sign-in")
            //     }

            //     if(error.response.status == 400){
            //         this.displayError("Please upload a general resume")
            //     }
            // })
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