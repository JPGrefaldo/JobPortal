<template>
  <div class="bg-white mt-4 rounded p-8 shadow">
     <job-info :job="job" :project="project"/>
    <div class="flex pt-6 mt-6 border-t-2 border-grey-lighter items-center justify-end">
      <a href="#" class="btn-outline bg-green text-white p-4">apply</a>
    </div>
  </div>
</template>

<script>
import TheProjectJobInfoCard from './TheProjectJobInfoCard';

export default {
    name: 'ProjectJobCard',
    components: { 'job-info': TheProjectJobInfoCard },
    props: {
        job: Object,
        project: Object,
    }
}
</script>